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

    <h1>Donation Facility</h1>
    <p>
        Below is the list of all donated facilities.
    </p>
    
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Facility</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if($facilityDonations)
                    @php $rowCount = 1; @endphp

                    @foreach($facilityDonations as $facilityDonation)
                        <tr>
                            <th scope="row">{{ $rowCount++ }}</th>
                            <td>{{ $facilityDonation->user->first_name }}</td>
                            <td>{{ $facilityDonation->user->last_name }}</td>
                            <td>{{ $facilityDonation->user->email }}</td>
                            <td>{{ $facilityDonation->facility }}</td>
                            <td>{{ $facilityDonation->description }}</td>
                            <td>{{ $facilityDonation->status ? $facilityDonation->status->status : "" }}</td>
                            <td>{{ \Carbon\Carbon::parse($facilityDonation->created_at)->format('F j, Y, g:i a') }}</td>
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