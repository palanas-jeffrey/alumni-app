<div>
    <ol type="a">
        @foreach($fields as $field)
            <li>
                @livewire('tracer.components.dynamic-field', ['order' => $loop->index + 1, 'field' => $field, 'section_id' => $section_id])
            </li>
        @endforeach
    </ol>
</div>
