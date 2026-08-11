<?php

namespace App\Livewire\Donation;

use Livewire\Component;
use App\Models\DonationMonetary;
use App\Models\DonationFacility;
use App\Models\DonationInKind;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RecentDonation extends Component
{
    public $userId;
    public $monetaryDonation;
    public $inKindDonation;
    public $facilityDonation;
    public $isViewMyDonation;

    public function mount($isViewMyDonation = true)
    {
        if ($isViewMyDonation) {
            $this->isViewMyDonation = $isViewMyDonation;
        }

        $this->userId = Auth::guard('web')->user()->id;
        
        $monetaryDonation = DonationMonetary::where('user_id', $this->userId)
            ->latest('created_at')
            ->first();

        if ($monetaryDonation) {
            $this->monetaryDonation = (string) $monetaryDonation->amount . " " . (string) $monetaryDonation->currency;
        }

        $inKindDonation = DonationInKind::where('user_id', $this->userId)
            ->latest('created_at')
            ->first();
        
        if ($inKindDonation) {
            $this->inKindDonation = (string) $inKindDonation->item_name . " " . (string) $inKindDonation->quantity
                . " " . (string) $inKindDonation->unit;
        }
        
        $facilityDonation = DonationFacility::where('user_id', $this->userId)
            ->latest('created_at')
            ->first();

        if ($facilityDonation) {
            $this->facilityDonation = (string) $facilityDonation->facility;
        }
    }

    public function render()
    {
        return view('livewire.donation.recent-donation');
    }
}
