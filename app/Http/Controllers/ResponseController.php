<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\ResponseField;
use App\Models\Form;
use App\Models\FormSection;
use App\Models\FormSectionField;
use App\Models\PublishedForm;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ResponseController extends Controller
{

    public function storeResponse(Request $request, $form_id) {
        $validated = $request->validate([
            'fields' => 'required|array',
            'fields.*.field_id' => 'required|exists:form_section_fields,id',
            'fields.*.section_id' => 'required|exists:form_sections,id',
            'fields.*.value' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:users,program_id',
            'batch_year' => 'required|exists:batch_year,batch_year',
        ]);
   
        // Check if a response already exists for the same form_id and user_id
        $existingResponse = Response::where([
                'form_id'    => $form_id,
                'user_id'    => $validated['user_id'],
                'program_id' => $validated['program_id'],
                'batch_year' => $validated['batch_year']
            ])->exists();

        if ($existingResponse) {
            return response()->json(['error' => 'Response already exists for this user and form.'], 409);
        }

        $response = Response::create([
            'form_id' => $form_id,
            'user_id' => $validated['user_id'],
            'program_id' => $validated['program_id'],
            'batch_year' =>$validated['batch_year'],
        ]);

        foreach ($validated['fields'] as $fieldResponse) {
            try {
                ResponseField::create([
                    'response_id' => $response->id,
                    'field_id' => $fieldResponse['field_id'],
                    'value' => $fieldResponse['value'],
                    'section_id' => $fieldResponse['section_id']
                ]);
            } catch (\Exception $e) {
                \Log::error('Error saving ResponseField: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to save response field.'], 500);
            }
        }


        return response()->json(['message' => 'Response saved successfully!'], 201);
    }

    public function updateResponse(Request $request, $form_id)
    {
        try {
            $validated = $request->validate([
                'fields' => 'required|array',
                'fields.*.field_id' => 'required|exists:form_section_fields,id',
                'fields.*.section_id' => 'required|exists:form_sections,id',
                'fields.*.value' => 'nullable|string',
                'user_id' => 'required|exists:users,id',
                'program_id' => 'required|exists:users,program_id',
                'batch_year' => 'required|exists:batch_year,batch_year',
            ]);

            // Find the existing response
            $response = Response::where('form_id', $form_id)
                ->where('user_id', $validated['user_id'])
                ->firstOrFail();

            // Get all field IDs from the request
            $fieldIds = array_column($validated['fields'], 'field_id');

            // Delete fields that are no longer present
            ResponseField::where('response_id', $response->id)
                ->whereNotIn('field_id', $fieldIds)
                ->delete();

            // Update or create each field
            foreach ($validated['fields'] as $fieldResponse) {
                ResponseField::updateOrCreate(
                    [
                        'response_id' => $response->id,
                        'field_id' => $fieldResponse['field_id'],
                        'section_id' => $fieldResponse['section_id'],
                    ],
                    [
                        'value' => $fieldResponse['value'],
                    ]
                );
            }

            return response()->json(['message' => 'Response updated successfully!'], 200);

        } catch (\Exception $e) {
            \Log::error('Error updating response: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the response. Please try again later.'
            ], 500);
        }
    }

    public function viewResponse($response_id) {
        $response = Response::with(['responseFields', 'user', 'program'])->findOrFail($response_id);
        $form = Form::findOrFail($response->form_id);
        $user;
        $program = null;
        $isViewResponse = false;
        $returnUrl = "/tracer/participation";
        $batch_year = null;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user()->load('programTaken');
            $program = $user->programTaken;
            $isViewResponse = true;
            $batch_year = $user->batch_year;
        } else if (Auth::guard('admin')->check()) {
            $user = $response->user;
            $program = Program::where('id', $user->program_id)->first();
            $returnUrl = "/tracer/responses-per-program/" . $response->form_id . "/" . $response->program_id;
            $isViewResponse = true;
        }

        return view('tracer.form.questionaire',
            compact('form', 'program', 'isViewResponse', 'response', 'returnUrl', 'user', 'batch_year'));
    }

    public function getTracerResponse(Request $request)
    {
        $validated = $request->validate([
            'response_id' => 'required|exists:responses,id'
        ]);

        try {
            $response = Response::with(['responseFields'])
                ->findOrFail($validated['response_id']);

            return response()->json($response);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Response not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error'], 500);
        }
    }

    public function storeDocuments(Request $request, $form_id)
    {
        $validated = $request->validate([
            'field_id' => 'required|exists:form_section_fields,id',
            'section_id' => 'required|exists:form_sections,id',
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:users,program_id',
            'batch_year' => 'required|exists:batch_year,batch_year',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ]);

        try {
            $file = $request->file('document');

            $response = Response::where('form_id', $form_id)->where('user_id', $validated['user_id'])->first();

            // Find existing response field
            $existingResponseField = ResponseField::
                where([
                    'response_id' => $response->id,
                    'field_id' => $validated['field_id'],
                    'section_id' => $validated['section_id']
                    ])
                ->first();

            // Generate unique file name and store
            $uniqueName = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('documents', $uniqueName, 'public');

            // Delete old file if exists
            if ($existingResponseField && $existingResponseField->value) {
                Storage::disk('public')->delete($existingResponseField->value);
            }

            ResponseField::updateOrCreate(
                [
                    'response_id' => $response->id,
                    'field_id' => $validated['field_id'],
                    'section_id' => $validated['section_id'],
                ],
                [
                    'value' => $path,
                ]
            );

            return back()->with('success', 'Documents saved successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
}
