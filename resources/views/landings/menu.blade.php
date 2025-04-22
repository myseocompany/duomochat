<nav id="menu" class="lg:flex hidden gap-5 sm:hidden overflow-x-auto whitespace-nowrap p-4">
    @foreach($categories as $category)
    <div class="category hover:bg-gray-100 cursor-pointer px-6">
        <a href="#cat-{{$category->id}}" class="inline-block whitespace-nowrap">{{ $category->name }}</a>
    </div>
    @endforeach
    <div class="category hover:bg-gray-100 cursor-pointer px-6">
        <button class="inline-block whitespace-nowrap" id="all-btn">Todos</button>
    </div>
</nav>

<style>
    /* Estilo para pantallas grandes */
    @media (min-width: 1496px) {
        #menu {
            justify-content: center; /* Centra el contenido horizontalmente */
            overflow-x: hidden; /* Elimina el scroll innecesario en pantallas grandes */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra en la parte inferior */
        } 
    }

    /* Estilo de la barra de desplazamiento */
    #menu::-webkit-scrollbar {
        height: 8px; /* Altura de la barra de scroll */
    }

    #menu::-webkit-scrollbar-track {
        border-radius: 10px; /* Bordes redondeados */
    }

    #menu::-webkit-scrollbar-thumb {
        background: gray; /* Color de la barra */
        border-radius: 10px; /* Bordes redondeados */
        border: 2px solid #f4f4f4; /* Espacio para un efecto flotante */
    }

    #menu::-webkit-scrollbar-thumb:hover {
        background: #808080; /* Color al pasar el cursor */
    }

    /* Estilos específicos para pantallas medianas y pequeñas */
    @media (max-width: 1024px) {
        #menu {
            display: flex; /* Asegura que los elementos se muestren en fila */
            overflow-x: auto; /* Activa el scroll horizontal */
            -webkit-overflow-scrolling: touch; /* Suaviza el scroll en dispositivos táctiles */
            gap: 1rem; /* Espaciado entre categorías */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra en la parte inferior */
        }

        .category {
            flex-shrink: 0; /* Evita que los elementos se redimensionen */
        }
    }
</style>