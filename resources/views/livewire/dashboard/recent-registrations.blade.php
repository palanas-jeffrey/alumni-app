<div>
    <div>
        <h2 class="text-lg font-medium text-gray-900">
            Recent registrations
        </h2>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Program</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $rowCount = 1; 
            @endphp

            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $rowCount++ }}</th>
                    <td>{{ $user['last_name'] }}, {{ $user['first_name']}}</td>
                    <td>{{ $user['programTaken']['program_abbreviation'] }}</td>
                    <td>
                        @if($user->accountActivation && $user->accountActivation->is_activated)
                            <span>activated</span>
                        @elseif($user->accountActivation && !$user->accountActivation->is_activated)
                            <span>pending</span>
                        @else
                            <span>no record</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
