<div class="bg-white shadow rounded-xl p-6 text-center space-y-4">
  {{-- Avatar e Identidad --}}
  <div class="flex flex-col items-center justify-center">
    <div class="w-20 h-20 rounded-full bg-pink-600 text-white flex items-center justify-center text-2xl font-bold">
      {{ strtoupper(substr($model->name, 0, 1)) }}{{ strtoupper(substr($model->lastname, 0, 1)) }}
    </div>
    <h2 class="text-xl font-semibold mt-2">{{ $model->name }} {{ $model->lastname }}</h2>
    <div class="flex items-center justify-center gap-2">
        
    @if(isset($model->status))  
        <span class="text-xs text-white px-2 py-1 rounded" style="background-color:{{$model->status->color}}">en {{$model->status->name}}  </span>
    @endif
      <span class="text-gray-400 text-sm">| {{ $model->points ?? 0 }} puntos</span>
    </div>
  </div>



  {{-- Información del cliente --}}
  <div class="text-left space-y-3">
    <p class="text-sm"><span class="font-semibold">Propietario:</span> {{ $model->user->name ?? 'Sin asignar' }}</p>

    <p class="text-sm"><span class="font-semibold">Nombre:</span> {{ $model->name }}</p>
    

    <p class="text-sm flex items-center gap-2">
      <span class="font-semibold">Email:</span>
      <span>{{ $model->email }}</span>
      <button onclick="navigator.clipboard.writeText('{{ $model->email }}')" class="text-gray-400 hover:text-gray-600">
        <i class="fa fa-copy"></i>
      </button>
    </p>

    <p class="text-sm flex items-center gap-2">
      <span class="font-semibold">Teléfono:</span>
      <span>{{ $model->phone }}</span>
      <button onclick="navigator.clipboard.writeText('{{ $model->phone }}')" class="text-gray-400 hover:text-gray-600">
        <i class="fa fa-copy"></i>
      </button>
      <a href="https://wa.me/{{ clearWP($model->phone) }}" target="_blank" class="text-green-500 hover:text-green-700">
        <i class="fa fa-whatsapp"></i>
      </a>
    </p>

