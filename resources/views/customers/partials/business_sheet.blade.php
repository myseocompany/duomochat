<div class="mt-4 border-t pt-4">
  <h3 class="text-sm font-semibold text-gray-700 mb-2">Hoja de Negocios</h3>
  
  <div class="text-xs text-gray-600">
    <p><strong>Asesor:</strong> {{ model?.order?.User?.name || '—' }}</p>

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