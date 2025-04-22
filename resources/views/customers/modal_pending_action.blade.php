

 <!-- Botón para abrir el modal -->
 <button type="button" class="btn btn-primary btn-sm fa fa-check"  data-toggle="modal" data-target="#exampleModal">
    
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Completar Tarea</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/customers/{{$model->id}}/action/store" method="POST" id="complete_action_form">
            {{ csrf_field() }}
        <div class="modal-body">
        <textarea name="comment_pending_action" id="comment_pending_action" cols="30" rows="10"></textarea>
        <input type="hidden" id="action_id" name="action_id" value="{{$item->id}}">
        <div>
            <select name="type_id" id="type_id">
                <option value="">Seleccione una acción</option>
                @foreach($action_options as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            
            
            <select name="status_id" id="status_id">
                <option value="">Seleccione un estado</option>
                @foreach($statuses_options as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
        </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="senForm()">Guardar Cambios</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <script>
    function senForm() {
  // Puedes realizar aquí validaciones antes de enviar el formulario
  document.getElementById('complete_action_form').submit();
}

  </script>