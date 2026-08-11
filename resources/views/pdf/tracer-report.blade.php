@php
    function isValidDocumentPath($path)
    {
        return preg_match('/\.(pdf|doc|docx|rtf|txt|odt|xls|xlsx|csv|ppt|pptx|jpg|jpeg|jfif|png|gif|bmp|tiff|tif|webp|heic|heif)$/i', $path);
    }
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Tracer Study Report</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        table, tr, td {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    @include('shared.functions.roman-numeral-conversion')
    @include('shared.functions.letter-conversion')

    <h1>Tracer study</h1>
    <p>Date: {{ \Carbon\Carbon::now('Asia/Singapore')->format('d F Y') }}</p>

    <h2>Program: {{ $program->program_name }}</h2>

    <div>
        <strong>Batch year: {{ $batch_year }}</strong>
    </div>
    <div>
        <strong>Total registered: {{ $statistics->totalRegistrations }}</strong>
    </div>
    <div>
        <strong>Total participants: {{ $statistics->respondents }}</strong>
    </div>

    <br>

    <div>
        <br>
        <h3>Alumni Participation</h3>
    
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Total number</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Participants</td>
                    <td>{{ $statistics->respondents }}</td>
                    <td>{{ round($statistics->respondents / $statistics->totalRegistrations * 100, 2) }}</td>
                </tr>
                <tr>
                    <td>Nonparticipants</td>
                    <td>{{ $statistics->totalRegistrations - $statistics->respondents }}</td>
                    <td>{{ round(($statistics->totalRegistrations - $statistics->respondents) / $statistics->totalRegistrations * 100, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    @foreach($section_list as $section)
        <div>
            <br>
            <h3>
                <span>{{ numberToRoman($loop->iteration) }}. </span>
                <span>{{ $section->title }}</span>
            </h3>
            <br>

            @foreach ($section->responseAnalysis_list as $responseAnalysis)
            
                <h4>
                    <span>{{numberToLetters($loop->iteration)}}.</span>
                    <span>{{ $responseAnalysis->question }}</span>
                </h4>

                <br>
                <h5>Statistical table</h5>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total number</th>
                            <th>Percent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($responseAnalysis->choices as $choice)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th>{{ $choice->choice }}</th>
                                <th>{{ $choice->answer_count }}</th>
                                <th>{{ $choice->percentage }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach

            <br>

            <h4>Response Table</h4>
        
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>First name</th>
                        <th>Last name</th>
                        @foreach ($section->fields as $field)
                            <th>{{ $field->label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section->usersSectionResponses as $usersSectionResponse)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $usersSectionResponse->first_name }}</td>
                            <td>{{ $usersSectionResponse->last_name }}</td>

                            @foreach($usersSectionResponse->userSectionResponses as $userSectionResponse)
                                <td>
                                    @if($userSectionResponse)
                                        @if (isValidDocumentPath($userSectionResponse))
                                            <a href="{{ asset('public/storage/' . $userSectionResponse) }}" target="_blank">Document</a>
                                        @else
                                            <span>{{ $userSectionResponse }}</span>
                                        @endif
                                    @else
                                        <span>------</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>
    @endforeach
</body>
</html>

