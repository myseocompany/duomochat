<!--- inicio del hoja de negocios -->
        @php
        function formatCurrency($value) {
            return '$ ' . number_format($value ?? 0, 0, ',', '.');
        }
        @endphp
        <div class="mt-4 border-t pt-4">
          <h3 class="text-sm font-semibold text-gray-700 mb-2">Hoja de Negocios</h3>
          

          {{-- Pago inicial --}}
{{-- Valor total de la casa --}}
<div class="flex items-center gap-2">
  <label class="font-semibold w-24 text-right">Valor casa:</label>
  <input type="number" name="price" value="{{ old('price', $model->firstOrder()->price ?? '') }}"
         class="flex-1 rounded border-gray-300 shadow-sm text-sm" placeholder="COP">
</div>

{{-- Valor de separación --}}
<div class="flex items-center gap-2">
  <label class="font-semibold w-24 text-right">Separación:</label>
  <input type="number" name="initial_payment" value="{{ old('initial_payment', $model->firstOrder()->initial_payment ?? '') }}"
         class="flex-1 rounded border-gray-300 shadow-sm text-sm" placeholder="COP">
</div>

{{-- Porcentaje cuota inicial --}}
<div class="flex items-center gap-2">
  <label class="font-semibold w-24 text-right">% Inicial:</label>
  <input type="number" name="initial_percentage" value="{{ old('initial_percentage', $model->firstOrder()->initial_percentage ?? '') }}"
         class="flex-1 rounded border-gray-300 shadow-sm text-sm" placeholder="Ej: 40">
</div>





          <div class="mt-2">
            <button class="text-xs text-indigo-600 hover:underline">
              Editar hoja de negocios
            </button>
          </div>
        </div>


        <!-- fin hoja de negocios -->