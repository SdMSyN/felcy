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

  /* Obtenemos las categorias */
  $sqlGetCategories = "SELECT id, nombre FROM $tCategory ";
  $resGetCategories = $con->query($sqlGetCategories);
  $optCategories = '<option></option>';
  while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
    $optCategories .= '<option value="' . $rowGetCategories['id'] . '">' . $rowGetCategories['nombre'] . '</option>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        PRODUCTOS FALTANTES
      </div>	  
    </div>

  <br>
  <table class="table table-striped" id="data">
    <thead>
      <tr>
          <th class="t-head-first"><span title="id">Id</span></th>
        <th class="t-head">Imagen</th>
        <th class="t-head"><span title="nombre">Producto</span></th>
        <th class="t-head"><span title="categoria">Categoría</span></th>
        <th class="t-head"><span title="subcategoria">Subcategoría</span></th>
        <th class="t-head"><span title="tienda">Almacen</span></th>
        <th class="t-head"><span title="cant">Estatus</span></th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>    
  </table>

  </div><!-- fin container -->

  <script type="text/javascript">
    var ordenar = '';
    $(document).ready(function () {
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/select_product_missing.php?action=listar",
                success: function(msg){
                    //$("#data tbody").empty();
                    $("#data tbody").html(msg);
					//console.log(msg);
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

    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>
