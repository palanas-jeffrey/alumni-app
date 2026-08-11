<div>
    <div>
        @if($responses && count($responses) > 0)
            @foreach($responses as $response)
                <ul>
                    @foreach($response['response_fields'] ?? [] as $field)
                        <li>
                            <p class="mt-1 text-sm text-gray-600">{{ $field['value'] }}</p>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        @else
            <p class="mt-1 text-sm text-gray-600">No responses available.</p>
        @endif
    </div>
</div>
