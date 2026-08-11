<?php

namespace App\Livewire\Donation\User;

use Livewire\Component;
use App\Models\DonationFacility;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Facility extends Component
{
    public $startDate;
    public $endDate;
    public $facilityDonations;
    public $userId;

    public function mount()
    {
        $this->userId = Auth::guard('web')->user()->id;
        $this->facilityDonations = DonationFacility::where(function ($query) {
            $query->where('user_id', $this->userId);
        })->get();
    }

    public function render()
    {
        $query = DonationFacility::query();
        $query->where('user_id', $this->userId);

        if ($this->startDate && $this->endDate) {
            if ($this->startDate === $this->endDate) {
                $query->whereDate('created_at', $this->startDate);
            } else {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }
        }

        $this->facilityDonations = $query->get();

        if ($this->facilityDonations->isEmpty()) {
            $this->facilityDonations = null;
        }

        return view('livewire.donation.user.facility');
    }
}
