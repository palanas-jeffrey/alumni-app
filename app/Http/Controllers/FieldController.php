<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Option;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->merge(['required' => filter_var($request->input('required'), FILTER_VALIDATE_BOOLEAN)]);

            $validated = $request->validate([
                'form_id' => 'required|exists:forms,id',
                'label' => 'required|string|max:1000',
                'type' => 'required|in:text,number,radio,checkbox,select,textarea,date',
                'required' => 'nullable|boolean', 
                'options' => 'nullable|array',
                'options.*' => 'required|string|max:255'
            ]);

            $field = Field::create([
                'form_id' => $validated['form_id'],
                'label' => $validated['label'],
                'type' => $validated['type'],
                'required' => $validated['required'] ?? false,
            ]);

            if (!empty($validated['options'])) {
                foreach ($validated['options'] as $optionValue) {
                    Option::create([
                        'field_id' => $field->id,
                        'value' => $optionValue
                    ]);
                }
            }

            return response()->json(['message' => 'Field created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a specific field.
     */
    public function show($id)
    {
        try {
            $field = Field::with('form')->findOrFail($id);

            return response()->json($field);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Field not found'], 404);
        }
    }

    public function showFieldWithOptions($id)
    {
        try {
            $field = Field::with(['form', 'options'])->findOrFail($id);
            return response()->json($field);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Field not found'], 404);
        }
    }

    /**
     * Update a specific field.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'required' => filter_var($request->input('required'), FILTER_VALIDATE_BOOLEAN),
        ]);
        
        try {
            $validated = $request->validate([
                'form_id' => 'sometimes|exists:forms,id',
                'label' => 'sometimes|required|string|max:255',
                'type' => 'sometimes|required|in:text,number,radio,checkbox,select,textarea',
                'required' => 'sometimes|boolean',
                'options' => 'nullable|array',
                'options.*.id' => 'nullable|exists:options,id',
                'options.*.value' => 'required|string|max:255',
            ]);

            $field = Field::findOrFail($id);

            $field->update([
                'label' => $validated['label'] ?? $field->label,
                'type' => $validated['type'] ?? $field->type,
                'required' => $validated['required'] ?? $field->required,
            ]);

            if (isset($validated['options'])) {
                $providedOptionIds = collect($validated['options'])->pluck('id')->filter()->toArray(); // Extract valid IDs

                $field->options()->whereNotIn('id', $providedOptionIds)->delete();

                foreach ($validated['options'] as $optionData) {
                    if (isset($optionData['id'])) {
                        $option = Option::findOrFail($optionData['id']);
                        $option->update(['value' => $optionData['value']]);
                    } else {
                        $field->options()->create(['value' => $optionData['value']]);
                    }
                }
            } else {
                $field->options()->delete();
            }

            return response()->json(['message' => 'Field and options updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Delete a specific field.
     */
    public function destroy($id)
    {
        try {
            $field = Field::findOrFail($id);
            $field->delete();

            return response()->json(['message' => 'Field deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteFieldAndOptions($id)
    {
        // Find the field by ID, along with its options
        $field = Field::with('options')->findOrFail($id);

        // Delete all related options
        $field->options()->delete();

        // Delete the field itself
        $field->delete();

        // Redirect or return a success message
        return redirect()->back()->with('success', 'Field and its options deleted successfully!');
    }
}