<?php

namespace App\Livewire\Donation;

use Livewire\Component;
use App\Models\DonationFacility;
use App\Models\User;

class Facility extends Component
{
    public $transactionDonor;
    public $startDate;
    public $endDate;
    public $facilityDonations;
    public $userIds = [];
    public $pendingFacility = 0;

    public function mount()
    {
        $this->facilityDonations = DonationFacility::with('user')->get();
        $this->pendingFacility = DonationFacility::where('status_id', 1)->count();
    }

    public function render()
    {
         $query = DonationFacility::query();

        if ($this->transactionDonor) {
            $accounts = User::where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->transactionDonor . '%')
                      ->orWhere('last_name', 'like', '%' . $this->transactionDonor . '%');
            })->get();

            if ($accounts->isNotEmpty()) {
                $this->userIds = $accounts->pluck('id')->toArray();
                $query->whereIn('user_id', $this->userIds);
            } else {
                $this->userIds = [];
            }
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        if ($this->transactionDonor && empty($this->userIds)) {
            $this->facilityDonations = null;
        } else {
            $this->facilityDonations = $query->get();
        }

        if (collect($this->facilityDonations)->isEmpty()) {
            $this->facilityDonations = null;
        }
        return view('livewire.donation.facility');
    }
}
