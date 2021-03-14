<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['storeId']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión en tienda</h2></div></div>';
else if (!isset($_SESSION['sessU']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de usuario</h2></div></div>';
else {
  $idStore = $_SESSION['storeId'];
  $idUser = $_SESSION['userId'];
	include('config/variables.php');
  
  $sqlGetCategories = "SELECT * FROM $tCategory WHERE activo='1' ";
  $resGetCategories = $con->query($sqlGetCategories);
  $optCategories = '';
  if ($resGetCategories->num_rows > 0) {
    while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
      //$optCategories .= '<button type="button" class="clickCategory" title="'.$rowGetCategories['id'].'">'.$rowGetCategories['nombre'].'</button> ';
      $optCategories .= '<div class="col-sm-2 div-img-sales"><img src="'.$rutaImgCat . $rowGetCategories['img'] . '" class="clickCategory img-sales" title="' . $rowGetCategories['id'] . '" width="100%">' . $rowGetCategories['nombre'] . '</div>';
    }
  } else {
    $optCategories .= 'No hay categorias disponibles';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="row">
    <div class="col-xs-5 sales sales-izquierda">
      <div class="ticket text-center">
        <form id="formTicket" method="POST" action="controllers/set_price.php" target="_blank">
          <input type="hidden" name="idStore" value="<?= $idStore; ?>">
          <input type="hidden" name="idUser" value="<?= $idUser; ?>">
          <div class="cobrar row">
            <div class="form-group col-xs-4">
              <label>Total:</label></br>
              <input type="text" id="inputTotal" name="inputTotal" readonly step=0.01 class="form-control col-xs-12" >
            </div>
            <div class="form-group col-xs-4">
              <label>Cantidad descontada</label>
              <input type="text" id="inputCantDesc" name="inputCantDesc" class="form-control" step=0.01 readonly>
            </div>
            <div class="form-group col-xs-4">
			  <label>Total con descuento</label>
			  <input type="text" id="inputTotal2" name="inputTotal2" class="form-control" step=0.01 readonly>
			</div>
          </div>
		  <div class="cobrar row">
              <div class="form-group col-xs-4 descuento">
                  <label>Descuento %</label>
				  <input type="number" id="inputDesc" name="inputDesc" class="form-control calcDesc" min="0" max="100" placeholder="%" value="0">
              </div>
			  <div class="form-group col-xs-4 rfcCliente">
                <label>RFC Cliente</label>
                <input type="text" id="inputRFCCliente" name="inputRFCCliente" class="form-control" max="13">
              </div>
			  <div class="form-group col-xs-2">
				<label>Cliente:</label></br>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><span class="glyphicon glyphicon-user"></span></button>
			  </div>
			  <div class="form-group col-xs-2">
				<label>Cotizar:</label></br>
				<button type="submit" class="enviarTicket btn btn-success"><i class="fa fa-money" style="font-size: 2.2rem;"></i></button>
			  </div>
          </div>

          <div class="line"></div>
          <div class="mygrid-wrapper-div">
          <table id="dataTicket" class="table table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Precio U.</th>
                <th>Cantidad</th>
                <th>Precio F.</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
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
				  <!-- <form id="formAddClient" name="formAddClient" method="POST" > -->
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
					  <!-- <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" >Añadir cliente</button>
					  </div> -->
				  <!-- </form> -->
				</div>
			  </div>
			</div>
        </form>
      </div>
      <div class="teclado text-center">
        <form id="formTeclado" method="POST" class="form-inline">
          <div class="form-group">
            <input type="text" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Busca el producto" id="inputCod" name="inputCod">
            <input type="hidden" name="idStore" value="<?= $idStore; ?>" >
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-list"></i> Agregar</button>
          <div class="errorSearchProduct"></div>
        </form>
        <div id="teclado_numerico_2" class="text-center">
          <div class="numeric-form-sales">
            <span class="btn btn-info btn-numeric-form" onclick="teclado(7)">7</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(8)">8</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(9)">9</span>
            <br>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(4)">4</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(5)">5</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(6)">6</span>
            <br>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(1)">1</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(2)">2</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(3)">3</span>
            <br>
            <span class="btn btn-default btn-numeric-form erase"><i class="fa fa-arrow-left"></i></span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(0)">0</span>
            <span class="btn btn-default btn-numeric-form" onClick="borrarTeclado()" >C</span>
          </div>
        </div>
      </div>
    </div> <!--  fin IZQUIERDA-->
    <div class="col-sm-7 sales sales-derecha text-center">
      <div class="titulo-crud2">
        Cotización
      </div>
      <div class="row productCategory div-sales">
        <?= $optCategories; ?>
      </div>
      <div class="line"></div>
      <div class="row productSubCategory div-sales"></div>
      <div class="line"></div>
      <div class="row productInfo div-sales"></div>
    </div><!--  fin DERECHA-->
  </div>


  <script type="text/javascript">
    $(document).ready(function () {
      $(".clickCategory").click(function () {
        var category = $(this).attr("title");
        $.ajax({
          type: "POST",
          url: "controllers/select_sales_sub_categories.php",
          data: {idCategory: category},
          success: function (msg) {
            if (msg == "false") {
              $.ajax({
                type: "POST",
                url: "controllers/select_sales_sub_products_price.php",
                data: {idCategory: category, tarea: "catProduct", idStore: <?= $idStore; ?>},
                success: function (msg2) {
                  $(".productSubCategory").html('');
                  $(".productInfo").html(msg2);
                }
              });
            } else {
              $(".productInfo").html('');
              $(".productSubCategory").html(msg);
            }
          }
        });
      });

      $(".productSubCategory").on("click", ".clickSubCategory", function () {
        //$(".clickSubCategory").click(function(){
        var subCategory = $(this).attr("title");
        $.ajax({
          type: "POST",
          url: "controllers/select_sales_sub_products_price.php",
          data: {idSubCategory: subCategory, tarea: "subProduct", idStore: <?= $idStore; ?>},
          success: function (msg) {
            $(".productInfo").html(msg);
          }
        });
      });

      $(".productInfo").on("click", ".clickProduct", function () {
        var product = $(this).attr("title");
        $.ajax({
          type: "POST",
          url: "controllers/select_sales_product_price.php",
          data: {idProduct: product},
          success: function (msg) {
            $(".ticket #dataTicket tbody").append(msg);
            $(".ticket #dataTicket tbody #inputCant").focus();
            $(".ticket #dataTicket tbody #inputCant").select();
            calcTotal();
			calChange2();
          }
        });
      });

	  $(".ticket .cobrar").on("focusout", "#inputRFCCliente", function (){
		  var rfcCliente = $("#inputRFCCliente").val();
		  console.log(rfcCliente);
		  $.ajax({
			  type: "POST",
			  url: "controllers/select_desc_client.php",
			  data: {rfc: rfcCliente},
			  success: function (msg) {
				  console.log(msg);
				  var msg = jQuery.parseJSON(msg);
				  if(msg.error == 0){
					$(".ticket .cobrar #inputDesc").val(msg.dataRes[0].desc);
					$(".ticket #inputDesc").attr("readonly", true);
					$(".ticket .cobrar .rfcCliente").removeClass("has-error");
					$(".ticket .cobrar .rfcCliente").addClass("has-success");
					$("#myModalAdd #inputNombre").val(msg.dataRes[0].nombre);
					$("#myModalAdd #inputAP").val(msg.dataRes[0].ap);
					$("#myModalAdd #inputAM").val(msg.dataRes[0].am);
					$("#myModalAdd #inputRFC").val(msg.dataRes[0].rfc);
					$("#myModalAdd #inputTel").val(msg.dataRes[0].tel);
					$("#myModalAdd #inputCel").val(msg.dataRes[0].cel);
					$("#myModalAdd #inputMail").val(msg.dataRes[0].mail);
					$("#myModalAdd #inputCalle").val(msg.dataRes[0].calle);
					$("#myModalAdd #inputNum").val(msg.dataRes[0].num);
					$("#myModalAdd #inputCol").val(msg.dataRes[0].col);
					$("#myModalAdd #inputMun").val(msg.dataRes[0].mun);
					$("#myModalAdd #inputEdo").val(msg.dataRes[0].edo);
					calChange2();
				  }else{
					$(".ticket #inputDesc").attr("readonly", false);
					$(".ticket .cobrar .rfcCliente").removeClass("has-success");
					$(".ticket .cobrar .rfcCliente").addClass("has-error");
				  }
			  }
			});
	  })
	  
      $(".ticket #dataTicket tbody").on("click", ".deleteItem", function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        calcTotal();
		calChange2();
      })

      $(".ticket #dataTicket tbody").on("focus", "#inputCant", function () {
        //alert("focus Cantidad");
        input = $(this);
        //banFocusInput = true;
        actTodo();
		calChange2();
      });

      $(".ticket #dataTicket tbody").on("focusout blur change", "#inputCant", function () {
        actTodo();
		calChange2();
		//calcTotal();
		//calcChange();
      });

	  //$("#formTicket").on("keyup change blur keypress keydown", "#inputDesc", function () {
		  //actTodo();
		  //calcTotal();
		  //calcChange();
      //});
	  
      //$(".teclado #teclado_numerico_2").on("keyup change click keyprees kewdown", ".cant", actCant);
      $(".teclado #teclado_numerico_2").on("click", function () {
        actTodo();
		calChange2();
      });

      $(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", actCant);
      //$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", calcChange);
      //$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", calcTotal);

      /*$("#formTicket").on("change blur click", ".calcChange", function(){
          var total = parseFloat($(this).parent().parent().find("#inputTotal").val());
          var dinero = parseFloat($(this).val());
          var cambio = dinero-total;
          //alert(cambio);
          $("#inputCambio").val(cambio);
          calcChange();
      });*/
      $("#formTicket").on("change blur click", ".calcChange", calcChange);
      //$("#formTicket").on("change blur click", ".calcDesc", calcTotal);
      //$("#formTicket").on("change blur click focusout keyup keydown keypress", ".calcDesc", calcChange);
	  
	  $("#formTicket #inputDesc").change(function(){
		var total = parseFloat($("#inputTotal").val());
		var dinero = parseFloat($("#inputRecibido").val());
		var descuento = parseInt($("#inputDesc").val());
		var total21 = descuento * 0.01;
		var total22 = total * total21;
		var total23 = total - total22;
		total23 = total23.toFixed(2);
	    var cambio2 = dinero - total23;
	    cambio2 = cambio2.toFixed(2);
		total22 = total22.toFixed(2);
	    $("#inputTotal2").val(total23);
	    $("#inputCambio2").val(cambio2);
		$("#inputCantDesc").val(total22);
	  });
	  
	  function calChange2(){
		var total = parseFloat($("#inputTotal").val());
		var dinero = parseFloat($("#inputRecibido").val());
		var descuento = parseInt($("#inputDesc").val());
		var total21 = descuento * 0.01;
		var total22 = total * total21;
		var total23 = total - total22;
		total23 = total23.toFixed(2);
	    var cambio2 = dinero - total23;
	    cambio2 = cambio2.toFixed(2);
		total22 = total22.toFixed(2);
	    $("#inputTotal2").val(total23);
	    $("#inputCambio2").val(cambio2);
		$("#inputCantDesc").val(total22);
	  }
      function calcChange(){
          var total = parseFloat($(this).parent().parent().find("#inputTotal").val());
          var dinero = parseFloat($(this).parent().parent().find("#inputRecibido").val());
          //var descuento = parseInt($(this).parent().parent().parent().find("#inputDesc").val());
		  var descuento = parseInt($("#inputDesc").val());
        if(dinero < total || isNaN(dinero)){
            //alert("El dinero recibido no puede ser menor al total de la venta.");
            $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
        }else
            $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");
		var total21 = descuento * 0.01;
		var total22 = total * total21;
		var total23 = total - total22;
		total23 = total23.toFixed(2);
		console.log(total21+"--"+total22+"--"+total23);
        var cambio = dinero-total;
		cambio = cambio.toFixed(2);
          //alert(cambio);
          $(this).parent().parent().find("#inputCambio").val(cambio);
		  var cambio2 = dinero - total23;
		  cambio2 = cambio2.toFixed(2);
          //$(this).parent().parent().parent().find("#inputTotal2").val(total23);
          //$(this).parent().parent().parent().find("#inputCambio2").val(cambio2);
		  $("#inputTotal2").val(total23);
		  $("#inputCambio2").val(cambio2);
      }
      
      function actCant() {
        var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
        var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
        //alert(cantidadMax);
        if (cantidad < 0) {
          //cantidad = 0;
          $(this).parent().parent().find("#inputCant").val("0");
        }
        var precioF = precioU * cantidad;
        $(this).parent().parent().find("#inputPrecioF").val(precioF);
        calcTotal();
      }

      function calcTotal() {
        var total = 0;
        $(".ticket #dataTicket tbody #inputPrecioF").each(function () {
          total += parseFloat($(this).val());
        });
        total = total.toFixed(2);
        $("#inputTotal").val(total);
        
        //calculamos cambio
        var total = parseFloat($("#inputTotal").val());
        var dinero = parseFloat($("#inputRecibido").val());
        var cambio = dinero-total;
        //console.log(total);
        $("#inputCambio").val(cambio);
		//para cambio en descuento
		/*var descuento = parseInt($("#inputDesc").val());
		var total21 = descuento * 0.01;
		var total22 = total * total21;
		var total23 = total - total22;
		total23 = total23.toFixed(2);
		console.log(total21+"--"+total22+"--"+total23);
		  var cambio2 = dinero - total23;
		  cambio2 = cambio2.toFixed(2);
          $("#inputTotal2").val(total23);
          $("#inputCambio2").val(cambio2);*/
      }

      function actTodo() {
        $(".ticket #dataTicket tbody #inputCant").each(function () {
          var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
          var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
          //alert(cantidadMax);
          if (cantidad < 0) {
            //cantidad = 0;
            $(this).parent().parent().find("#inputCant").val("0");
          }
          var precioF = precioU * cantidad;
          $(this).parent().parent().find("#inputPrecioF").val(precioF);
          calcTotal();
        })
      }
      /*$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", function(){
       var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
       var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
       var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
       //alert(cantidadMax);
       if(cantidad < 0){
       //cantidad = 0;
       $(this).parent().parent().find("#inputCant").val("0");
       }
       if(cantidad > cantidadMax){
       //cantidad = cantidadMax;
       $(this).parent().parent().find("#inputCant").val(cantidadMax);
       }
       var precioF = precioU * cantidad;
       $(this).parent().parent().find("#inputPrecioF").val(precioF);
       calcTotal();
       });*/

      /*function calcTotal(){
       var total=0;
       $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
       total += parseFloat($(this).val());
       });
       total=total.toFixed(2);
       $("#inputTotal").val(total);
       }*/

      $('input.typeahead').typeahead({
        name: 'inputCod',
        remote: 'controllers/select_sales_product_json.php?query=%QUERY&store=<?= $idStore; ?>',
        limit: 8
      });

      $('#formTeclado').validate({
        rules: {
          inputCod: {required: true}
        },
        messages: {
          inputCod: "Debes introducir una nombre o código de barras"
        },
        tooltip_options: {
          inputCod: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/select_sales_product_ticket.php",
            data: $('form#formTeclado').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "false") {
                $(".errorSearchProduct").html("Error al introducir producto");
              } else {
                $(".ticket #dataTicket tbody").append(msg);
                $(".ticket #dataTicket tbody #inputCant").focus();
                $(".ticket #dataTicket tbody #inputCant").select();
                calcTotal();
              }
            },
            error: function () {
              alert("Error al buscar producto ");
            }
          });
        }
      });
      /*$('input.typeahead-devs').typeahead({
       name: 'inputCod',
       local: ['Sunday', 'Monday', 'Tuesday','Wednesday','Thursday','Friday','Saturday']
       });*/


    });
    //var input;
  </script>

  <script type="text/javascript">
    var input;
    //var banFocusInput=false;
    $("input").on("focus", function () {
      input = $(this);
      //banFocusInput = false;
      //alert(input.val());
    });

    function teclado(numero) {
      if (input != null) {
        //alert(input);

        /*if(banFocusInput)input.val(numero);
         else input.val(input.val()+numero);*/

        input.val(input.val() + numero);
        //actCant();
      }
    }

    function borrarTeclado() {
      input.val("");
    }
    /*function actCant(){
     var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
     var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
     var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
     //alert(cantidadMax);
     if(cantidad < 0){
     //cantidad = 0;
     $(this).parent().parent().find("#inputCant").val("0");
     }
     if(cantidad > cantidadMax){
     //cantidad = cantidadMax;
     $(this).parent().parent().find("#inputCant").val(cantidadMax);
     }
     var precioF = precioU * cantidad;
     $(this).parent().parent().find("#inputPrecioF").val(precioF);
     calcTotal();
     }
       
     function calcTotal(){
     var total=0;
     $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
     total += parseFloat($(this).val());
     });
     total=total.toFixed(2);
     $("#inputTotal").val(total);
     }*/
  </script>
  <?php
}//fin else sesión
include ('footer.php');
?>
