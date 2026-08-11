<?php

namespace App\Http\Controllers;

use App\Models\UAEvent;
use App\Models\EventPhoto;
use App\Models\EventDate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use PDF;
use Illuminate\Http\Request;

class UAEventController extends Controller
{
    public function index()
    {
        $uaEvent = (object) [
            'event_name' => '',
            'description' => '',
            'event_date' => '',
            'start_time' => '',
            'duration' => '',
            'venue' => ''
        ];

        return view('admin.eventManagement', compact('uaEvent'));
    }

    public function showEvents()
    {
        return view('alumni.events');
    }

    public function showEvent($id)
    {
        // Fetch a specific event by its ID with its associated photo
        $uaEvent = UAEvent::with('photo', 'eventDates')->find($id);

        // Handle the case where the event is not found
        if (!$uaEvent) {
            abort(404, 'Event not found');
        }
        
        // Extract all event_date values
        $eventDatesArray = array_map(function($item) {
            return $item['event_date'];
        }, $uaEvent->eventDates->toArray());

        $eventDatesStr = implode(', ', $eventDatesArray);

        return view('admin.eventEdit', compact('uaEvent', 'eventDatesStr'));
    }

    public function showPreviousEvent($id)
    {
        $uaEvent = UAEvent::with('photo', 'eventDates')->find($id);

        // Handle the case where the event is not found
        if (!$uaEvent) {
            abort(404, 'Event not found');
        }
        
        $eventDatesArray = array_map(function($item) {
            return $item['event_date'];
        }, $uaEvent->eventDates->toArray());

        $eventDatesStr = implode(', ', $eventDatesArray);
        $isPrevious = true;

        return view('admin.eventEdit', compact('uaEvent', 'eventDatesStr', 'isPrevious'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Create a new event
            $validatedEvent = $request->validate([
                'event_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date_format:H:i',
                // 'duration' => 'nullable|integer|min:1',
                'venue' => 'required|string|max:255',
            ]);

            $savedEvent = UAEvent::create($validatedEvent);
            $eventId = $savedEvent->id;

            if (!$savedEvent || !$savedEvent->id) {
                throw new \Exception('Failed to create the event!');
            }

            $validated_event_dates = $request->validate([
                'selected_dates' => 'required|array',
                'selected_dates.*' => 'date|after_or_equal:' . date('Y-m-d')
            ]);

            foreach ($validated_event_dates['selected_dates'] as $date) {
                EventDate::create(['event_id' => $eventId, 'event_date' => $date]);
            }

            // Validate and save photo if uploaded
            if ($request->hasFile('photo')) {
                $validatedPhoto = $request->validate([
                    'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $uniqueName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('photo', $uniqueName, 'public');

                $photo = new EventPhoto();
                $photo->alumni_event_id = $eventId;
                $photo->photo_path = $path;
                $photo->image_type = $request->file('photo')->getMimeType(); 
                $photo->save();
            }

            DB::commit();

            return response()->json(['message' => 'Event and photo saved successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        // Validation rules for updating UAEvent fields
        $validatedEvent = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'nullable|integer|min:1',
            'venue' => 'required|string|max:255',
        ]);

        $isPrevious = filter_var($request->input('is_previous'), FILTER_VALIDATE_BOOLEAN);

        try {
            $uaEvent = UAEvent::findOrFail($id);

            $uaEvent->update($validatedEvent);

            $validated_event_dates;
            $isPrevious = $isPrevious ?? false;

            if ($isPrevious)
            {
                $validated_event_dates = $request->validate([
                    'selected_dates' => 'required|array',
                    'selected_dates.*' => 'date',
                ]);
            } else 
            {
                $validated_event_dates = $request->validate([
                    'selected_dates' => 'required|array',
                    'selected_dates.*' => 'date|after_or_equal:' . date('Y-m-d')
                ]);
            }
            
            EventDate::where('event_id', $id)->delete();

            foreach ($validated_event_dates['selected_dates'] as $date)
            {
                EventDate::create(['event_id' => $id, 'event_date' => $date]);
            }

            // Check if a new photo is uploaded
            if ($request->hasFile('photo')) {
                // Validation for photo field
                $validatedPhoto = $request->validate([
                    'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                // Store the new photo file
                $uniqueName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('photo', $uniqueName, 'public');

                // Check if the event already has an associated photo
                $photo = EventPhoto::where('alumni_event_id', $id)->first();

                if ($photo) {
                    // Delete the old photo file from storage
                    \Storage::disk('public')->delete($photo->photo_path);

                    // Update the photo record with the new file path
                    $photo->photo_path = $path;
                    $photo->image_type = $request->file('photo')->getMimeType();
                    $photo->save();
                } else {
                    // Create a new photo record if none exists
                    $photo = new EventPhoto();
                    $photo->alumni_event_id = $id;
                    $photo->photo_path = $path;
                    $photo->image_type = $request->file('photo')->getMimeType();
                    $photo->save();
                }
            }

            return response()->json(['message' => 'Event updated successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $uaEvent = UAEvent::find($id);

        if (!$uaEvent) {
            return redirect()->back()->withErrors(['error' => 'Resource not found']);
        }

        $uaEvent->delete();
        
        return redirect()->back()->with('status', 'Resource deleted successfully');
    }

    // public function generateReport(Request $request)
    // {
    //     $uaEvents = UAEvent::get(); // Retrieve all records from UAEvent
    //     $pdf = PDF::loadView('pdf.events', ['uaEvents' => $uaEvents], [], 
    //         [
    //             'orientation' => 'L',
    //         ]
    //     );
    //     return $pdf->stream('events.pdf'); // Stream the generated PDF
    // }
}