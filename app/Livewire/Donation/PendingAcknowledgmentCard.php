<?php

namespace App\Livewire\Donation;

use Livewire\Component;
use App\Models\DonationMonetary;
use App\Models\DonationInKind;
use App\Models\DonationFacility;

class PendingAcknowledgmentCard extends Component
{
    public $pendingFinancial = 0;
    public $pendingResources = 0;
    public $pendingFacility = 0;

    public function mount()
    {
        $this->pendingFinancial = DonationMonetary::where('status_id', 1)->count();
        $this->pendingResources = DonationInKind::where('status_id', 1)->count();
        $this->pendingFacility = DonationFacility::where('status_id', 1)->count();
    }

    public function render()
    {
        return view('livewire.donation.pending-acknowledgment-card');
    }
}
