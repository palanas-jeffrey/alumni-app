<?php

namespace App\Livewire\Donation;

use Livewire\Component;
use App\Models\DonationMonetary;
use App\Models\DonationFacility;
use App\Models\DonationStatus;
use App\Models\User;
use App\Models\DonationPaymentMethod;
use Illuminate\Support\Facades\DB;

class Monetary extends Component
{
    public $transactionDonor;
    public $startDate;
    public $endDate;
    public $monetaryDonations;
    public $userIds = [];
    public $paymentMethods = [];
    public $paymentMethodInput;
    public $pendingFinancial = 0;
    
    public function mount()
    {
        $this->monetaryDonations = DonationMonetary::with('user')->get();
        $this->paymentMethods = DonationPaymentMethod::pluck('method_name', 'id')->toArray();
        $this->pendingFinancial = DonationMonetary::where('status_id', 1)->count();
    }
    
    public function render()
    {
        $query = DonationMonetary::query();

        if ($this->transactionDonor) {
            $accounts = User::where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->transactionDonor . '%')
                      ->orWhere('last_name', 'like', '%' . $this->transactionDonor . '%');
            })->get();

            if ($accounts->isNotEmpty()) {
                $this->userIds = $accounts->pluck('id')->toArray();
                $query->whereIn('user_id', $this->userIds);
            }
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        if ($this->transactionDonor && empty($this->userIds)) {
            $this->monetaryDonations = null;
        } else {
            $this->monetaryDonations = $query->get();
        }

        if (collect($this->monetaryDonations)->isEmpty()) {
            $this->monetaryDonations = null;
        }

        return view('livewire.donation.monetary');
    }
}