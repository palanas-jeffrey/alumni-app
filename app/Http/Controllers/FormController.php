<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function viewTracerOverview()
    {
        return view('admin.tracerManagement');
    }

    public function viewFormList()
    {
        $forms = Form::all();

        return view('tracer.forms-table', compact('forms'));
    }

    public function show($id)
    {
        $form = Form::findOrFail($id);

        return view('admin.formManagement', compact('form'));
    }


    // Store form data in the database
    public function store(Request $request)
    {
        try{
            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'course' => 'nullable|string',
                'batch_year' => 'nullable|string',
                'publish_year' => 'nullable|string'
            ]);

            // Create a new form record
            Form::create($validated);
                
            return response()->json(['message' => 'saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    // update form data in the database
    public function update(Request $request, $form_id)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'course' => 'nullable|string',
                'batch_year' => 'nullable|string',
                'publish_year' => 'nullable|string'
            ]);

            // Fetch the existing form record by ID
            $form = Form::findOrFail($form_id);

            // Update the record with the validated data
            $form->update($validatedData);

            return response()->json(['message' => 'Updated successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $form = Form::with(['sections.fields'])->findOrFail($id);

            foreach ($form->sections as $section) {
                $section->fields()->delete();
                $section->delete();
            }

            $form->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Form deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function publish(Request $request) 
    {
        try {
            $validatedData = $request->validate([
                'form_id' => [
                    'required',
                    'exists:forms,id',
                ],
            ]);

            //unpublish a published form if existing
            $published = Form::where('isPublished', 1)->first();
            
            if ($published) {
                $published->isPublished = 0;
                $published->save();
            }

            $form = Form::findOrFail($validatedData['form_id']);
            $form->isPublished = 1;
            $form->save();

            return response()->json([
                'success' => true,
                'message' => 'Form is now published!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to publish form.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function unpublish(Request $request) 
    {
        try {
            $validatedData = $request->validate([
                'form_id' => [
                    'required',
                    'exists:forms,id',
                ],
            ]);

            $form = Form::findOrFail($validatedData['form_id']);
            $form->isPublished = 0;
            $form->save();

            return response()->json([
                'success' => true,
                'message' => 'Form is now unpublished!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to unpublish form.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}