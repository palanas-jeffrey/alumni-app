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

    <h1>Donation Resources</h1>
    <p>
        Below is the list of all in kind transactions.
    </p>
    
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Item</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if($inKindDonations)
                    @php $rowCount = 1; @endphp

                    @foreach($inKindDonations as $inKindDonation)
                        <tr>
                            <th scope="row">{{ $rowCount++ }}</th>
                            <td>{{ $inKindDonation->user->first_name }}</td>
                            <td>{{ $inKindDonation->user->last_name }}</td>
                            <td>{{ $inKindDonation->user->email }}</td>
                            <td>{{ $inKindDonation->item_name }}</td>
                            <td>{{ $inKindDonation->quantity . $inKindDonation->unit}}</td>
                            <td>{{ $inKindDonation->status ? $inKindDonation->status->status : "" }}</td>
                            <td>{{ \Carbon\Carbon::parse($inKindDonation->created_at)->format('F j, Y, g:i a') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="6">No records found.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>