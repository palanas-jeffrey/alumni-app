<?php

namespace App\Livewire\Donation\User;

use Livewire\Component;
use App\Models\DonationInKind;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InKind extends Component
{
    public $startDate;
    public $endDate;
    public $inKindDonations;
    public $userId;

    public function mount()
    {
        $this->userId = Auth::guard('web')->user()->id;
        $this->inKindDonations = DonationInKind::where(function ($query) {
            $query->where('user_id', $this->userId);
        })->get();
    }

    public function render()
    {
        $query = DonationInKind::query();
        $query->where('user_id', $this->userId);

        if ($this->startDate && $this->endDate) {
            if ($this->startDate === $this->endDate) {
                $query->whereDate('created_at', $this->startDate);
            } else {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }
        }

        $this->inKindDonations = $query->get();

        if ($this->inKindDonations->isEmpty()) {
            $this->inKindDonations = null;
        }

        return view('livewire.donation.user.in-kind');
    }
}
