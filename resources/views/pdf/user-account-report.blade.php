@extends('pdf.pdf-layout')

@section('content')
    <div>
        <header>
            <h2 class="text-lg font-semibold">
                Alumni members
            </h2>

            <p class="mt-1 mb-1">
                Below is the list of all alumni who joined.
            </p>
        </header>
    </div>
    <div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Joined</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rowCount = 1; @endphp

                    @foreach ($userAccounts as $account)
                        <tr>
                            <th scope="row">{{ $rowCount++ }}</th>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->email }}</td>
                            <td>{{ date('F j, Y', strtotime($account->created_at)) }}</td>
                            <td>{{ optional($account->accountActivation)->is_activated ? 'Activated' : 'Not Activated' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
