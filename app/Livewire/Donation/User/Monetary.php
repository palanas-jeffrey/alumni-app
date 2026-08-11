<?php

namespace App\Livewire\Donation\User;

use Livewire\Component;
use App\Models\DonationMonetary;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Monetary extends Component
{
    public $startDate;
    public $endDate;
    public $monetaryDonations;
    public $userId;

    public function mount()
    {
        $this->userId = Auth::guard('web')->user()->id;

        $this->monetaryDonations = DonationMonetary::where(function ($query) {
            $query->where('user_id', $this->userId);
        })->get();
    }

    public function render()
    {
        $query = DonationMonetary::query();
        $query->where('user_id', $this->userId);

        if ($this->startDate && $this->endDate) {
            if ($this->startDate === $this->endDate) {
                $query->whereDate('created_at', $this->startDate);
            } else {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }
        }

        $this->monetaryDonations = $query->get();

        if ($this->monetaryDonations->isEmpty()) {
            $this->monetaryDonations = null;
        }

        return view('livewire.donation.user.monetary');
    }
}
