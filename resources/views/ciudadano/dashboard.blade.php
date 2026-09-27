<x-aspirante-layout>
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Registro de Aspirante</h2>

        <form method="POST" action="{{ route('aspirante.registro.store') }}">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                    <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" name="phone" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enviar registro</button>
                </div>
            </div>
        </form>
    </div>
</x-aspirante-layout>
