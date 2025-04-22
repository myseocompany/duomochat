<header id="main-header" class="px-4 lg:px-6 py-4 flex items-center justify-center border-b sticky top-0 bg-white h-15 gap-5">
    <!-- div que contiene el logo -->
    <div class="div-logo cursor-pointer" onclick="reloadPage()">
        <img class="h-10" src="https://elemental.aricrm.co/img/ptp_logo.jpg" alt="Logo PTP">
    </div>
    <!-- fin del div que contiene el logo -->

    <!-- input de búsqueda -->
    <div class="contenedor-input flex-1">
        <input
        type="search"
        name="search"
        id="input-search"
        placeholder="Escribe un producto..."
        class="border border-gray-500 border-solid outline-none rounded-[10px] pl-[10px] w-full">
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Seleccionar el input de búsqueda
        const searchInput = document.getElementById("input-search");
        const banner = document.getElementById("banner");
        const allContainer = document.getElementById("all-products-container");

        // Crear el elemento <h4> para mostrar el mensaje
        const noResultsMessage = document.createElement("h4");
        noResultsMessage.textContent = "No se encontraron resultados";
        noResultsMessage.style.display = "none"; // Ocultar por defecto
        noResultsMessage.style.textAlign = "center";
        noResultsMessage.style.color = "#23242a";
        noResultsMessage.style.marginTop = "20px";
        noResultsMessage.style.fontSize = "30px";

        // Insertar el mensaje antes de "Todos nuestros productos"
        allContainer.parentNode.insertBefore(noResultsMessage, allContainer);

        // Añadir el evento 'input' al campo de búsqueda
        searchInput.addEventListener("input", function() {
            banner.style.display = "none";
            allContainer.style.display = "block";
            const searchValue = searchInput.value.toLowerCase(); // Convertir a minúsculas para coincidencias insensibles a mayúsculas

            const products = document.querySelectorAll(".bg-card"); // Seleccionar todos los productos dentro de categorías
            const allProducts = document.querySelectorAll(".bg-card-all"); // Seleccionar todos los productos en "Todos los productos"
            const categoryContainers = document.querySelectorAll(".products-container"); // Seleccionar contenedores de categorías

            let hasResults = false; // Bandera para verificar si hay resultados

            // Mostrar el banner si la búsqueda está vacía
            if (searchInput.value === "") {
                banner.style.display = "flex";
                categoryContainers.forEach(container => {
                    container.style.display = "block"; // Mostrar todas las categorías
                });
                noResultsMessage.style.display = "none"; // Ocultar el mensaje
                return;
            }

            // Ocultar o mostrar productos según la búsqueda
            products.forEach(product => {
                const productName = product.querySelector(".product-name").textContent.toLowerCase();
                if (productName.includes(searchValue)) {
                    product.style.display = ""; // Mostrar el producto
                    hasResults = true; // Hay al menos un resultado
                } else {
                    product.style.display = "none"; // Ocultar el producto
                }
            });

            allProducts.forEach(product => {
                const productName = product.querySelector(".product-name").textContent.toLowerCase();
                if (productName.includes(searchValue)) {
                    product.style.display = ""; // Mostrar el producto
                    hasResults = true; // Hay al menos un resultado
                } else {
                    product.style.display = "none"; // Ocultar el producto
                }
            });

            // Ocultar categorías que no tienen coincidencias
            categoryContainers.forEach(container => {
                const visibleProducts = container.querySelectorAll(".bg-card:not([style*='display: none'])");
                if (visibleProducts.length === 0) {
                    container.style.display = "none"; // Ocultar la categoría si no hay productos visibles
                } else {
                    container.style.display = "block"; // Mostrar la categoría si tiene productos visibles
                }
            });

            // Mostrar u ocultar el mensaje "No se encontraron resultados"
            if (!hasResults) {
                noResultsMessage.style.display = "block"; // Mostrar el mensaje
            } else {
                noResultsMessage.style.display = "none"; // Ocultar el mensaje
            }
        });
    });

    //funcion para recargar la pagina cuando se le da click al logo
    function reloadPage(){
        window.location.reload()
    }
</script>


