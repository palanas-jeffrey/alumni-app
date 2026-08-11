<div>
    <div>
        <div class="p-6 w-full d-flex flex-wrap justify-between">
            @foreach($fields as $field)
                @livewire('tracer.report.components.responses-in-graph', ['field_id' => $field->id, 'program_id' => $program_id, 'batch_year' => $batch_year])
            @endforeach
        </div>

        <div class="section-report-table">
            @livewire('tracer.report.components.responses-in-table', ['section_id' => $section_id, 'program_id' => $program_id, 'form_id' => $form_id, 'batch_year' => $batch_year])
        </div>

    </div>
</div>
