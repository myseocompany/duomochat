<div class="p-6">

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Buscador -->
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Buscar Cliente:</label>
        <input type="text" wire:model.live.debounce.500ms="search" class="w-full border rounded p-2" placeholder="Nombre, email o teléfono">
    </div>

    <!-- Resultados -->
    @if($search && $matchingCustomers->count())
        <div class="mb-4 border rounded p-2 bg-gray-50 shadow-sm">
            <h3 class="font-semibold mb-2 text-gray-700">Resultados:</h3>
            <ul>
                @foreach($matchingCustomers as $customer)
                    <li class="flex justify-between items-center py-1 border-b">
                        <div>
                            <span class="font-medium">{{ $customer->name }}</span> 
                            <span class="text-sm text-gray-500">({{ $customer->phone }})</span>
                            <span class="text-sm text-gray-500">({{ $customer->email }})</span>
                            
                        </div>
                        
                        <button wire:click="addCustomerToAudience({{ $customer->id }})"
                            wire:loading.attr="disabled"
                            wire:key="add-{{ $customer->id }}"
                            class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700">
                        Agregar
                    </button>
                    
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif($search)
        <p class="text-sm text-gray-500 italic">No se encontraron resultados.</p>
    @endif

    <!-- Tabla de clientes en la audiencia -->
    <div class="mt-8 relative overflow-x-auto border rounded shadow-sm">
        <h2 class="text-lg font-bold px-4 pt-4">Clientes en esta audiencia</h2>
        <table class="w-full text-sm text-left text-gray-600 mt-2">
            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3">Cliente</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Nota</th>
                    <th class="px-6 py-3">Última acción</th>
                    <th class="px-6 py-3">Acciones</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse($audienceCustomers as $cust)
                    @php
                        $ac = DB::table('audience_customer')
                                ->where('audience_id', $audienceId)
                                ->where('customer_id', $cust->id)
                                ->first();
                    @endphp
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $cust->name }}</td>
                        <td class="px-6 py-4">{{ $cust->phone }}</td>
                        <td class="px-6 py-4">
                            <input type="text"
                                   wire:blur="updateNote({{ $ac->id }}, $event.target.value)"
                                   class="w-full border rounded p-1 text-sm"
                                   value="{{ $ac->note }}">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $cust->updated_at->diffForHumans() }}</td>
                    
                        <td class="px-6 py-4">
                            <button wire:click="removeCustomerFromAudience({{ $cust->id }})"
                                    wire:loading.attr="disabled"
                                    wire:key="remove-{{ $cust->id }}"
                                    class="text-red-600 hover:underline text-sm">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay clientes en esta audiencia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>

</div>
