@extends('layout')
<?php  function clearWP($str){
  $str = trim($str);
  $str = str_replace("+", "", $str );
  if(strlen($str)>10)
    return $str;
  elseif( strlen($str) == 10 )
    return "57".$str;  
} ?>
@section('content')
@if($model != null)
<h1 class="title"> {{$model->name}}  </h1>
{{-- Alertas --}}
@if (session('status'))
<div class="alert alert-primary alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
  {!! html_entity_decode(session('status')) !!}
</div>
@endif
@if (session('statusone'))
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
  {!! html_entity_decode(session('statusone')) !!}
</div>
@endif
@if (session('statustwo'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
  {!! html_entity_decode(session('statustwo')) !!}
</div>
@endif
{{-- fin alertas --}}
<div class="card-block">
<div class="row">
		

		@if(isset($model))
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Cliente</h3>
			<div class="row">

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Nombre:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->name}}">{{$model->name}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Cedula:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->document}}">{{$model->document}}</div>
					</div>
				</div>
				<!--
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Telefono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->phone}}">{{$model->phone}}</div>
					</div>
				</div>
-->
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Email:</label>
						<div readonly id="email" name="email" class="col-6" value="{{$model->email}}">{{$model->email}}</div>
					</div>
				</div>
        <div class="col-md-12 col-sm-12">
					<div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Género:</strong></span></div> <div class="col-md-6">@if(isset($model->gender))
            {{$model->getGenderNameAttribute()}}@endif</div></div>
				</div>

        
        <!--
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Direccion:</label>
						<div readonly id="address" name="address" class="col-6" value="{{$model->address}}">{{$model->address}}</div>
					</div>
				</div>
			-->
				
			</div>
		</div>
		@endif


		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Entrega</h3>
			<div class="row">


<!--
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Fecha:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_date}}">{{$model->delivery_date}}</div>
					</div>
				</div>
  
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Destinatario:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_name}}">{{$model->delivery_name}}</div>
					</div>
				</div>
-->
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Dirección:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->address}}">{{$model->address}}</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Telefono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->phone}}">{{$model->phone}}</div>
					</div>
				</div>
        <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Telefono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->phone2}}">{{$model->phone2}}</div>
					</div>
				</div>
