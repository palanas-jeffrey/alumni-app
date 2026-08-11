<?php

namespace App\Livewire\Donation;

use Livewire\Component;
use App\Models\DonationInKind;
use App\Models\User;

class InKind extends Component
{
    public $transactionDonor;
    public $startDate;
    public $endDate;
    public $inKindDonations;
    public $userIds = [];
    public $pendingResources = 0;

    public function mount()
    {
        $this->inKindDonations = DonationInKind::with('user')->get();
        $this->pendingResources = DonationInKind::where('status_id', 1)->count();
    }

    public function render()
    {
        $query = DonationInKind::query();

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
            $this->inKindDonations = null;
        } else {
            $this->inKindDonations = $query->get();
        }

        if (collect($this->inKindDonations)->isEmpty()) {
            $this->inKindDonations = null;
        }

        return view('livewire.donation.in-kind');
    }
}
