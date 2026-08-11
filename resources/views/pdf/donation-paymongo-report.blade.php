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

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

    <h1>Paymongo transactions</h1>
    <p>
        Below is the list of all Paymongo transactions.
    </p>
    
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Payment ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($paymongoTransactions))
                    @php $rowCount = 1; @endphp
                    @foreach($paymongoTransactions as $transaction)
                        @php $attributes = $transaction['attributes']; @endphp
                        <tr>
                            <th scope="row">{{ $rowCount++ }}</th>
                            <td>{{ $transaction['id'] }}</td>
                            <td>{{ $transaction['attributes']['billing']['name'] ?? 'N/A' }}</td>
                            <td>{{ $transaction['attributes']['billing']['email'] ?? 'N/A' }}</td>
                            <td>{{ $attributes['source']['type'] ?? 'N/A' }}</td>
                            <td>{{ number_format($attributes['amount'] / 100, 2) }} {{ $attributes['currency'] }}</td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($attributes['paid_at'])->format('F j, Y, g:i a') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="6">No payments found.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>



