<div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="donation-monetary-tab" data-bs-toggle="tab" 
                data-bs-target="#donation-monetary-tab-pane" type="button" role="tab" 
                aria-controls="donation-monetary-tab-pane" aria-selected="false">Financial</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donation-in-kind-tab" data-bs-toggle="tab" 
                data-bs-target="#donation-in-kind-tab-pane" type="button" role="tab" 
                aria-controls="donation-in-kind-tab-pane" aria-selected="false">Resources</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donation-facility-tab" data-bs-toggle="tab" 
                data-bs-target="#donation-facility-tab-pane" type="button" role="tab" 
                aria-controls="donation-facility-tab-pane" aria-selected="false">Facility</button>
        </li>
    </ul>

    @admin
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="donation-monetary-tab-pane" role="tabpanel" 
                aria-labelledby="donation-monetary-tab" tabindex="0">@livewire('donation.monetary')</div>
            <div class="tab-pane fade" id="donation-in-kind-tab-pane" role="tabpanel" 
                aria-labelledby="donation-in-kind-tab" tabindex="0">@livewire('donation.in-kind')</div>
            <div class="tab-pane fade" id="donation-facility-tab-pane" role="tabpanel" 
                aria-labelledby="donation-facility-tab" tabindex="0">@livewire('donation.facility')</div>
        </div>
    @endadmin

    @user
        <div class="tab-content" id="myTabContent">
            <!-- <div class="tab-pane fade show active" id="donation-overview-tab-pane" role="tabpanel" 
                aria-labelledby="home-tab" tabindex="0">@livewire('donation.overview')</div> -->
            <div class="tab-pane fade show active" id="donation-monetary-tab-pane" role="tabpanel" 
                aria-labelledby="donation-monetary-tab" tabindex="0">@livewire('donation.user.monetary')</div>
            <div class="tab-pane fade" id="donation-in-kind-tab-pane" role="tabpanel" 
                aria-labelledby="donation-in-kind-tab" tabindex="0">@livewire('donation.user.in-kind')</div>
            <div class="tab-pane fade" id="donation-facility-tab-pane" role="tabpanel" 
                aria-labelledby="donation-facility-tab" tabindex="0">@livewire('donation.user.facility')</div>
        </div>
    @enduser
</div>