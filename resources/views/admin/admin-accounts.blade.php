<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('accounts.programs') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Admin accounts
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <section class="bg-primary-subtle mb-6 p-4 rounded-4 space-y-6">
                    <div>
                        <h2 class="poppins-semibold text-lg">Register an admin account</h2>
                        <p class="mt-1 mb-1 text-sm text-gray-600">Register an admin entering their details.</p>
                        <div class="flex gap-4 items-center mt-4">
                            <x-link-btn href="{{ route('admin.registration') }}">Register</x-link-btn>
                        </div>
                    </div>
                </section>
            </div>
            <div class="bg-white border-1 border-gray-300 rounded-4">
                <div class="p-6 text-gray-900">
                    <section>
                        <header>
                            <h2 class="poppins-semibold text-lg">
                                Admin accounts
                            </h2>

                            <p class="mb-4 mt-1 text-sm">
                                Below is the list of all admin accunts.
                            </p>
                        </header>
                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First name</th>
                                        <th scope="col">Last name</th>
                                        <th scope="col">Email</th>
                                        @if(Auth::guard('admin')->user()->has_main_control)
                                            <th class="text-right">View</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @if($accounts)
                                        @foreach($accounts as $account)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $account->first_name }}</td>
                                                <td>{{ $account->last_name }}</td>
                                                <td>{{ $account->email }}</td>
                                                @if(Auth::guard('admin')->user()->has_main_control)
                                                    <td>
                                                        <div class="text-right">
                                                            <a href="{{ route('accounts.admin-edit', ['account_id' => $account->id]) }}">
                                                                <i class="bi bi-box-arrow-in-right"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="6">No accounts found.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')

    @if (session('success-account-deletion'))
        <script>
            showToast("Account deleted successfully!");
        </script>
    @endif
</x-generic-layout>