<div class="bg-white shadow rounded-xl p-4 mt-6">
  <h3 class="text-lg font-semibold mb-4">Archivos</h3>

  <form method="POST" action="/customer_files" enctype="multipart/form-data" class="space-y-3">
    @csrf
    <input type="hidden" name="customer_id" value="{{ $model->id }}">

    <div>
      <label for="customer-file" class="block text-sm font-medium text-gray-700 mb-1">Subir archivo</label>
      <input
        id="customer-file"
        type="file"
        name="file"
        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
      >
    </div>

    <button
      type="submit"
      class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700"
    >
      Cargar archivo
    </button>
  </form>

  <div class="mt-4 space-y-3">
    @forelse($model->customer_files as $file)
      <div class="border border-gray-200 rounded-lg p-3">
        <a
          href="/public/files/{{ $file->customer_id }}/{{ $file->url }}"
          target="_blank"
          class="block text-sm font-medium text-indigo-600 break-all hover:underline"
        >
          {{ $file->url }}
        </a>
        <p class="text-xs text-gray-500 mt-1">{{ $file->created_at }}</p>
        <a
          href="/customer_files/{{ $file->id }}/delete"
          class="inline-flex mt-2 text-xs font-medium text-red-600 hover:text-red-700"
          onclick="return confirm('¿Eliminar este archivo?');"
        >
          Eliminar
        </a>
      </div>
    @empty
      <p class="text-sm text-gray-500">No hay archivos cargados.</p>
    @endforelse
  </div>
</div>
