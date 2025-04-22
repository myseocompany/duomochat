<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


<h2>Archivos Subidos</h2>

@php
    $files = \App\Models\OrderFile::getActiveFiles($order_id);
@endphp

@if($files->isEmpty())
    <p>No hay archivos disponibles.</p>
@else
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        @foreach ($files as $file)
            <div style="position: relative;">
                <!-- Miniatura -->
                
                <a href="{{ asset('storage/' . $file->url) }}" data-lightbox="gallery" data-title="{{ $file->name }}">
                    <img src="{{ asset('storage/' . $file->url) }}" alt="{{ $file->name }}" 
                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0,0,0,0.2);">
                </a>
                

                <!-- Botón de eliminar -->
                <button onclick="deleteFile({{ $file->id }})" 
                        style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;">
                    ✖
                </button>
            </div>
        @endforeach
    </div>
@endif

<script>
    function deleteFile(fileId) {
        if (!confirm("¿Estás seguro de que quieres eliminar este archivo?")) {
            return;
        }

        fetch("{{ url('/order-files/delete') }}/" + fileId, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Archivo eliminado correctamente.");
                location.reload();
            } else {
                alert("Error al eliminar el archivo.");
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>

