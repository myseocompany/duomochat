<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All products</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="https://elementalptp.co/wp-content/uploads/2024/07/cropped-Favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://elementalptp.co/wp-content/uploads/2024/07/cropped-Favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://elementalptp.co/wp-content/uploads/2024/07/cropped-Favicon-180x180.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <header>
        @include('landings.header')
    </header>

    <div class="contenedor-resultado mt-4 px-4">
        <h2 id="mensaje-resultado">Resultados para: </h2>
        <span id="cantidad-encontrada">0 encontrados</span>
    </div>

    <div class="products-container mt-4 px-4">
        <!-- Mostramos los productos aquí -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($products as $product)
                <div class="bg-card rounded-lg overflow-hidden shadow-xl flex">
                    @if(isset($product->image_url))

                        <img src="{{ asset('img/products/' . $product->getURL()) }}" 
                            alt="{{ str_replace($product->name, ' ', '-') }}" 
                            width="200" height="200" 
                            style="aspect-ratio: 200 / 200; object-fit: cover;" 
                            class="w-32 h-36 object-cover img-product image-product-landing" />
                    @else
                    <img src="{{ asset('img/products/logo.png')  }}" 
                    alt='logo' 
                    width="200" height="200" 
                    style="aspect-ratio: 200 / 200; object-fit: cover;" 
                    class="w-32 h-36 object-cover img-product image-product-landing" />

                    @endif        
                    <div class="p-4 flex flex-col justify-between flex-1">
                        <h3 class="text-sm font-semibold product-name">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between mt-3 mb-4">
                            <span class="domi-price font-bold text-gray-800 product-price">
                                {{$product->getPrice()}}
                            </span>
                            <a class="block w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition duration-300 shadow-md domi-add-car font-bold text-lg leading-none" 
                               href="#order-detail" data-product-id="{{$product->id}}">
                                +
                            </a>
                        </div>
                        <p class="text-muted-foreground text-sm mb-2">{{ $product->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("input-search");
            const resultado = document.getElementById("mensaje-resultado");
            const mensajeCantidad = document.getElementById("cantidad-encontrada");
            const products = document.querySelectorAll(".bg-card");

            // Función para actualizar el contador y la visibilidad de los productos
            function updateProductsDisplay() {
                const searchValue = searchInput.value.toLowerCase(); // Convertir a minúsculas para coincidencias insensibles a mayúsculas
                let count = 0; // Contador de productos encontrados

                products.forEach(product => {
                    const productName = product.querySelector(".product-name").textContent.toLowerCase();

                    // Mostrar u ocultar productos según la búsqueda
                    if (productName.includes(searchValue)) {
                        product.style.display = ""; // Mostrar el producto
                        count++; // Incrementar el contador si hay coincidencia
                    } else {
                        product.style.display = "none"; // Ocultar el producto
                    }
                });

                // Actualizar el mensaje de resultados y cantidad
                resultado.innerText = "Resultados para: '" + searchInput.value + "'";
                mensajeCantidad.innerText = count + " producto(s) encontrado(s)";
            }

            // Añadir el evento 'input' al campo de búsqueda
            searchInput.addEventListener("input", function() {
                updateProductsDisplay();
            });

            // Inicializar la vista cuando la página se carga por primera vez
            updateProductsDisplay();
        });
    </script>
</body>
</html>
