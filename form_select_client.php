<?php
session_start();
include('config/conexion.php');
include('config/variables.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] != "1")
  echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
  $userId = $_SESSION['userId'];

  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        CLIENTES
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
          Nuevo Cliente
        </button>
      </div>	  
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Cliente</h4>
          </div>
          <div class="error"></div>
          <form id="formAddClient" name="formAddClient" method="POST" >
            <div class="modal-body">
              <input type="hidden" name="userId" value="<?= $userId; ?>" >
              <fieldset>
				<legend>Cliente</legend>
				  <div class="form-group">
					<label>Nombre</label>
					<input type="text" id="inputNombre" name="inputNombre" class="form-control">
				  </div>             
				  <div class="form-group">
					<label>Apellido paterno</label>
					<input type="text" id="inputAP" name="inputAP" class="form-control">
				  </div> 
				  <div class="form-group">
					<label>Apellido materno</label>
					<input type="text" id="inputAM" name="inputAM" class="form-control">
				  </div>
				  <div class="form-group">
					<label>R.F.C.</label>
					<input type="text" id="inputRFC" name="inputRFC" class="form-control">
				  </div>
				  <div class="form-group">
					<label>Porcentaje de descuento</label>
					<input type="number" id="inputPorcDesc" name="inputPorcDesc" class="form-control">
				  </div>
			  </fieldset>
			  <fieldset>
				<legend>Contacto</legend>
				  <div class="form-group">
					<label>Teléfono</label>
					<input type="number" id="inputTel" name="inputTel" class="form-control">
				  </div>             
				  <div class="form-group">
					<label>Celular</label>
					<input type="number" id="inputCel" name="inputCel" class="form-control">
				  </div> 
				  <div class="form-group">
					<label>Correo electrónico</label>
					<input type="text" id="inputMail" name="inputMail" class="form-control">
				  </div>
			  </fieldset>
			  <fieldset>
				<legend>Dirección</legend>
				<div class="form-group">
					<label>Calle</label>
					<input type="text" id="inputCalle" name="inputCalle" class="form-control">
				  </div>
				  <div class="form-group">
					<label>Número</label>
					<input type="text" id="inputNum" name="inputNum" class="form-control">
				  </div>
				  <div class="form-group">
					<label>Colonia</label>
					<input type="text" id="inputCol" name="inputCol" class="form-control">
				  </div>
				  <div class="form-group">
					<label>Municipio</label>
					<input type="text" id="inputMun" name="inputMun" class="form-control">
				  </div>
				  <div class="form-group">
					<label>Estado</label>
					<input type="text" id="inputEdo" name="inputEdo" class="form-control">
				  </div>
			  </fieldset>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Añadir cliente</button>
              </div>
          </form>
		</div>
      </div>
    </div>

  <br>
	 <!-- Filtro 
	 <div class="col-sm-12">
       <form id="frm_filtro" method="post" action="" class="form-inline">
           <div class="form-group">
             <select id="estatus" name="estatus" class="form-control">
               <option value="0"></option>
               <option value="1">Desactivo</option>
               <option value="2">Activo</option>
             </select>
           </div>
           <button type="button" id="btnfiltrar" class="btn btn-success">Filtrar</button>
           <a href="javascript:;" id="btncancel" class="btn btn-default">Todos</a>

         </form>
     </div>
	 -->
  <table class="table table-striped" id="data">
    <thead>
      <tr>
          <th class="t-head-first"><span title="id">Id</span></th>
        <th class="t-head"><span title="ap">Nombre</span></th>
        <th class="t-head"><span title="telefono">Teléfonos</span></th>
        <th class="t-head"><span title="correo">Correo</span></th>
        <th class="t-head"><span title="rfc">RFC</span></th>
        <th class="t-head"><span title="porc_desc">%</span></th>
        <th class="t-head-last">Modificar</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>    
  </table>

  <!-- modal para modificar datos del cliente -->
	<div class="modal fade bs-example-modal-lg" id="modalModClient" tabindex="-1" role="dialog" aria-labellebdy="myModal" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
					</button>
					<h4 class="modal-title" id="exampleModalLabel">Modificar cliente</h4>
					<p class="msgModal"></p>
				</div>
				<form id="formModClient" name="formModClient" method="POST" >
				<div class="modal-body">
				  <input type="text" name="idClient" id="idClient" >
				  <fieldset>
					<legend>Cliente</legend>
					  <div class="form-group">
						<label>Nombre</label>
						<input type="text" id="inputNombre" name="inputNombre" class="form-control">
					  </div>             
					  <div class="form-group">
						<label>Apellido paterno</label>
						<input type="text" id="inputAP" name="inputAP" class="form-control">
					  </div> 
					  <div class="form-group">
						<label>Apellido materno</label>
						<input type="text" id="inputAM" name="inputAM" class="form-control">
					  </div>
					  <div class="form-group">
						<label>R.F.C.</label>
						<input type="text" id="inputRFC" name="inputRFC" class="form-control">
					  </div>
					  <div class="form-group">
						<label>Porcentaje de descuento</label>
						<input type="number" id="inputPorcDesc" name="inputPorcDesc" class="form-control">
					  </div>
				  </fieldset>
				  <fieldset>
					<legend>Contacto</legend>
					  <div class="form-group">
						<label>Teléfono</label>
						<input type="number" id="inputTel" name="inputTel" class="form-control">
					  </div>             
					  <div class="form-group">
						<label>Celular</label>
						<input type="number" id="inputCel" name="inputCel" class="form-control">
					  </div> 
					  <div class="form-group">
						<label>Correo electrónico</label>
						<input type="text" id="inputMail" name="inputMail" class="form-control">
					  </div>
				  </fieldset>
				  <fieldset>
					<legend>Dirección</legend>
					<div class="form-group">
						<label>Calle</label>
						<input type="text" id="inputCalle" name="inputCalle" class="form-control">
					  </div>
					  <div class="form-group">
						<label>Número</label>
						<input type="text" id="inputNum" name="inputNum" class="form-control">
					  </div>
					  <div class="form-group">
						<label>Colonia</label>
						<input type="text" id="inputCol" name="inputCol" class="form-control">
					  </div>
					  <div class="form-group">
						<label>Municipio</label>
						<input type="text" id="inputMun" name="inputMun" class="form-control">
					  </div>
					  <div class="form-group">
						<label>Estado</label>
						<input type="text" id="inputEdo" name="inputEdo" class="form-control">
					  </div>
				  </fieldset>
				</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" >Actualizar cliente</button>
				  </div>
			  </form>
			</div>
		</div>
	</div>
		
  </div><!-- fin container -->

  <script type="text/javascript">
    var ordenar = '';
    $(document).ready(function () {
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/select_client.php?action=listar",
                success: function(msg){
                    console.log(msg);
					var msg = jQuery.parseJSON(msg);
					if(msg.error == 0){
						$("#data tbody").html("");
						$.each(msg.dataRes, function(i, item){
							var newRow = '<tr>'
								+'<td>'+msg.dataRes[i].id+'</td>'
								+'<td>'+msg.dataRes[i].nombre+'</td>'
								+'<td>'+msg.dataRes[i].tels+'</td>'
								+'<td>'+msg.dataRes[i].correo+'</td>'
								+'<td>'+msg.dataRes[i].rfc+'</td>'
								+'<td>'+msg.dataRes[i].porc_desc+'</td>'
								+'<td><button type="button" class="btn btn-default" data-whatever="'+msg.dataRes[i].id+'" data-toggle="modal" data-target="#modalModClient"><span class="glyphicon glyphicon-eye-open"></span></button></td>'
								+'</tr>';
							$(newRow).appendTo("#data tbody");
						});
					}else{
						var newRow = '<tr><td colspan="8">'+msg.msgErr+'</td></tr>';
						$("#data tbody").html(newRow);
					}
                }
            });
        }
        
        //Ordenar ASC y DESC header tabla
        $("#data th span").click(function(){
            if($(this).hasClass("desc")){
                $("#data th span").removeClass("desc").removeClass("asc");
                $(this).addClass("asc");
                ordenar = "&orderby="+$(this).attr("title")+" asc";
            }else{
                $("#data th span").removeClass("desc").removeClass("asc");
                $(this).addClass("desc");
                ordenar = "&orderby="+$(this).attr("title")+" desc";
            }
            filtrar();
        });
        
        //Ordenar por formulario
        $("#btnfiltrar").click(function(){ 
            filtrar();
        });
        
        // boton cancelar
		$("#btncancel").click(function(){ 
            $("#frm_filtro select").find("option[value='0']").attr("selected",true)
            filtrar() 
		});
        
        $('#modalModClient').on('show.bs.modal', function(event){
		  var button = $(event.relatedTarget);
		  var idClient = button.data('whatever');
		  $.ajax({
			  type: "POST",
			  url: "controllers/select_client_id.php",
			  data: {id: idClient},
			  success: function(msg){
				  console.log(msg);
				  var msg = jQuery.parseJSON(msg);
				  if(msg.error == 0){
					  $('#modalModClient #idClient').val(msg.dataRes[0].id);
					  $('#modalModClient #inputNombre').val(msg.dataRes[0].nombre);
					  $('#modalModClient #inputAP').val(msg.dataRes[0].ap);
					  $('#modalModClient #inputAM').val(msg.dataRes[0].am);
					  $('#modalModClient #inputRFC').val(msg.dataRes[0].rfc);
					  $('#modalModClient #inputPorcDesc').val(msg.dataRes[0].porc_desc);
					  $('#modalModClient #inputTel').val(msg.dataRes[0].tel);
					  $('#modalModClient #inputCel').val(msg.dataRes[0].cel);
					  $('#modalModClient #inputMail').val(msg.dataRes[0].correo);
					  $('#modalModClient #inputCalle').val(msg.dataRes[0].calle);
					  $('#modalModClient #inputNum').val(msg.dataRes[0].num);
					  $('#modalModClient #inputCol').val(msg.dataRes[0].col);
					  $('#modalModClient #inputMun').val(msg.dataRes[0].mun);
					  $('#modalModClient #inputEdo').val(msg.dataRes[0].edo);
				  }else{
					  var newRow = '<div class="row">'+msg.msgErr+'</div>';
					  $("#modalModClient .modal-body").html(newRow);
				  }
			  }
		  })
		})

		//añadir nuevo
		$('#formAddClient').validate({
			rules: {
				inputNombre: {required: true, maxlength: 50},
				inputAP: {required: true, maxlength: 50},
				inputAM: {maxlength: 50},
				inputRFC: {required: true, maxlength: 13, minlength: 10},
				inputPorcDesc: {required: true, digits: true, range: [0, 100]},
				inputTel: {digits: true, maxlength: 10, minlength: 10},
				inputCel: {digits: true, maxlength: 10, minlength: 10},
				inputMail: {email: true}
			},
			messages: {
				inputNombre:{
					required: "Nombre obligatorio",
					maxlength: "Máximo de caracteres excedido"
				},
				inputAP:{
					required: "Apellido paterno obligatorio",
					maxlength: "Máximo de caracteres excedido"
				},
				inputAM: "Máximo de caracteres excedido",
				inputRFC:{
					required: "RFC obligatorio",
					maxlength: "Máximo 13 caracteres",
					minlength: "Mínimo 10 caracteres"
				},
				inputPorcDesc:{
					required: "Porcentaje obligatorio",
					digits: "Solo se admiten números",
					range: "Rango de 0 a 100 %"
				},
				inputTel:{
					digits: "Solo se admiten números",
					maxlength: "máximo 10 números",
					minlength: "mínimo 10 números"
				},
				inputCel:{
					digits: "Solo se admiten números",
					maxlength: "máximo 10 números",
					minlength: "mínimo 10 números"
				},
				inputMail: "Formato de correo invalido"
			},
			tooltip_options: {
				inputNombre: {trigger: "focus", placement: "bottom"},
				inputAP: {trigger: "focus", placement: "bottom"},
				inputAM: {trigger: "focus", placement: "bottom"},
				inputRFC: {trigger: "focus", placement: "bottom"},
				inputPorcDesc: {trigger: "focus", placement: "bottom"},
				inputTel: {trigger: "focus", placement: "bottom"},
				inputCel: {trigger: "focus", placement: "bottom"},
				inputMail: {trigger: "focus", placement: "bottom"}
			},
			submitHandler: function(form){
				$('#loading').show();
				$.ajax({
					type: "POST",
					url: "controllers/create_client.php",
					data: $('form#formAddClient').serialize(),
					success: function(msg){
						var msg = jQuery.parseJSON(msg);
                            if(msg.error == 0){
								$('.error').css({color: "#77DD77"});
								$('.error').html("Se creo el cliente éxito.");
								setTimeout(function () {
									location.href = 'form_select_client.php';
								}, 1500);
							}else{
								$('.error').css({color: "#FF0000"});
								$('.error').html(msg.msgErr);
							}
					}, error: function(){
						alert("Error al añadir cliente.");
					}
				});
			}
		}); // end añadir nueva materia
      
	    //modificar cliente
		$('#formModClient').validate({
			rules: {
				inputNombre: {required: true, maxlength: 50},
				inputAP: {required: true, maxlength: 50},
				inputAM: {maxlength: 50},
				inputRFC: {required: true, maxlength: 13, minlength: 10},
				inputPorcDesc: {required: true, digits: true, range: [0, 100]},
				inputTel: {digits: true, maxlength: 10, minlength: 10},
				inputCel: {digits: true, maxlength: 10, minlength: 10},
				inputMail: {email: true}
			},
			messages: {
				inputNombre:{
					required: "Nombre obligatorio",
					maxlength: "Máximo de caracteres excedido"
				},
				inputAP:{
					required: "Apellido paterno obligatorio",
					maxlength: "Máximo de caracteres excedido"
				},
				inputAM: "Máximo de caracteres excedido",
				inputRFC:{
					required: "RFC obligatorio",
					maxlength: "Máximo 13 caracteres",
					minlength: "Mínimo 10 caracteres"
				},
				inputPorcDesc:{
					required: "Porcentaje obligatorio",
					digits: "Solo se admiten números",
					range: "Rango de 0 a 100 %"
				},
				inputTel:{
					digits: "Solo se admiten números",
					maxlength: "máximo 10 números",
					minlength: "mínimo 10 números"
				},
				inputCel:{
					digits: "Solo se admiten números",
					maxlength: "máximo 10 números",
					minlength: "mínimo 10 números"
				},
				inputMail: "Formato de correo invalido"
			},
			tooltip_options: {
				inputNombre: {trigger: "focus", placement: "bottom"},
				inputAP: {trigger: "focus", placement: "bottom"},
				inputAM: {trigger: "focus", placement: "bottom"},
				inputRFC: {trigger: "focus", placement: "bottom"},
				inputPorcDesc: {trigger: "focus", placement: "bottom"},
				inputTel: {trigger: "focus", placement: "bottom"},
				inputCel: {trigger: "focus", placement: "bottom"},
				inputMail: {trigger: "focus", placement: "bottom"}
			},
			submitHandler: function(form){
				$('#loading').show();
				$.ajax({
					type: "POST",
					url: "controllers/update_client.php",
					data: $('form#formModClient').serialize(),
					success: function(msg){
						var msg = jQuery.parseJSON(msg);
                            if(msg.error == 0){
								$('.error').css({color: "#77DD77"});
								$('.error').html("Se modifico el cliente con éxito.");
								setTimeout(function () {
									location.href = 'form_select_client.php';
								}, 1500);
							}else{
								$('.error').css({color: "#FF0000"});
								$('.error').html(msg.msgErr);
							}
					}, error: function(){
						alert("Error al actualizar cliente.");
					}
				});
			}
		}); // end modificar
      

      
      $('#myModalAdd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });
      $('#myModalUpd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>
