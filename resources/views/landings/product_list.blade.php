<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duomo</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="https://elementalptp.co/wp-content/uploads/2024/07/cropped-Favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://elementalptp.co/wp-content/uploads/2024/07/cropped-Favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://elementalptp.co/wp-content/uploads/2024/07/cropped-Favicon-180x180.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body>
    <div class="flex flex-col min-h-[100dvh] bg-background">
        <div class="header">
            @include('landings.header')
        </div>

        <div id="menu-mobile" class="space-y-1 pb-3 flex hidden sticky top-18 bg-white">
            @foreach($categories as $category)
            <a href="#cat-{{$category->id}}" class="sm:hidden block rounded-md px-3 py-2 text-slate-700 transition-color hover:bg-slate-900 hover:text-white">
                {{$category->name}}
            </a>
            @endforeach
        </div>
        <div>
            @include('landings.menu')
        </div>
        <!-- Banner Section -->
        <div class="w-full flex justify-center my-4" id="banner">
            <img src="https://elemental.aricrm.co/img/img_landing.jpeg" alt="Black Week Banner" class="w-full h-auto">
        </div>
        <!-- fin de la seccion del banner -->

        <main class="flex-1 py-12 md:py-24">
            <!-- productos flash -->
            @if($flashProducts->count() > 0)
                <div class="products-container p-6 rounded-lg shadow-lg mb-[100px]">
                    <h2 class="text-3xl font-bold mb-6">Ofertas Flash</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 relative">
                    @foreach($flashProducts as $product)
                        <div class="bg-card relative rounded-lg overflow-hidden shadow-xl flex">
                            <!-- div con la franja de descuentos -->
                            <div class="discount w-[30px] h-[160px] absolute -top-[40px] right-0 -rotate-45 bg-[#FF904B] flex flex-col items-center justify-center pb-[30px]">
                                <span class="text-white rotate-90"><b> Oferta </b> </span>
                            </div>
                            <!-- fin de la franja de descuentos -->
                            <img src="https://elemental.aricrm.co/img/product_{{ $loop->index % 24 + 1 }}_.jpg" 
                                width="200" height="200" 
                                style="aspect-ratio: 200 / 200; object-fit: cover;" 
                                class="w-32 h-36 object-cover img-product image-product-landing" />

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
            @endif
            <!-- fin productos flash -->

            <!-- productos ordenados por categorias -->
            @foreach($categories as $category)
            <div class="products-container" id="products-container">
                <div class="bg-background text-foreground px-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold" id="cat-{{$category->id}}">{{ $category->name }}</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @foreach($category->products as $product)
                        <div class="bg-card rounded-lg overflow-hidden shadow-xl flex">
                            <img src="{{ asset('img/products/' . $product->getURL() ) }}"
                            alt="{{ str_replace($product->name, ' ', '-') . '.png' }}"
                            width="200" height="200"
                            style="aspect-ratio: 200 / 200; object-fit: cover;"
                            class="w-32 h-36 object-cover img-product image-product-landing" />
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
                <hr class="my-6 border-t border-gray-300">
            </div>
            @endforeach
            <!-- fin de productos ordenados por categoria -->

            <!-- productos restantes -->
            <div class="all-products-container mt-4 px-4 mb-10" id="all-products-container">
                <h2 class="text-2xl font-bold mb-7"> Todos nuestros productos </h2>
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
            <!-- fin de productos restantes -->

            <div class="grid grid-cols-10 w-full">
                <div class="col-span-6 border-r-2 border-slate-600" id="order-detail">
                    <table id="order-table" class="p-0 m-0 gap-0 w-full text-black">
                        <tbody id="order-body" class="">
                            <!-- El espacio para los productos agregados estará aquí -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-slate-600 text-lg font-bold">Subtotal</td>
                                <td id="order-total" class="text-slate-600 text-lg text-right font-bold"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-span-4 pl-4">
                    <form id="messageForm" name="messageForm" action="#" method="POST" class="space-y-4">
                        <input type="hidden" name="source_id" value="10">
                        <input type="hidden" name="status_id" value="7">
                        <input type="text" id="name" name="name" placeholder="Nombre" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="tel" id="phone" name="phone" placeholder="Teléfono" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="text" id="address" name="address" placeholder="Dirección" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" id="order-details" name="order_details">
                        <div class="flex justify-center">
                            <input id="domi-submit" type="submit" class="focus:outline-none focus:ring-2 focus:ring-offset-2 p-4 border border-gray-200 hover:bg-gray-300 text-black bg-white" value="Realizar pedido">
                        </div>
                    </form>

                    <script>
                        function sendMessage() {
                            console.log("enviando");
                            const name = document.getElementById('name').value;
                            const address = document.getElementById('address').value;
                            const phoneCustomer = document.getElementById('phone').value;
                            const orderDetails = document.getElementById('order-details').value;

                            let completeMessage = `
                            *Elemental Para Tu Piel*
                                                
                            *Nombre:* ${name}
                            *Teléfono:* ${phoneCustomer}
                            *Dirección:* ${address}
                                                
                            ${orderDetails ? orderDetails.split(',').map(detail => {
                                const parts = detail.split(':');
                                return `⚪ ${parts[1]} *${parts[2]}*`;
                            }).join('\n') : 'No hay detalles de pedido'}
                            
                            *Total: ${document.getElementById('order-total').innerText}*
                            
                            Gracias por elegir nuestra tienda dermatológica!
                            Por favor, envía este mensaje y te atenderemos enseguida.
                            `;

                            const payload = {
                                action: "send-message",
                                type: "text",
                                content: completeMessage,
                                phone: phoneCustomer
                            };

                            // Agregar el número adicional (3205534914)
                            const additionalPhone = "573142132987";
                            fetch('https://api.watoolbox.com/webhooks/3A5VNXU6B', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Mensaje enviado exitosamente');
                                } else {
                                    console.error('Error en la respuesta de la API:', data);
                                }
                            })
                            .catch(error => {
                                console.error('Error al enviar el mensaje:', error);
                            });

                            // Enviar al número adicional
                            payload.phone = additionalPhone;
                            fetch('https://api.watoolbox.com/webhooks/3A5VNXU6B', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Mensaje enviado exitosamente');
                                } else {
                                    console.error('Error en la respuesta de la API:', data);
                                }
                            })
                            .catch(error => {
                                console.error('Error al enviar el mensaje:', error);
                            });
                        }

                        document.getElementById('messageForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            sendMessage();
                        });

                        document.addEventListener('DOMContentLoaded', function() {
                            const addToOrderButtons = document.querySelectorAll('.domi-add-car');
                            addToOrderButtons.forEach(function(button) {
                                button.addEventListener('click', function() {
                                    const productContainer = button.closest('.bg-card');
                                    const productName = productContainer.querySelector('.product-name').innerText;
                                    const productId = button.getAttribute('data-product-id');
                                    const priceText = productContainer.querySelector('.product-price').innerText;
                                    const price = parseInt(priceText.replace(/\./g, '').replace(/[^0-9]/g, ''), 10);

                                    addProductToOrder(productName, price, productId);
                                    updateTotal();
                                    updateNotesField();
                                });
                            });

                            window.removeProductFromOrder = function(button) {
                                var row = button.closest('tr');
                                row.remove();
                                updateTotal();
                                updateNotesField();
                            };

                            function addProductToOrder(name, price, productId) {
                                var orderBody = document.getElementById('order-body');
                                var row = orderBody.insertRow();
                                row.setAttribute('data-product-id', productId);

                                var cell1 = row.insertCell(0);
                                cell1.innerHTML = `<span class="text-slate-500">${name}</span>`;
                                var cell2 = row.insertCell(1);
                                cell2.innerHTML = `<span class="text-slate-500">$${formatPrice(price)}</span>`;
                                cell2.style.textAlign = 'right';

                                var cell3 = row.insertCell(2);
                                cell3.innerHTML = '<button onclick="removeProductFromOrder(this)" style="background-color: white; color: black; border: 1px solid black; border-radius: 50%; width: 25px; height: 25px; text-align: center;">x</button>';
                                cell3.style.textAlign = 'right';
                            }

                            function updateTotal() {
                                var total = 0;
                                var prices = document.querySelectorAll('#order-body tr td:nth-child(2) span');
                                prices.forEach(function(span) {
                                    var price = parseInt(span.textContent.replace(/\$/g, '').replace(/\./g, '').replace(/[^0-9]/g, ''), 10);
                                    total += price;
                                });
                                document.getElementById('order-total').innerText = `$${formatPrice(total)}`;
                            }

                            function formatPrice(price) {
                                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }

                            function updateNotesField() {
                                var orderItems = [];
                                var rows = document.querySelectorAll('#order-body tr');
                                rows.forEach(function(row) {
                                    var name = row.cells[0].innerText;
                                    var price = row.cells[1].innerText;
                                    var productId = row.getAttribute('data-product-id');
                                    orderItems.push(`${productId}:${name}:${price}`);
                                });
                                document.getElementById('order-details').value = orderItems.join(',');
                            }
                        });
                    </script>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-muted py-6 w-full shrink-0 px-4 md:px-6 border-t relative">
        <div class="container flex flex-col sm:flex-row items-center justify-between">
            <nav class="sm:ml-auto flex gap-4 sm:gap-6 mt-4 sm:mt-0">
                <a class="text-xs hover:underline underline-offset-4" href="#" rel="ugc">
                    Términos de Servicio
                </a>
                <a class="text-xs hover:underline underline-offset-4" href="#" rel="ugc">
                    Política de Privacidad
                </a>
            </nav>
        </div>
        <button onclick="goUp()" class="w-[50px] h-[50px] bg-blue-500 text-white px-4 py-2 rounded-full fixed right-[40px] bottom-[30px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
              </svg>
        </button>
    </footer>
    {{-- script para subir con el boton --}}
    <script>
        function goUp() {
            window.scrollTo({
                top: 0, 
                behavior: 'smooth' 
            });
        }
    </script>
    {{-- fin script para subir con el boton --}}

    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const header = document.getElementById('main-header');
                const headerHeight = header.offsetHeight;
    
                document.querySelectorAll('nav a[href^="#cat-"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
    
                        if (targetElement) {
                            const elementPosition = targetElement.getBoundingClientRect().top;
                            const offsetPosition = elementPosition - headerHeight;
    
                            window.scrollBy({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }
                    });
                });
    
                document.querySelectorAll('#menu-mobile a[href^="#cat-"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
    
                        if (targetElement) {
                            const elementPosition = targetElement.getBoundingClientRect().top;
                            const offsetPosition = elementPosition - headerHeight;
    
                            window.scrollBy({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }
    
                        var menu = document.getElementById('menu-mobile');
                        menu.classList.toggle('hidden');
                    });
                });
            });
    
           
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Seleccionar todos los contenedores de productos y el botón
        const productsContainers = document.querySelectorAll(".products-container");
        const allBtn = document.getElementById("all-btn");
        const allProductsContainer = document.getElementById("all-products-container");
        allProductsContainer.style.display = "none"
        allBtn.addEventListener("click", function () {
            allProductsContainer.style.display = "flex"
            allProductsContainer.style.flexDirection = "column"


            // Desplazar hasta el contenedor "all-products-container"
            if (allProductsContainer) {
                allProductsContainer.scrollIntoView({
                    behavior: 'smooth', // Desplazamiento suave
                    block: 'start' // Alinear al inicio de la ventana
                });
            }

            console.log("Todos los contenedores ocultos y desplazado a la sección de todos los productos");
        });
    });
</script>

</body>

</html>
