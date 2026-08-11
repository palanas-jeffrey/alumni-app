<section>
    @foreach ($upcomingEvents as $uaEvent)
        <x-event-card-v2 :uaEvent="$uaEvent">
            @admin
                <div class="relative">
                    <div class="event-configure-buttons-group">
                        @livewire('events.email-notification', ['eventId' => $uaEvent->id])
                        <a href="{{ route('event.edit', ['id' => $uaEvent->id]) }}" class="d-flex">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button class="text-danger" type="button" data-bs-toggle="modal" data-bs-target="#CTAModal-{{$uaEvent->id}}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>    
                <div>
                    <div>
                        <x-modal-generic :modalId="'CTAModal-'. $uaEvent->id">
                            <div class="modal-body">
                                <div class="p-4 space-y-6">
                                    <h2 id="modalHeadingtxt" class="poppins-semibold text-xl">Are you sure you want to delete this event?</h2>
                                </div>
                            </div>
                            <form action="{{ route('event.delete', ['id' => $uaEvent->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                    
                                <div class="modal-footer">
                                    <div class="flex items-center gap-4">
                                        <x-danger-button type="submit" >{{ __('Delete') }}</x-danger-button>
                                    </div>
                                    <div>
                                        <x-link-generic href="javascript:void(0);" data-bs-dismiss="modal" class="modal-cancel">
                                            <span>Cancel</span>    
                                        </x-link-generic>
                                    </div>
                                </div>
                            </form>
                        </x-modal-generic>
                    </div>
                </div>
            @endadmin
        </x-event-card-v2>
    @endforeach
<section>
