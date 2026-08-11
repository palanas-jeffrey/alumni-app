<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Mail\SendEventEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\UAEvent;

class EmailNotification extends Component
{
    public $notificationMessage;
    public $uaEvent;
 
    public function mount($eventId = null)
    {
        if ($eventId) 
        {
            $uaEvent = UAEvent::with('eventDates')->find($eventId);
            $this->uaEvent = $uaEvent;
            $scheduleDates;

            if ($uaEvent->eventDates) {

                    $groupedEvents = $uaEvent->eventDates->groupBy(function ($event_date) 
                        {
                            return date('F', strtotime($event_date->event_date));
                        });

                    foreach ($groupedEvents as $month => $events) {
                        // Sort events by day ascending
                        $sortedEvents = $events->sortBy(function ($event_date) {
                            return strtotime($event_date->event_date);
                        });

                        $dayStr = "";
                        $counter = 1;

                        foreach ($sortedEvents as $event_date) {
                            $dayStr .= date('j', strtotime($event_date->event_date));
                            $dayStr .= $counter != count($sortedEvents) ? ", " : "";
                            $counter++;
                        }

                        $scheduleDates = $month . " " . $dayStr;
                    }

                }

                $this->notificationMessage = "Greetings, you're invited to " . $uaEvent->event_name
                ." ! 🗓️ Join us on " .  $scheduleDates 
                . " at " . date('H:i', strtotime($uaEvent->start_time)) . ". See you there!";
        }
    }

    public function sendNotificationEmailEvent()
    {
        $messageContent = $this->notificationMessage;
        $recipients = User::whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        if ($recipients->isEmpty()) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        $results = [];
    
        foreach ($recipients as $recipient) {
            try {
                $userName = $recipient->first_name;
    
                Mail::to($recipient->email)->send(new SendEventEmail($userName, $messageContent));
    
                $results[] = [
                    'email' => $recipient->email,
                    'status' => 'Sent'
                ];

                $this->dispatch("event-email-notification-sent");
            } catch (\Exception $e) {
                $results[] = [
                    'email' => $recipient->email,
                    'status' => 'Failed',
                    'error' => $e->getMessage()
                ];

                $this->dispatch("event-email-notification-failed");
            }
        }

        $this->dispatch("event-email-notification-process-end");
    }

    public function render()
    {
        return view('livewire.events.email-notification');
    }
}
