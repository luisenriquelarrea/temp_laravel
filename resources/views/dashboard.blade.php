<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h2 class="text-xl font-bold mb-4">SAT Download Requests</h2>

                <a href="{{ route('sat-requests.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
                    New Request
                </a>

                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Request ID</th>
                            <th class="p-2 border">From</th>
                            <th class="p-2 border">To</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Packages</th>
                            <th class="p-2 border">Last Verified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td class="p-2 border">{{ $request->id }}</td>
                                <td class="p-2 border">{{ $request->request_id }}</td>
                                <td class="p-2 border">{{ $request->date_from }}</td>
                                <td class="p-2 border">{{ $request->date_to }}</td>
                                <td class="p-2 border">{{ $request->status }}</td>
                                <td class="p-2 border">{{ $request->packages_count }}</td>
                                <td class="p-2 border">{{ $request->last_verified_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center">No requests found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
