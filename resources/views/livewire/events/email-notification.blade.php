<div>
    <button type="button" x-data 
        x-on:click.prevent="$dispatch('open-modal', 'eventNotificationModal-{{ $uaEvent->id }}')">
        <i class="bi bi-bell"></i>
    </button>

    <x-modal name="{{'eventNotificationModal-'. $uaEvent->id}}" x-on:close.window="@this.dispatch('close')" focusable>
        <form class="p-6" wire:submit.prevent="sendNotificationEmailEvent">
            @csrf

            <h2 class="poppins-semibold text-xl">
                {{ __(' Notify the Alumni with this event now?') }}
            </h2>

            <p class="mt-2 text-sm">
                Please review and update the message as needed before continuing.
            </p>

            <div class="mt-6">
                <x-input-label for="message-{{ $uaEvent->id }}" :value="__('Message')" />
                <textarea
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                    name="message"
                    rows="4"
                    id="message-{{ $uaEvent->id }}"
                    wire:model.lazy="notificationMessage"
                    placeholder="Write your message here">
                </textarea>
            </div>

            <div class="mt-6 flex">
                <x-primary-button type="submit">
                    <div class="relative">
                        <span class="btn-text">Notify</span>
                        <div class="dots-loader absolute v-hidden">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </x-primary-button>
                <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        </form>
    </x-modal>
</div>
