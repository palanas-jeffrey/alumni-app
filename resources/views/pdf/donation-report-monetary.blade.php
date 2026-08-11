<!DOCTYPE html>
<html>
<head>
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

        tbody tr:nth-child(odd) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

    <h1>Financial Donations</h1>
    
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Payment ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Acknowledgment</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if($monetaryDonations)
                    @php $rowCount = 1; @endphp

                    @foreach($monetaryDonations as $monetaryDonation)
                        <tr>
                            <th scope="row">{{ $rowCount++ }}</th>
                            <td>{{ $monetaryDonation->transaction_id }}</td>
                            <td>{{ $monetaryDonation->user->first_name }}</td>
                            <td>{{ $monetaryDonation->user->last_name }}</td>
                            <td>{{ $monetaryDonation->user->email }}</td>
                            <td>{{ $monetaryDonation->mode_of_payment }}</td>
                            <td>{{ $monetaryDonation->amount}}{{$monetaryDonation->currency}}</td>
                            <td>{{ $monetaryDonation->status ? $monetaryDonation->status->status : "" }}</td>
                            <td>{{ \Carbon\Carbon::parse($monetaryDonation->created_at)->format('F j, Y, g:i a') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="8">No records found.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>