<form action="{{ route('customers.update', $model->id) }}" method="POST" id="quickUpdateForm">
    @csrf
    {{-- Si tu ruta es POST como en tu router, o usa PUT si usas resourceful --}}
    @method('PUT')
    <div class="flex flex-col gap-4 mt-4">

        {{-- Proyecto --}}
        <div class="flex items-center gap-2">
            <label class="font-semibold w-24 text-right">Proyecto:</label>
            <select name="project_id" onchange="document.getElementById('quickUpdateForm').submit()" class="flex-1 rounded border-gray-300 shadow-sm text-sm">
                @foreach($projects_options as $project)
                    <option value="{{ $project->id }}" {{ $model->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Producto de interés --}}
        <div class="flex items-center gap-2">
          <label class="font-semibold w-24 text-right">Producto:</label>
          <select name="interested_product_id" onchange="document.getElementById('quickUpdateForm').submit()" class="flex-1 rounded border-gray-300 shadow-sm text-sm">
            <option value="">Seleccione...</option>
            @foreach($products as $product)
              <option value="{{ $product->id }}" {{ $model->interested_product_id == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
              </option>
            @endforeach
          </select>
        </div>


        {{-- Origen --}}
        <div class="flex items-center gap-2">
            <label class="font-semibold w-24 text-right">Origen:</label>
            <select name="source_id" onchange="document.getElementById('quickUpdateForm').submit()" class="flex-1 rounded border-gray-300 shadow-sm text-sm">
                @foreach($customer_sources_options as $source)
                    <option value="{{ $source->id }}" {{ $model->source_id == $source->id ? 'selected' : '' }}>
                        {{ $source->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <!--- inicio del hoja de negocios -->
        <div class="mt-4 border-t pt-4">
          <h3 class="text-sm font-semibold text-gray-700 mb-2">Hoja de Negocios</h3>
          
          <div class="text-xs text-gray-600">
            <p><strong>Asesor:</strong> {{ model?.User?.name || '—' }}</p>

            <p><strong>Valor Casa:</strong> {{ formatCurrency(model?.order?.product?.price) }}</p>
            <p><strong>Separación:</strong> {{ formatCurrency(model?.order?.initial_payment) }}</p>
            <p><strong>Valor 40%:</strong> {{ formatCurrency(model?.order?.initial_percentage_value) }}</p>
            <p><strong>Valor 60%:</strong> {{ formatCurrency(model?.order?.remaining_percentage_value) }}</p>
            <p><strong>No. Cuotas:</strong> {{ model?.order?.installments_number }}</p>
          </div>

          <div class="mt-2">
            <button
              class="text-xs text-indigo-600 hover:underline"
              @click="openBusinessSheetModal()"
            >Editar hoja de negocios</button>
          </div>
        </div>
        <script>
            function formatCurrency(value) {
          if (!value) return '$ 0';
          return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            maximumFractionDigits: 0
          }).format(value);
        }

        </script>
        <!-- fin hoja de negocios -->

    </div>
</form>


  </div>

  {{-- Botones de acción --}}
  <div class="flex justify-center gap-3 mt-4">
    <a href="https://wa.me/{{ clearWP($model->phone) }}" target="_blank"
       class="bg-blue-100 text-blue-700 px-3 py-1 rounded flex items-center gap-1 text-sm hover:bg-blue-200 transition">
      <i class="fa fa-whatsapp"></i> Enviar whatsapp
    </a>
    
    <div class="relative" x-data="{ open: false }">
  <button @click="open = !open"
    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 flex items-center gap-2">
    Acciones <i class="fa fa-chevron-down"></i>
  </button>

  <div x-show="open" @click.away="open = false"
    x-transition
    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 text-sm py-2">

    {{-- Editar --}}
    <a href="/customers/{{ $model->id }}/edit"
      class="flex items-center gap-2 px-4 py-2 text-gray-800 hover:bg-gray-100">
      <i class="fa fa-pencil text-gray-600"></i> <span>Editar</span>
    </a>

    {{-- Asignarme --}}
    @if(is_null($model->user_id) || $model->user_id == 0)
    <a href="/customers/{{ $model->id }}/assignMe"
      class="flex items-center gap-2 px-4 py-2 text-gray-800 hover:bg-gray-100">
      <i class="fa fa-user-plus text-gray-600"></i> <span>Asignarme</span>
    </a>
    @endif

    {{-- Eliminar --}}
    @if (Auth::user()->role_id == 1)
    <form action="/customers/{{ $model->id }}/delete" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este prospecto?');">
      @csrf
      @method('DELETE')
      <button type="submit"
        class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-100">
        <i class="fa fa-trash"></i> <span>Eliminar</span>
      </button>
    </form>
    @endif

  </div>
    </div>

  </div>

{{-- Contacto alternativo --}}
@if($model->contact_name || $model->contact_email || $model->contact_phone2 || $model->contact_position)
  <div class="mt-6 border-t pt-4 text-left">
    <h4 class="text-sm font-semibold text-gray-700 mb-2">Contacto alternativo</h4>

    <div class="space-y-2 text-sm text-gray-600">
      
      @if($model->contact_name)
      <div class="flex justify-between items-center">
        <span><span class="font-medium text-gray-800">Nombre:</span> {{ $model->contact_name }}</span>
      </div>
      @endif

      @if($model->contact_email)
      <div class="flex justify-between items-center">
        <span><span class="font-medium text-gray-800">Email:</span> {{ $model->contact_email }}</span>
        <button onclick="navigator.clipboard.writeText('{{ $model->contact_email }}')" class="text-gray-400 hover:text-gray-600" title="Copiar email">
          <i class="fa fa-copy"></i>
        </button>
      </div>
      @endif

      @if($model->contact_position)
      <div class="flex justify-between items-center">
        <span><span class="font-medium text-gray-800">Parentesco:</span> {{ $model->contact_position }}</span>
        <button onclick="navigator.clipboard.writeText('{{ $model->contact_position }}')" class="text-gray-400 hover:text-gray-600" title="Copiar parentesco">
          <i class="fa fa-copy"></i>
        </button>
      </div>
      @endif

      @if($model->contact_phone2)
      <div class="flex justify-between items-center">
        <div>
          <span class="font-medium text-gray-800">Teléfono:</span> 
          <span class="bg-emerald-100 text-emerald-700 font-mono px-2 py-0.5 rounded">{{ $model->contact_phone2 }}</span>
        </div>
        <div class="flex items-center gap-2">
          <button onclick="navigator.clipboard.writeText('{{ $model->contact_phone2 }}')" class="text-gray-400 hover:text-gray-600" title="Copiar teléfono">
            <i class="fa fa-copy"></i>
          </button>
          <a href="https://wa.me/{{ clearWP($model->contact_phone2) }}" target="_blank" class="text-green-500 hover:text-green-700" title="WhatsApp">
            <i class="fa fa-whatsapp"></i>
          </a>
        </div>
      </div>
      @endif

    </div>
  </div>
@endif




</div>

<?php
function clearWP($str){
  $str = trim($str);
  $str = str_replace("+", "", $str );
  if(strlen($str) > 10)
    return $str;
  elseif(strlen($str) == 10)
    return "57" . $str;
}
?>


