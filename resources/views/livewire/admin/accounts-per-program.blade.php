<div> 
    <div class="bg-dust-gray mb-2 p-2 text-right flex justify-between">
        <div class="flex">
            <div>
                <x-text-input id="full_name" name="full_name" type="text"  
                    wire:model.live.debounce.500ms="searchTerm" placeholder="Search Name"/>
            </div>
            <div class="ml-3">
                <label for="batch_year" class="align-items-center flex">
                    <span class="mr-1">Batch</span>
                    <x-select id="batch_year" name="batch_year" class="d-inline-flex" 
                            :options="collect($batch_years)->mapWithKeys(fn($batch_year) => [$batch_year => $batch_year])->toArray()" 
                            wire:model.lazy="batchYear"  
                            :hasBlank=true />
                </label>
            </div>
        </div>
        <div class="align-content-center">
            @if ($resultCount)
                <strong>{{ $resultCount }} found</strong>
            @endif
        </div>
    </div>
    @if($accounts)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Alumni ID</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-right">View</th>
                </tr>
            </thead>  
            <tbody>
                @foreach($accounts as $account)
                    <tr> 
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $account['first_name'] }} {{ $account['last_name'] }}</td>
                        <td>{{ $account['alumni_id'] }}</td>
                        <td>{{ $account['email'] }}</td>
                        <td>
                            <div class="text-right">
                                <a href="{{ route('accounts.account-details', $account->id) }}">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
