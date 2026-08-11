<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyResponseField;
use App\Models\SurveyForm;
use App\Models\SurveyOpenPeriod;
use App\Models\PublishedForm;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
{

    public function storeResponse(Request $request, $form_id) {
        $validated = $request->validate([
            'fields' => 'required|array',
            'fields.*.field_id' => 'required|exists:survey_section_fields,id',
            'fields.*.section_id' => 'required|exists:survey_sections,id',
            'fields.*.value' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
            'batch_year' => 'required|exists:batch_year,batch_year',
            'survey_period_id' => 'required|exists:survey_open_periods,id'
        ]);
   
        // Check if a response already exists for the same form_id and user_id
        $existingResponse = SurveyResponse::where([
                'survey_form_id'    => $form_id,
                'user_id'    => $validated['user_id'],
                'program_id' => $validated['program_id'],
                'batch_year' => $validated['batch_year'],
                'survey_period_id' => $validated['survey_period_id']
            ])->exists();

        if ($existingResponse) {
            return response()->json(['error' => 'Response already exists for this user and form.'], 409);
        }

        $response = SurveyResponse::create([
            'survey_form_id' => $form_id,
            'user_id' => $validated['user_id'],
            'program_id' => $validated['program_id'],
            'batch_year' =>$validated['batch_year'],
            'survey_period_id' => $validated['survey_period_id']
        ]);

        foreach ($validated['fields'] as $fieldResponse) {
            try {
                SurveyResponseField::create([
                    'response_id' => $response->id,
                    'field_id' => $fieldResponse['field_id'],
                    'value' => $fieldResponse['value'],
                    'section_id' => $fieldResponse['section_id']
                ]);
            } catch (\Exception $e) {
                \Log::error('Error saving SurveyResponseField: ' . $e->getMessage());
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
                'fields.*.field_id' => 'required|exists:survey_section_fields,id',
                'fields.*.section_id' => 'required|exists:survey_sections,id',
                'fields.*.value' => 'nullable|string',
                'user_id' => 'required|exists:users,id',
                'program_id' => 'required|exists:users,program_id',
                'batch_year' => 'required|exists:batch_year,batch_year',
                'survey_period_id' => 'required|exists:survey_open_periods,id'
            ]);

            // Find the existing response
            $response = SurveyResponse::where([
                    'survey_form_id' => $form_id,
                    'user_id' => $validated['user_id'],
                    'survey_period_id' => $validated['survey_period_id']
                ])->firstOrFail();

            // Get all field IDs from the request
            $fieldIds = array_column($validated['fields'], 'field_id');

            // Delete fields that are no longer present
            SurveyResponseField::where('response_id', $response->id)
                ->whereNotIn('field_id', $fieldIds)
                ->delete();

            // Update or create each field
            foreach ($validated['fields'] as $fieldResponse) {
                SurveyResponseField::updateOrCreate(
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
        $response = SurveyResponse::with(['responseFields', 'user', 'program'])->findOrFail($response_id);
        $form = SurveyForm::findOrFail($response->survey_form_id);       
        $user;
        $program = null;
        $isViewResponse = false;
        $returnUrl = route('survey.user-survey-landing');
        $batch_year = null;
        $period = SurveyOpenPeriod::findOrFail($response->survey_period_id);
        $endpoint = route('survey.update-response', ['form_id' => $form->id]);
        $isResponseUpdate = false;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user()->load('programTaken');
            $program = $user->programTaken;
            $isViewResponse = true;
            $batch_year = $user->batch_year;
        } else if (Auth::guard('admin')->check()) {
            $user = $response->user;
            $program = Program::where('id', $user->program_id)->first();
            $returnUrl =  route('survey.survey-report-analysis', [
                'form_id' => $form->id, 'program_id' => $program->id, 'period_id' => $period->id, 'batch' => $user->batch_year]);
            $isViewResponse = true;
            $isResponseUpdate = true;
        }

        return view('survey.form.questionaire',
            compact('form', 'program', 'isViewResponse', 'response', 'returnUrl', 'user', 'batch_year', 'period', 'endpoint', 'isResponseUpdate'));
    }

    public function getResponse(Request $request)
    {
        $validated = $request->validate([
            'response_id' => 'required|exists:survey_responses,id'
        ]);

        try {
            $response = SurveyResponse::with(['responseFields'])
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
            'field_id' => 'required|exists:survey_section_fields,id',
            'section_id' => 'required|exists:survey_sections,id',
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:users,program_id',
            'batch_year' => 'required|exists:batch_year,batch_year',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ]);

        try {
            $file = $request->file('document');

            $response = SurveyResponse::where('survey_form_id', $form_id)->where('user_id', $validated['user_id'])->first();

            // Find existing response field
            $existingResponseField = SurveyResponseField::
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

            SurveyResponseField::updateOrCreate(
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