<!--
        <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">TelefonoWP:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->phone_wp}}">{{$model->phone_wp}}</div>
					</div>
				</div>
        !-->
        <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Cumpleaños:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->birthday}}">
              {{$model->birthday}}
            @if($model->birthday_updated) Actualizado @endif
            </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Gestión</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Estado:</label>
						@if(isset($model->status))
            <div readonly id="" name="" class="col-6" value="{{$model->status->name}}">{{$model->status->name}}</div>
            @endif
          </div>
				</div>

				@if(isset($model->user))
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Atendido por:</label>
            
						<div readonly id="" name="" class="col-6" value="{{$model->user->name}}">{{$model->user->name}}</div>
            
          </div>
				</div>
        @endif
				@if(isset($model->source))
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Fuente:</label>
            
						<div readonly id="" name="" class="col-6" value="{{$model->source->name}}">{{$model->source->name}}</div>
            
          </div>
				</div>
        @endif
      @if(isset($model->pathology))
        <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Patología:</label>
           
						<div readonly id="" name="" class="col-6" value="{{$model->pathology}}">{{$model->pathology}}</div>
            
          </div>
				</div>
        @endif
        @if(isset($model->hobbie))
        <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Pasatiempos:</label>
           
						<div readonly id="" name="" class="col-6" value="{{$model->hobbie}}">{{$model->hobbie}}</div>
            
          </div>
				</div>
        @endif
        @if(isset($model->notes))
        <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Notas:</label>
           
						<div readonly id="" name="" class="col-6" value="{{$model->notes}}">{{$model->notes}}</div>
            
          </div>
				</div>
        @endif
				
				
				
			</div>
		</div>
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Fidelización</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Ventas Total:</label>
						
            <div readonly id="" name="" class="col-6" value="{{$model->net_total}}">
              @if(is_numeric($model->net_total)) $ {{number_format($model->net_total,0,",",".")}} @endif 
            </div>
            
          </div>
				</div>

				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Puntos:</label>
            
						<div readonly id="" name="" class="col-6" value="{{$model->points}}">{{$model->points}}</div>
            
          </div>
				</div>
      
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Bonos:</label>
            
						<div readonly id="" name="" class="col-6" value="{{$model->bonus}}">
              @if(is_numeric($model->bonus)) $ {{number_format($model->bonus,0,",",".")}} @endif 
            </div>
            
          </div>
				</div>
       
				
				
				
			</div>
		</div>

  </div>


  <form action="customers/{{$model->id}}/edit">
    {{ csrf_field() }}
    <!--
    <div class="row">
      <div class="col-md-6">
        <div class="row "><div class="col-md-6  lavel"><span class="lavel"><strong>Nombre:</strong></span></div> <div class="col-md-6">{{$model->name}}</div></div>
        <div class="row "><div class="col-md-6  lavel"><span class="lavel"><strong>Documento:</strong></span></div> <div class="col-md-6 col-sm-6">{{$model->document}}</div></div>
        <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Teléfono:</strong></span></div> <div class="col-md-6 col-sm-6">{{$model->phone}} @if($model->getPhone()!="")
          <a href="https://wa.me/{{clearWP($model->phone)}}" target="_blank">Whatsapp</a>@endif</div></div>    
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Celular:</strong></span></div> <div class="col-md-6">{{$model->phone2}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Correo Electrónico:</strong></span></div> <div class="col-md-6">{{$model->email}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Dirección:</strong></span></div> <div class="col-md-6">{{$model->address}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Facebook:</strong></span></div> <div class="col-md-6">{{$model->facebook_url}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Instagram:</strong></span></div> <div class="col-md-6">{{$model->instagram_url}}</div></div>
        </div>

        
        <div class="col-md-6">

          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>País:</strong></span></div> <div class="col-md-6">{{$model->country}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Departamento:</strong></span></div> <div class="col-md-6">{{$model->department}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Ciudad:</strong></span></div> <div class="col-md-6">{{$model->city}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Cumpleaños:</strong></span></div> <div class="col-md-6">{{$model->birthday}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Género:</strong></span></div> <div class="col-md-6">@if(isset($model->gender))
            {{$model->getGenderNameAttribute()}}@endif</div></div>
    <div class="row">
      <div class="col-md-6 lavel"><span class="lavel"><strong>Calificación:</strong></span></div> 
      <div class="col-md-6 scoring">
        
              <div class="stars-outer">
          <div class="stars-inner"></div>

          <script type="text/javascript">
            ratings = {
              scoring : {{$model->scoring}}
              
            };

             starTotal = 3;
   
             for(rating in ratings) {  
                // 2
                starPercentage = (ratings[rating] / starTotal) * 100;
                
                // 3
                starPercentageRounded = (Math.round(starPercentage / 10) * 10)+'%';
                console.log(starPercentageRounded);

                // 4
                $('.stars-inner').width(starPercentageRounded); 
              }
          </script>
        </div>   
            </div>
        </div>

          

        </div>
      </div>
            -->
      <!--
      <br>
      <h2 class="title">Productos en la orden</h2>
      <div class="row">
        <div class="col-md-6">
         
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Producto:</strong></span></div> <div class="col-md-6">{{$model->bought_products}}</div></div>
        </div>
        <div class="col-md-6">
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Valor:</strong></span></div> <div class="col-md-6"> @if(is_numeric($model->total_sold)) $ {{number_format($model->total_sold,0,",",".")}} @endif 
          </div></div>
        </div>
      </div>
      
      <br>
    !-->
      
      
      

      <br>
      <a href="/customers/{{$model->id}}/edit">
        <span class="btn btn-primary btn-sm" aria-hidden="true">Editar prospecto</span>
      </a>
      @if(is_null($model->user_id) || $model->user_id==0)
      <a href="/customers/{{$model->id}}/assignMe">
        <span class="btn btn-primary btn-sm" aria-hidden="true">Asignarme prospecto</span>
      </a>
      @endif
    </form>
  </div>

  <h2>Ordenes</h2>
  <div><a href="/orders/{{$model->id}}/create">Crear + </a></div>
  <table class="table table-striped ">
    <thead>
      <th>Id</th>
      
      <th>Fecha creación</th>
      <th>Fecha entrega</th>
      <th>Factura </th>

      <th>Estado</th>
      
      <th>Productos</th>
      <th>Valor</th>
      <th></th>
    </thead>
    <tbody>
  @if(isset($model->orders))
    @foreach($model->orders as $item)
    <tr>

      <td><a href="/orders/{{$item->id}}/show">{{$item->id}}</a></td>
      <td><a href="/orders/{{$item->id}}/show">{{$item->created_at}}</a></td>
      
      <td><a href="/orders/{{$item->id}}/show">{{$item->delivery_date}}</a></td>
      <td><a href="/orders/{{$item->id}}/show">{{$item->invoice_id}}</a></td>
      <td><a href="/orders/{{$item->id}}/show">@if(isset($item->status)){{$item->status->name}} @endif</a></td>
      <td><a href="/orders/{{$item->id}}/show">{{$item->countItems()}}</a></td>
      <td><a href="/orders/{{$item->id}}/show">$ {{number_format($item->getTotal(), 0)}}</a></td>
      <td>
  <a href="/orders/{{ $item->id }}/delete"><span class="btn btn-sm btn-danger fa fa-trash-o" aria-hidden="true" title="Eliminar"></span></a>
  </td>
    </tr>
    
      
    @endforeach
   
  @endif
  
    </tbody>
  </table>
  <br>

  @if($actual)
  <div class="accordion" id="pedding-action">
    <div class="card">
      <div class="card-header" id="headingOne">
       <h3>
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         Envío de correos
       </button>
     </h3>
   </div>
   <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
     <form action="/customers/{{$model->id}}/action/mail" method="POST">
      {{ csrf_field() }}
      <div>
        <select name="email_id" id="email_id">
          <option value="">Seleccione una opción</option>
          @foreach($email_options as $email_option)
          <option value="{{$email_option->id}}">{{$email_option->subject}}</option>
          @endforeach
        </select>
      </div>
      <div>
       <input type="hidden" id="customer_id" name="customer_id" value="{{$model->id}}">
       <input class="btn btn-primary btn-sm" type="submit" value="Enviar correo">
     </div>
   </form>
 </div>
</div>
</div>

<div class="card">
  <div class="card-header" id="headingTwo">
    <h2>
      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      Archivos</h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">

      <form method="POST" action="/customer_files" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
          <div class="container">
            <div class="row">
              <div class="col">Seleccione el archivo</div>
              <div class="col"><input type="file" class="form-control" id="file" name="file" placeholder="email" ></div>
              <input type="hidden" id="customer_id" name="customer_id" value="{{$model->id}}">
              <div class="col"><input type="submit" class="btn btn-sm btn-primary glyphicon glyphicon-pencil" aria-hidden="true"></div>
            </div>
          </div>


        </div>


 
      </form>

      <div>
        <div class="table">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>

                <th>Url</th>
                <th>Fecha de Creación</th>

                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($model->customer_files as $file)
              <tr>
                <th>{{$file->id}}</th>

                <th><a href="/public/files/{{$file->customer_id}}/{{$file->url}}">{{$file->url}}</a></th>
                <th>{{$file->created_at}}</th>

                <th>
                  <a class="btn btn-danger btn-sm" href="/customer_files/{{$file->id}}/delete" title="Eliminar">Eliminar</a>
                </th>
              </tr>
              @endforeach                              
            </tbody>
          </table>        

        </div>
      </div>
    </div>

  </div>

</div>
@endif

<h2>Acciones</h2>
<div>
  <form action="/customers/{{$model->id}}/action/store" method="POST">
    {{ csrf_field() }}
    <div>
      @if(isset($pending_action))
      <input type="hidden" name="pending_action_id" id="pending_action_id" value="{{$pending_action->id}}">
      <h3>Acción pendiente: <strong>{{$pending_action->note}}</strong></h3>
      @endif
              
      <textarea name="note" id="note" cols="100" rows="5" required="required"></textarea>
    </div>

  <div>
    <table>
      <td>
      <span>
     <select name="status_id" id="status_id" onchange="loadAction()" class="custom-select">
      <option value="">Seleccione un estado</option>
      @foreach($statuses_options as $status_option)
      <option value="{{$status_option->id}}">{{$status_option->name}}</option>
      @endforeach
    </select>
    <button class="btn btn-link" type="button" data-toggle="tooltip" data-html="true" data-placement="top" title='<h4>Clic para ver todos los estados</h4>
      <div class="box">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Estado</th>
              <th scope="col">Descripción</th>
            </tr>
          </thead>
          <tbody>
            @foreach($statuses_options as $status_option)
            <tr>
              <th scope="row" style="border-left: 5px solid {{ $status_option->color }} !important;">{{ $status_option->name }}</th>
              <td scope="row">{{ $status_option->description }}</td>
            </tr>
            @endforeach
          </tbody>
        </table></div>'><i class="fa fa-question-circle question"></i>
      </button>
    </span>
    </td>
    <td>
      <span>
        <table>
          <td>
        <div id="after_status"></div>
        <select name="type_id" id="type_id" class="custom-select">
        
      <option value="">Seleccione una acción</option>
      @foreach($action_options as $item)
      <option value="{{$item->id}}">{{$item->name}}</option>
      @endforeach
    </select>
        </td>
        <td>
        <div>
      <button class="btn btn-link" id="tooltip_type_action" type="button" data-toggle="tooltip" data-html="true" data-placement="top" style="display: none;" title='<h4>Clic para ver todas las acciones</h4>
      <div class="box">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Acción</th>
              <th scope="col">Entrada</th>
              <th scope="col">Salida</th>
              <th scope="col">Nota<th>
            </tr>
          </thead>
          <tbody>
            @foreach($action_options as $option)
            <tr>
              <th scope="row">{{ $option->name }}</th>
              <td scope="row">  @if($option->outbound==0) x @endif</td>



               <td scope="row">  @if($option->outbound==1) x @endif</td>
                <td scope="row">{{ $option->description }}</td>
            </tr>
            @endforeach
          </tbody>
        </table></div>'> <i class="fa fa-question-circle question"></i></button>
        </div>
        </td>
        </table>
    </span>



</td>
<td>
    <span>      
      <label for="font_customers">Calificación:</label>
      <select name="scoring" id="scoring" class="custom-select">
                
        @for ($i=0; $i<=3; $i++)
          <option value="{{$i}}" @if($i==$model->scoring)selected="selected" @endif>{{$i}}</option>
        @endfor
      </select>
    </span>
</div>
</td>
</table>





    <div style="margin-bottom:1rem;">
      <label for="due-date" class="col-form-label">Fecha y hora</label>
      <div>
        <input class="form-control" name="due_date" type="datetime-local"  id="due-date">
      </div>
    </div>
    <div>
      <input class="btn btn-primary btn-sm" type="submit" value="Enviar acción">
      <input type="hidden" id="customer_id" name="customer_id" value="{{$model->id}}">
    </div>
  </form>
</div>

<table class="table table-striped ">
  <thead>

    <th>Fecha</th>
    <th>Tipo Acción</th>
    <th>Creado por</th>
    
    <th>Descripción</th>
    @if (Auth::user()->role_id == 1)
    <th></th>
    @endif
    
  </thead>
  <tbody>
    @if(isset($actions)&&($actions != NULL))
    @foreach($actions as $item)
    @if($item->status_id==1)

    <tr>
      <td>
        <a href="/actions/{{$item->id}}/show" name="pending_action_id_{{$item->id}}" id="pending_action_id_{{$item->id}}">

          {{$item->created_at}}:<br>
          {{$item->due_date}}:<br>
          
          {{$item->delivery_date}}
          
        </a>
      </td>
      <td>@if(isset($item->type)&& !is_null($item->type)&& $item->type!=''){{$item->type->name}}@endif</td>
      <td>@if(isset($item->creator)&& !is_null($item->creator)&& $item->creator!=''){{$item->creator->name}}@else Automático @endif</td>
      <td>@if(($item->type_id==2 || $item->type_id==4) && ($item->object_id != null)) {{$item->getEmailSubject()}} @else {{$item->note}}@endif</td>
      
      <td>
        <!--
        <a href="/actions/{{$item->id}}/edit">
          <span class="btn btn-sm btn-success" aria-hidden="true" title="Editar">Editar</span>
        </a>
      -->
      </td>
      @if (Auth::user()->role_id == 1)
      <td>
        <a href="/actions/{{$item->id}}/destroy">
          <span class="btn btn-sm btn-danger fa fa-trash-o" aria-hidden="true" title="Eliminar"></span>
        </a>
      </td>
      <td>
        @if($item->isPending())
        <a href="/customers/{{$model->id}}/show/?action=comple&action_id={{$item->id}}#note">
          <span class="btn btn-sm btn-danger fa fa-check" aria-hidden="true" title="Marcar como completado"></span>
        </a>

        @include('customers.modal_pending_action', ['item'=>$item])
        @endif
      </td>
      @endif


    </tr>
    @endif
    @endforeach
    @endif
    
  </tbody>
</table>

<h2>Archivos</h2>
<form method="POST" action="/customer_files" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="form-group">
    <div class="container">
      <div class="row">
        <div class="col">Seleccione el archivo</div>
        <div class="col"><input type="file" class="form-control" id="file" name="file" placeholder="email" ></div>
        <input type="hidden" id="customer_id" name="customer_id" value="{{$model->id}}">
        <div class="col"><input type="submit" class="btn btn-sm btn-primary glyphicon glyphicon-pencil" aria-hidden="true"></div>
      </div>
    </div>
    

  </div>
  
  
  
</form>

<div>
  <div class="table">
    <table class="table table-striped ">
      <thead>
        <tr>
          <th>#</th>

          <th>Url</th>
          <th>Fecha de Creación</th>

          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($model->customer_files as $file)
        <tr>
          <th>{{$file->id}}</th>

          <th><a href="/public/files/{{$file->customer_id}}/{{$file->url}}">{{$file->url}}</a></th>
          <th>{{$file->created_at}}</th>

          <th>
            <a class="btn btn-danger btn-sm" href="/customer_files/{{$file->id}}/delete" title="Eliminar">Eliminar</a>
          </th>
        </tr>
        @endforeach                              
      </tbody>
    </table>        

  </div>
</div>
<br>

<h2>Historial</h2>
<div class="table-responsive">

  <ul class="list-group">

   <?php $now = \Carbon\Carbon::now();?>                 
   @foreach($histories as $history)
   <?php //dd($histories[1]->user->id);?>
   <li class="list-group-item">Cambio de estado a @if (isset($history->status) && ($history->status != ''))
     <strong>{{$history->status->name}}</strong>, @endif actualizado: {{$history->updated_at}} 
     por @if(isset($history->user) && ($history->user != '') && !is_null($history->user)){{$history->user->name}} @else Automatico @endif


     <span class="badge" style="background-color: @if(isset($history->status) && ($history->status_id != '')) {{$history->status->color}};@else gray @endif">
      <?php
      $end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $history->updated_at);
      $years = $end->diffInYears($now);
      $months = $end->diffInMonths($now);
      $days = $end->diffInDays($now);
      $hours = $end->diffInHours($now);

      $minutes = $end->diffInMinutes($now);
      $seconds = $end->diffInSeconds($now);

               // dd($now);
      ?>
      @if($years>0){{ $years }} years
      @else @if ($months>0) {{ $months }} months 
      @else @if ($days>0) {{ $days }} days 
      @else @if ($hours>0) {{ $hours }} hours 
      @else @if ($hours>0) {{ $hours }} hours 
      @else @if ($minutes>0) {{$minutes}} minutes 
      @else @if ($seconds>0) {{$seconds}} seconds 
      @endif @endif @endif @endif @endif @endif @endif
    </span></li>
    @endforeach
    <li class="list-group-item">Cambio de estado <strong>@if(isset($model->status)&& !is_null($model->status)&&$model->status!=''){{$model->status->name}}@endif</strong>
      <span class="badge" style="background-color: @if(isset($model->status)&& !is_null($model->status)&&$model->status!=''){{$model->status->color}}@else gray @endif;">
      Actual</span></li>
    </ul>
    
  </div>
  @endif
  <br>
      <h2 class="title">Contacto</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Nombre:</strong></span></div> <div class="col-md-6">{{$model->contact_name}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Correo Electrónico:</strong></span></div> <div class="col-md-6">{{$model->contact_email}}</div></div>
        </div>

        <div class="col-md-6">
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Teléfono:</strong></span></div> <div class="col-md-6">{{$model->contact_phone2}}</div></div>
          <div class="row"><div class="col-md-6 lavel"><span class="lavel"><strong>Parentesco:</strong></span></div> <div class="col-md-6">{{$model->contact_position}}</div></div>
        </div>
      </div>
            
  <h2 class="title">UTM</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="row"><div class="col-md-6 lavel"><strong>Campaña:</strong></div> <div class="col-md-6">@if(isset($model->campaign_name)&& !is_null($model->campaign_name)&&$model->campaign_name!=''){{$model->campaign_name}}@endif
          </div></div>
          <div class="row"><div class="col-md-6 lavel"><strong>Grupo de anuncios:</strong></div> <div class="col-md-6">
            @if(isset($model->adset_name)&& !is_null($model->adset_name)&&$model->adset_name!=''){{$model->adset_name}} @else Sin asignar @endif
          </div></div>
        </div>
        <div class="col-md-6">
          <div class="row"><div class="col-md-6 lavel"><strong>Anuncio:</strong></div> <div class="col-md-6">
            @if(isset($model->ad_name)&& !is_null($model->ad_name)&&$model->ad_name!=''){{$model->ad_name}}
            @endif
          </div></div>
          <div class="row"><div class="col-md-6 lavel"><strong>Fuente:</strong></div> <div class="col-md-6">
            @if(isset($model->source_name)&& !is_null($model->source_name)&&$model->source_name!=''){{$model->source_name}}
            @endif
          </div></div>
        </div>  
      </div>

   <script type="text/javascript">

      var status_id = $("#status_id").val();
      if(status_id == ""){
        status_id = 0;
        endpoint = '/action_type/'+status_id;
        $.ajax({
              type: 'GET', //THIS NEEDS TO BE GET
              url: endpoint,
              dataType: 'json',
              success: function (data) {
                  //loadSubTypes(data, hidden_sub_type_id);
                  console.log(data);
                  loadActionTypes(data);
              },
              error: function(data) { 
                console.log(data);
              }
          });
      }

      function loadAction(){
        /*
        $("#after_status").empty();
        $("#tooltip_type_action").css("display", "none");
        var status_id = $("#status_id").val();
          console.log(status_id);


          endpoint = '/action_type/'+status_id;
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: endpoint,
            dataType: 'json',
            success: function (data) {
                //loadSubTypes(data, hidden_sub_type_id);
                console.log(data);
                loadActionTypes(data);
            },
            error: function(data) { 
              console.log(error);
            }
        });
        */
      }

        function loadActionTypes(data){
          /*
          str = '<select name="type_id" id="type_id" class="custom-select">;';
          str += '<option value="">Seleccione una acción</option>';
          $.each(data, function(i, obj) {
            str += '<option value="'+obj.id+'" >'+obj.name+'</option>';
          });
          str += '</select>';

          $("#after_status").prepend(str);
          $("#tooltip_type_action").css("display", "block");
          */
        }
    </script>
  @endsection
