<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    public function sendSms(Request $request)
    {
        $sid = config('app.twilio_sid');
        $token = config('app.twilio_auth_token');
        $twilio_number = config('app.twilio_number');
        $twilio = new Client($sid, $token);

        $messageBody = $request->input('message'); // Extract message
        $recipients = User::select('full_name', 'mobile_number')
            ->whereNotNull('mobile_number')
            ->where('mobile_number', '!=', '')
            ->get();

        $results = [];

        foreach ($recipients as $recipient) 
        {
            try {
                $message = $twilio->messages
                ->create($recipient->mobile_number,
                [
                    "from" => $twilio_number, // Sender's number
                    "body" => $messageBody  // Message body
                ]);
                $results[] = [
                    'recipient' => $recipient,
                    'status' => 'success',
                    'sid' => $message->sid
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'recipient' => $recipient,
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'results' => $results,
            'is_executed' => true
        ], 200); 
    }

}
