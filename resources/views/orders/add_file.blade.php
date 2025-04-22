<!-- Dropzone.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>


<h2>Subir Archivo</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if($errors->any())
    <p style="color: red;">{{ implode(', ', $errors->all()) }}</p>
@endif

<!-- Formulario de subida con Dropzone -->
<form action="{{ route('order-files.store') }}" method="POST" enctype="multipart/form-data" 
      class="dropzone" id="dropzoneForm">
      {{csrf_field()}}
    <input type="hidden" name="order_id" value="{{ $order_id }}">
</form>

<script>
    Dropzone.options.dropzoneForm = {
        paramName: "file",
        maxFilesize: 2, // Tamaño máximo en MB
        acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx",
        dictDefaultMessage: "Arrastra y suelta tus archivos aquí o haz clic para seleccionar",
        init: function () {
            this.on("success", function (file, response) {
                console.log("Archivo subido correctamente", response);
                location.reload(); // Recargar la página para mostrar el archivo subido
            });
            this.on("error", function (file, response) {
                console.log("Error al subir archivo", response);
            });
        }
    };
</script>
