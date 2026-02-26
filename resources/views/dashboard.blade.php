<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SAT | Servicio de descarga masiva') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h2 class="text-xl font-bold mb-4">Solicitudes de descarga</h2>

                <a href="{{ route('sat-requests.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
                    Nueva solicitud
                </a>

                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Acciones</th>
                            <th class="p-2 border">Fecha solicitud</th>
                            <th class="p-2 border">Estatus CFDI</th>
                            <th class="p-2 border">Inicio</th>
                            <th class="p-2 border">Final</th>
                            <th class="p-2 border">Tipo CFDI</th>
                            <th class="p-2 border">Solicitud ID</th>
                            <th class="p-2 border">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td class="border px-4 py-2 text-center">
                                    @if($request->packages->isNotEmpty())
                                        @foreach($request->packages as $package)
                                            <a href="{{ route('sat-packages.download', $package) }}"
                                            class="text-blue-600 hover:text-green-800 mr-2"
                                            title="Download {{ $package->package_id }}">
                                                <i class="fa-solid fa-file-zipper text-lg"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="p-2 border">{{ $request->created_at }}</td>
                                <td class="p-2 border text-center">
                                    @switch($request->document_status)
                                        @case('cancelled')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-red-200 text-red-800">
                                                cancelled
                                            </span>
                                            @break
                                        
                                        @case('active')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-200 text-green-800">
                                                active
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="p-2 border">{{ $request->date_from }}</td>
                                <td class="p-2 border">{{ $request->date_to }}</td>
                                <td class="p-2 border">
                                    @switch($request->document_type)
                                        @case('ingreso')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-teal-200 text-teal-800">
                                                ingreso
                                            </span>
                                            @break

                                        @case('egreso')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-orange-200 text-orange-800">
                                                egreso
                                            </span>
                                            @break

                                        @case('pago')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-indigo-200 text-indigo-800">
                                                pago
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="p-2 border">{{ $request->request_id }}</td>
                                <td class="p-2 border text-center">
                                    @switch($request->status)
                                        @case('created')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800">
                                                Created
                                            </span>
                                            @break

                                        @case('accepted')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-200 text-blue-800">
                                                Accepted
                                            </span>
                                            @break

                                        @case('in_progress')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-200 text-yellow-800">
                                                In Progress
                                            </span>
                                            @break

                                        @case('finished')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-indigo-200 text-indigo-800">
                                                Finished
                                            </span>
                                            @break

                                        @case('completed')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-200 text-green-800">
                                                Completed
                                            </span>
                                            @break

                                        @case('failed')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-red-200 text-red-800">
                                                Failed
                                            </span>
                                            @break

                                        @case('rejected')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-red-300 text-red-900">
                                                Rejected
                                            </span>
                                            @break

                                        @default
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-600">
                                                {{ $request->status }}
                                            </span>
                                    @endswitch
                                </td>
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
