<nav x-data="{ mobileMenuOpen: false }" class="bg-white border-b border-gray-200 shadow-md fixed top-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/">
                    <img src="/img/logo_ari_CRM.png" alt="Logo" class="h-10">
                </a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="/login" class="text-gray-700 hover:text-blue-600 font-medium">Inicio</a>

                @auth
                    @if(Auth::user()->role_id == 1)
                        <a href="/chats" class="text-gray-700 hover:text-blue-600 font-medium">Inbox</a>
                        <a href="/customers/phase/1" class="text-gray-700 hover:text-blue-600 font-medium">Contactos</a>
                        <!--
                        <a href="/orders" class="text-gray-700 hover:text-blue-600 font-medium">Órdenes</a>
-->                     <a href="/actions" class="text-gray-700 hover:text-blue-600 font-medium">Acciones</a>
                        <a href="/products" class="text-gray-700 hover:text-blue-600 font-medium">Productos</a>
                        
                        <a href="https://panel.smartchatapp.online/" class="text-gray-700 hover:text-blue-600 font-medium">Bot</a>

                        <!-- Dropdowns -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                                Audiencias
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute mt-2 w-40 bg-white border border-gray-200 shadow-lg rounded z-50">
                                <a href="/audiences/1/customers" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Benevento</a>
                                <a href="/audiences/2/customers" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Emmanuel</a>
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                                Reportes
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute mt-2 w-40 bg-white border border-gray-200 shadow-lg rounded z-50">
                                <a href="/bi/newcustomers" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Nuevos Clientes</a>
                                <a href="/bi/purchasefrequency" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Frecuencia de Compra</a>
                                <a href="/bi/averageTicket" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ticket Promedio</a>
                            </div>
                        </div>
                    @elseif(Auth::user()->role_id == 9)
                        <a href="/orders" class="text-gray-700 hover:text-blue-600 font-medium">Órdenes</a>
                    @endif
                @endauth
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="hidden md:block relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-blue-600 font-medium focus:outline-none">
                            {{ Auth::user()->name }}
                        </button>
                        <div x-show="open" @click.away="open = false"
                             class="absolute mt-2 w-40 bg-white border border-gray-200 shadow-lg rounded z-50">
                            @if (Auth::user()->role_id == 1)
                                <a href="/config" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración</a>
                            @endif
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Salir
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>

                    <!-- Reloj con contador -->
                    <a href="/actions" class="relative flex items-center justify-center text-gray-600 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                        @if(Auth::user()->getTotalPendingActions() > 0)
                            <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ Auth::user()->getTotalPendingActions() }}
                            </span>
                        @endif
                    </a>


                    <!-- Search -->
                    <form action="/customers" method="GET" class="hidden md:flex items-center space-x-2">
                        <input type="text" name="search" placeholder="Buscar..." value="{{ request()->search }}"
                            class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring focus:border-blue-300">
                        <button type="submit" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Ir</button>
                    </form>
                @endauth

                <!-- Mobile menu toggle -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         class="md:hidden px-4 pb-4 bg-white shadow-md border-t border-gray-200">
        <a href="/" class="block py-2 text-gray-700 hover:text-blue-600">Inicio</a>

        @auth
            @if(Auth::user()->role_id == 1)
                <a href="/chats" class="block py-2 text-gray-700 hover:text-blue-600">Inbox</a>
                <a href="/customers/phase/1" class="block py-2 text-gray-700 hover:text-blue-600">Contactos</a>
                <!--
                <a href="/orders" class="block py-2 text-gray-700 hover:text-blue-600">Órdenes</a>
                -->
                <a href="/actions" class="block py-2 text-gray-700 hover:text-blue-600">Acciones</a>

                <a href="/products" class="block py-2 text-gray-700 hover:text-blue-600">Productos</a>
                <a href="/audiences/1/customers" class="block py-2 text-gray-700 hover:text-blue-600">Benevento</a>
                <a href="/audiences/2/customers" class="block py-2 text-gray-700 hover:text-blue-600">Emmanuel</a>
            @elseif(Auth::user()->role_id == 9)
                <a href="/orders" class="block py-2 text-gray-700 hover:text-blue-600">Órdenes</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2 text-gray-700 hover:text-blue-600">
                    Salir
                </button>
            </form>
        @endauth
    </div>
</nav>