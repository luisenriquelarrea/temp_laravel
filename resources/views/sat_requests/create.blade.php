<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded">

                <h2 class="text-xl font-bold mb-6">New SAT Download Request</h2>

                <form method="POST" action="{{ route('sat-requests.store') }}">
                    @csrf

                    <!-- Date From -->
                    <div class="mb-4">
                        <label class="block font-medium">Date From</label>
                        <input type="datetime-local" name="date_from"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <!-- Date To -->
                    <div class="mb-4">
                        <label class="block font-medium">Date To</label>
                        <input type="datetime-local" name="date_to"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <!-- Download Type -->
                    <div class="mb-4">
                        <label class="block font-medium">Download Type</label>
                        <select name="download_type" class="w-full border rounded p-2">
                            <option value="received">Received</option>
                            <option value="issued">Issued</option>
                        </select>
                    </div>

                    <!-- Request Type -->
                    <div class="mb-4">
                        <label class="block font-medium">Request Type</label>
                        <select name="request_type" class="w-full border rounded p-2">
                            <option value="xml">XML</option>
                            <option value="metadata">Metadata</option>
                        </select>
                    </div>

                    <!-- Document Type -->
                    <div class="mb-4">
                        <label class="block font-medium">Document Type</label>
                        <select name="document_type" class="w-full border rounded p-2">
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                            <option value="pago">Pago</option>
                        </select>
                    </div>

                    <!-- Document Status -->
                    <div class="mb-6">
                        <label class="block font-medium">Document Status</label>
                        <select name="document_status" class="w-full border rounded p-2">
                            <option value="active">Active</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                        Create Request
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
