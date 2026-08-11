<?php

namespace App\Http\Controllers;

use App\Models\DonationMonetary;
use App\Models\DonationInKind;
use App\Models\DonationFacility;
use App\Models\DonationStatus;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use PDF;
use Illuminate\Validation\ValidationException;

class DonationController extends Controller
{
    public function showDonationPage()
    {
        return view('alumni.donation');
    }

    public function proccessPaymongoPaymongo(Request $request) 
    {
        $paymongo_secret_key = config('app.paymongo_secret_key');
        
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $validatedData['amount'];
        $encodedString = base64_encode($paymongo_secret_key);

        try {
            $client = new Client();
            $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
                'body' => json_encode([
                    'data' => [
                        'attributes' => [
                            'amount' => 100 * (float)$amount, //need to multiply to 100 for paymongo
                            'description' => 'School donation'
                        ]
                    ]
                ]),
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic '. $encodedString,
                    'content-type' => 'application/json',
                ],
            ]);

            $responseBody = $response->getBody(); 
            $responseData = json_decode($responseBody, true);
            $checkout_url = $responseData['data']['attributes']['checkout_url'];

            return response()->json([
                'success' => true,
                'message' => 'Paymongo link created successfully!',
                'checkout_url' => $checkout_url,
                'linkDetails' => $responseData['data'],
            ]);

        } catch (Exception $e) {
            Log::error('Error processing PayMongo payment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the request.',
            ], 500);
            
        }
    }

    public function getPaymongoPaymentStatus(Request $request) {
        $paymongo_secret_key = config('app.paymongo_secret_key');

        $validatedData = $request->validate([
            'paymongo_reference_no' => [
                'required'
            ],
            'user_id' => [
                'required'
            ]
        ]);
        
        $paymongo_reference_no = $validatedData['paymongo_reference_no'];
        $encodedString = base64_encode($paymongo_secret_key);

        try {
            $client = new Client();
            $response = $client->request(
                'GET', 
                'https://api.paymongo.com/v1/links/'. $paymongo_reference_no, [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic '. $encodedString,
                    'content-type' => 'application/json',
                ],
            ]);

            $responseBody = $response->getBody(); 
            $responseData = json_decode($responseBody, true);
            $status = $responseData['data']['attributes']['status'];
            $is_paid = $status == "paid" ? true : false;

            if ($is_paid) {
                $paymentData = $responseData['data']['attributes']['payments'][0]['data'] ?? null;
            
                if ($paymentData) {
                    $transaction_id = $paymentData['id'];
                    $amount = $paymentData['attributes']['amount'] / 100;
            
                    $donation_data = [
                        'user_id' => $validatedData['user_id'],
                        'mode_of_payment' => 'Paymongo',
                        'transaction_id' => $transaction_id,
                        'amount' => $amount,
                        'currency' => 'Php',
                        'status_id' => 1
                    ];
            
                    $transaction = DonationMonetary::where('transaction_id', $transaction_id)->first();
            
                    if (!$transaction) {
                        DonationMonetary::create($donation_data);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'is_paid' => $is_paid,
                'message' => 'payment status is: '. $status,
            ]);

        } catch (Exception $e) {
            Log::error('Error processing checking PayMongo link: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the request.',
            ], 500);
            
        }
    }

    public function getPayMongoTransactions() 
    {
        $paymongoTransactions;
        $paymongo_secret_key = config('app.paymongo_secret_key');
        $limit = '50';
    
        try {
            $client = new Client();
            $response = $client->request('GET', 'https://api.paymongo.com/v1/payments?limit=' . $limit, [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode($paymongo_secret_key),
                ],
            ]);
    
            $paymongoTransactions = json_decode($response->getBody(), true);

            return view('admin.donationLogs', ['paymongoTransactions' => $paymongoTransactions]);
        } catch (Exception $e) {
            return view('admin.donationLogs', ['error' => $e->getMessage()]);
        }
    
    }

    public function getDonationTransactions() 
    {
        $paymongoTransactions;
        $paymongo_secret_key = config('app.paymongo_secret_key');
        $limit = '50';
    
        try {
            $client = new Client();
            $response = $client->request('GET', 'https://api.paymongo.com/v1/payments?limit=' . $limit, [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode($paymongo_secret_key),
                ],
            ]);
    
            $paymongoTransactions = json_decode($response->getBody(), true);
            $monetaryDonations = DonationMonetary::with('user')->get();
            $inKindDonations = DonationInKind::with('user')->get();
            $facilityDonations = DonationFacility::with(['user', 'status'])->get();

            return view('donation.index', [
                'paymongoTransactions' => $paymongoTransactions,
                'monetaryDonations' => $monetaryDonations,
                'inKindDonations' => $inKindDonations,
                'facilityDonations' => $facilityDonations
            ]);
        } catch (Exception $e) {
            return view('donation.index', ['error' => $e->getMessage()]);
        }
    
    }

    public function showUserDonationHistory() {
        return view('donation.index');
    }

    public function generatePaymongoReport(Request $request)
    {
        $paymongoTransactions;
        $paymongo_secret_key = config('app.paymongo_secret_key');
        $limit = '50';
    
        try {
            $client = new Client();
            $response = $client->request('GET', 'https://api.paymongo.com/v1/payments?limit=' . $limit, [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode($paymongo_secret_key),
                ],
            ]);
    
            $rawResponse = json_decode($response->getBody(), true);
            $paymongoTransactions = $rawResponse['data'] ?? [];

            $pdf = PDF::loadView('pdf.donation-paymongo-report', ['paymongoTransactions' => $paymongoTransactions], [], 
                [
                    'orientation' => 'L',
                ]
            );

            return $pdf->stream('paymongo-transactions.pdf');

        } catch (RequestException $e) {
            \Log::error('PayMongo API Error: ' . $e->getMessage());
            return view('admin.donationLogs', ['error' => 'Failed to retrieve transactions from PayMongo.']);
        } catch (Exception $e) {
            \Log::error('Error Generating Report: ' . $e->getMessage());
            return view('admin.donationLogs', ['error' => $e->getMessage()]);
        }
    }

    public function saveMonetaryDonation(Request $request)
    {
        try{
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'mode_of_payment' => 'required|string|max:255',
                'transaction_id' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'currency' => 'required|string|max:255'
            ]);

            $donation = DonationMonetary::create([
                'user_id' => $request->user_id,
                'mode_of_payment' => $request->mode_of_payment,
                'transaction_id' => $request->transaction_id,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'status_id' => 1
            ]);

            return response()->json([
                'message' => 'Donation saved successfully!',
                'data' => $donation,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function saveInKindDonation(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'item_name' => 'required|string|max:255',
                'quantity' => 'required|numeric|min:0',
                'unit' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            ]);

            $donation = DonationInKind::create([
                'user_id' => $request->user_id,
                'item_name' => $request->item_name,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'status_id' => 1
            ]);

            return response()->json([
                'message' => 'Donation saved successfully!',
                'data' => $donation,
                'success' => true
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'success' => false
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatusMonetatyDonation(Request $request)
    {
        try{
            $validated = $request->validate([
                'donation_id' => 'required|exists:donation_monetary,id',
            ]);

            $donation = DonationMonetary::find($request->donation_id);

            $donation->status_id = 2;
            $donation->save();

            return response()->json([
                'message' => 'Donation status updated successfully!',
                'data' => $donation,
                'success' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    
    public function updateStatusInKindDonation(Request $request)
    {
        try{
            $validated = $request->validate([
                'donation_id' => 'required|exists:donation_in_kind,id',
            ]);

            $donation = DonationInKind::find($request->donation_id);

            $donation->status_id = 2;
            $donation->save();

            return response()->json([
                'message' => 'Donation status updated successfully!',
                'data' => $donation,
                'success' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function saveFacilityDonation(Request $request)
    {
        try{
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'facility' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
            ]);

            $donation = DonationFacility::create([
                'user_id' => $request->user_id,
                'facility' => $request->facility,
                'description' => $request->description,
                'status_id' => 1
            ]);

            return response()->json([
                'message' => 'Donation saved successfully!',
                'data' => $donation,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function updateStatusFacilityDonation(Request $request)
    {
        try{
            $validated = $request->validate([
                'donation_id' => 'required|exists:donation_facilities,id',
            ]);

            $donation = DonationFacility::find($request->donation_id);

            $donation->status_id = 2;
            $donation->save();

            return response()->json([
                'message' => 'Donation status updated successfully!',
                'data' => $donation,
                'success' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function generateMonetaryDonationReport(Request $request) {
        $userIds = [];

        $validated = $request->validate([
            'donor' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date']
        ]);

        $query = DonationMonetary::query();
        $donor = !empty($request->donor) ? $request->donor : null;

        if ($donor) {
            $accounts = User::where(function ($query) use ($donor) {
                $query->where('first_name', 'like', '%' . $donor . '%')
                    ->orWhere('last_name', 'like', '%' . $donor . '%');
            })->get();

            if ($accounts->isNotEmpty()) {
                $userIds = $accounts->pluck('id')->toArray();
                $query->whereIn('user_id', $userIds);
            }
        }

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($donor && empty($userIds)) {
            $monetaryDonations = null;
        } else {
            $monetaryDonations = $query->get();
        }

        if (collect($monetaryDonations)->isEmpty()) {
            $monetaryDonations = null;
        }

        $pdf = PDF::loadView('pdf.donation-report-monetary', ['monetaryDonations' => $monetaryDonations], [], [
            'orientation' => 'L',
        ]);

        return $pdf->stream('general-monetary-donations.pdf');
    }

    public function generateInKindDonationReport(Request $request) {
        $userIds = [];

        $validated = $request->validate([
            'donor' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date']
        ]);

        $query = DonationInKind::query();
        $donor = !empty($request->donor) ? $request->donor : null;
        
        if ($donor) {
            $accounts = User::where(function ($query) use ($donor) {
                $query->where('first_name', 'like', '%' . $donor . '%')
                    ->orWhere('last_name', 'like', '%' . $donor . '%');
            })->get();

            if ($accounts->isNotEmpty()) {
                $userIds = $accounts->pluck('id')->toArray();
                $query->whereIn('user_id', $userIds);
            }
        }

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($donor && empty($userIds)) {
            $inKindDonations = null;
        } else {
            $inKindDonations = $query->get();
        }

        if (collect($inKindDonations)->isEmpty()) {
            $inKindDonations = null;
        }

        $pdf = PDF::loadView('pdf.donation-report-in-kind', ['inKindDonations' => $inKindDonations], [], 
            [
                'orientation' => 'L',
            ]
        );
        return $pdf->stream('in-kind-donations.pdf');
    }

    public function generateFacilityDonationReport(Request $request) {
        $userIds = [];

        $validated = $request->validate([
            'donor' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date']
        ]);

        $query = DonationFacility::query();
        $donor = !empty($request->donor) ? $request->donor : null;

        if ($donor) {
            $accounts = User::where(function ($query) use ($donor) {
                $query->where('first_name', 'like', '%' . $donor . '%')
                    ->orWhere('last_name', 'like', '%' . $donor . '%');
            })->get();

            if ($accounts->isNotEmpty()) {
                $userIds = $accounts->pluck('id')->toArray();
                $query->whereIn('user_id', $userIds);
            }
        }
        
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($donor && empty($userIds)) {
            $facilityDonations = null;
        } else {
            $facilityDonations = $query->get();
        }

        if (collect($facilityDonations)->isEmpty()) {
            $facilityDonations = null;
        }

        $pdf = PDF::loadView('pdf.donation-report-facility', ['facilityDonations' => $facilityDonations], [], 
            [
                'orientation' => 'L',
            ]
        );
        return $pdf->stream('facility-donations.pdf');
    }
}
