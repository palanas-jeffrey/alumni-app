<div>
    <section>
        <div class="bg-white border-1 border-gray-300 rounded-4">
            <div class="p-6">
                <div class="flex flex justify-between">
                    <div>
                        <h2 class="font-medium poppins-semibold text-lg">Survey participants</h2>
                        <p class="mb-3 text-gray-600 text-sm">Target programs and batches.</p>
                    </div>

                    @if (!$is_published)
                        <div class="ml-6">
                            <x-primary-button x-data="" type="button"
                                x-on:click.prevent="$dispatch('open-modal', 'modal-participation-settings')">
                                    <span>Set</span>
                            </x-primary-button>
                        </div>
                    @endif
                </div>
                <div>
                    @php
                        $participants = json_decode($form->target_participants, true);
                    @endphp

                    @foreach($programs as $program)
                        <div class="mb-3">
                            <div class="mb-1">
                                <strong>{{ $program->program_abbreviation }}</strong>
                            </div>
                            <ul>
                                @if (!empty($participants[$program->program_abbreviation]))
                                    @foreach ($participants[$program->program_abbreviation] as $year)
                                        <li class="inline-flex mr-2">{{ $year }}</li>
                                    @endforeach
                                @else
                                    <li class="inline-flex text-gray-500">No target participants</li>
                                @endif
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <x-modal name="modal-participation-settings"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="eventCreationModal">
                Set participants
            </h2>
            <p class="mb-4 mt-1 text-gray-600 text-sm">Please check the target batches of each program to set target survey participants.</p>
            <form id="target-participants-selection">
                @csrf

                <div>
                    @php
                        $participants_list = json_decode($form->target_participants, true);
                    @endphp

                    @foreach($programs as $program)
                        <fieldset>
                            <legend>
                                <div>
                                    <strong class="poppins-semibold txt-18">{{ $program->program_abbreviation }}</strong>
                                </div>
                            </legend>
                            <div class="flex flex-wrap pb-4 pt-2">
                                @foreach($batches as $batch)
                                    @php
                                        $isChecked = !empty($participants_list[$program->program_abbreviation]) &&
                                                    in_array($batch->batch_year, $participants_list[$program->program_abbreviation]);
                                    @endphp
                                    <div class="mr-5">
                                        <label>
                                            <input
                                                data-group="{{ $program->program_abbreviation }}"
                                                name="{{ $batch->batch_year }}"
                                                type="checkbox"
                                                {{ $isChecked ? 'checked' : '' }}
                                            >
                                            <span class="ml-1">{{ $batch->batch_year }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    @endforeach

                </div>
                <div class="mt-6 flex justify-start">
                    <x-primary-button id="submitTargetParticipantsCTA" class="mr-6">
                        Set
                    </x-primary-button>
        
                    <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                        <span>Cancel</span>    
                    </x-link-generic>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        async function submitTargetParticipants() {
            const formContainer = document.querySelector("#target-participants-selection");
            const inputs = formContainer.querySelectorAll("input[type=checkbox]");
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let participants = {};

            if (inputs.length > 0) {
                inputs.forEach((input) => {
                    let program = input.getAttribute("data-group");

                    if (program && input.checked) {
                        if (!participants[program]) {
                            participants[program] = [];
                        }
                        participants[program].push(input.name);
                    }
                });
            }

            const endpoint = "{{ route('survey.set-target-participants') }}";
            const payload = {
                form_id : "{{ $form_id }}",
                participants: participants
            };

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(payload)
                });

                const contentType = response.headers.get('content-type');

                if (!response.ok) {
                    let errorMessage = `HTTP status ${response.status}`;

                    if (contentType && contentType.includes('application/json')) {
                        const errorData = await response.json();
                        errorMessage = errorData.message || errorMessage;
                    } else {
                        const errorText = await response.text();
                        errorMessage = errorText || errorMessage;
                    }

                    throw new Error(errorMessage);
                }

                showToast('Target participants set successfully!');
                setTimeout(() => window.location.reload(), 1500);

            } catch (error) {
                showToast("Encountered error while saving the data.", false);
            }
        }

        function initEvents() {
            document.addEventListener('click', function(e) {
                if(event.target.closest("#submitTargetParticipantsCTA")) {
                    e.preventDefault();
                    e.stopPropagation();
                    submitTargetParticipants();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initEvents();
        });
    </script>
</div>