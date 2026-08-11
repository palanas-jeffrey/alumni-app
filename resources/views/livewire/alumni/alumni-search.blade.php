<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <section>
        <div class="bg-white border-1 border-gray-300 rounded-4">
            <div class="p-6 pb-0">
                <h2 class="font-medium poppins-semibold text-lg">
                    Alumni Search
                </h2>
                <p class="mb-3 text-gray-600 text-sm">Search alumnus by their name.</p>

                <div>
                    <div class="bg-dust-gray mb-2 p-2 text-right flex justify-between">
                        <div class="flex">
                            <x-text-input id="name" name="name" type="text"
                                    wire:model.live.debounce.500ms="searchTerm" placeholder="Search Name" />
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
                </div>
                
            </div>

            <div class="p-4 pt-0">
                @if($accounts)
                    <div class="max-h-32rm overflow-auto">
                        <table class="table table-striped mb-12">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" class="text-right">View</th>
                                </tr>
                            </thead>  
                            <tbody>
                                
                                @foreach($accounts as $account)
                                    <tr> 
                                        <th scope="row">{{ $loop->index + 1}}</th>
                                        <td>{{ $account['first_name'] }} {{ $account['last_name'] }}</td>
                                        <td>{{ $account['email'] }}</td>
                                        <td>
                                            <div class="text-right">
                                                <a href="{{ route('accounts.view-details', $account['id'] ) }}">
                                                    <i class="bi bi-box-arrow-in-right"></i>
                                                </a>
                                            </div>
                                        </td>                     
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>