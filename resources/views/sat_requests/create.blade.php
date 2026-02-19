<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded">

                <h2 class="text-xl font-bold mb-6">Nueva solicitud de descarga</h2>

                <form method="POST" action="{{ route('sat-requests.store') }}">
                    @csrf

                    <!-- Date From -->
                    <div class="mb-4">
                        <label class="block font-medium">Fecha inicio</label>
                        <input type="datetime-local" name="date_from"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <!-- Date To -->
                    <div class="mb-4">
                        <label class="block font-medium">Fecha final</label>
                        <input type="datetime-local" name="date_to"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <!-- Request Type -->
                    <div class="mb-4">
                        <label class="block font-medium">Tipo solicitud</label>
                        <select name="request_type" class="w-full border rounded p-2">
                            <option value="xml">XML</option>
                            <option value="metadata">Metadata</option>
                        </select>
                    </div>

                    <!-- Download Type -->
                    <div class="mb-4">
                        <label class="block font-medium">Tipo descarga</label>
                        <select name="download_type" class="w-full border rounded p-2">
                            <option value="received">Recibidos</option>
                            <option value="issued">Emitidos</option>
                        </select>
                    </div>

                    <!-- Document Type -->
                    <div class="mb-4">
                        <label class="block font-medium">Tipo documento</label>
                        <select name="document_type" class="w-full border rounded p-2">
                            <option value="ingreso">Ingreso</option>
                            <option value="egreso">Egreso</option>
                            <option value="pago">Pago</option>
                        </select>
                    </div>

                    <!-- Document Status -->
                    <div class="mb-6">
                        <label class="block font-medium">Estatus documento</label>
                        <select name="document_status" class="w-full border rounded p-2">
                            <option value="active">Activo</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                        Crear solicitud
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
