<div>
    @include('shared.functions.roman-numeral-conversion')

    @foreach($sections as $section)
        <div>
            <div class="pb-4 pt-4">
                <h2 class="poppins-semibold text-lg font-medium text-gray-900">
                    <span>{{ numberToRoman($loop->iteration) }}</span>. 
                    <span>{{ $section->question_section_title }}</span>
                </h2>

                <div class="pt-2">
                    <p>{{ $section->description }}</p>
                </div>
            </div>
            <div>
                @livewire('tracer.components.field', ['section_id' => $section->id ])
            </div>
        </div>
    @endforeach
</div>
