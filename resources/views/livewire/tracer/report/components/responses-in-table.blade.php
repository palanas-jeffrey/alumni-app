<div>
    @if ($table_header_items)
         <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First name</th>
                    <th>Last name</th>
                    @foreach($table_header_items as $header_item)
                        <th scope="col">{{$header_item->field_label}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($table_body_contents as $body_item)
                        <tr>
                            <th scope="row">{{ $loop->index + 1}}</th>
                            <td>{{ $body_item->first_name }}</td>
                            <td>{{ $body_item->last_name }}</td>

                            @foreach($body_item->answer_list as $answer)
                                <td>
                                    @if($answer)
                                        @if ($this->isValidDocumentPath($answer))
                                            <a href="{{ asset('public/storage/' . $answer) }}" target="_blank" class="text-green-600 underline">Document</a>
                                        @else
                                            <span>{{ $answer }}</span>
                                        @endif
                                    @else
                                        <span>------</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                </tr>
            </tbody>
        </table>
    @endif

</div>
