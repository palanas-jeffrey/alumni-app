<div class="bg-light card graph-per-program-container mb-4 ml-3 mr-3 p-3 shadow w-100">
    <div class="d-flex {{ $loop->index % 2 == 0 ? '' : 'flex-row-reverse' }}">
        <div>
            <div id="program-chart-{{$program->id}}" class="chart"></div>
        </div>
        <div class="card-body {{ $loop->index % 2 == 0 ? '' : 'text-right' }}">
            <h2 class="card-title font-medium poppins-semibold text-lg">{{ $program->program_name }}</h2>
            <p>No. of participants: {{ $program->response_count }}</p>
            <p class="mb-4">Total registered graduates: {{ $program->user_count }}</p>
            <x-link-btn href="/tracer/responses-per-program/{{$form->id}}/{{$program->id}}">View</x-link-btn>
        </div>
    </div>
</div>