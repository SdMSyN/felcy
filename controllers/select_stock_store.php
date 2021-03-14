<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    $arrProductsStock = array();
    $banStock = true;
    $msgErr = "";
    
    //$sqlGetStockStore="SELECT id, cantidad, tienda_id, (SELECT nombre FROM $tProduct WHERE id=$tStock.producto_id ORDER BY categoria_id DESC) as producto, producto_id FROM $tStock WHERE tienda_id='$store' ORDER BY producto_id ASC";
    $sqlGetStockStore= "SELECT  "
    ."    almacenes.id as stockId, "
    ."    almacenes.cantidad as stockCant, "
    ."    almacenes.tienda_id as stockStore, "
    ."    almacenes.producto_id as stockProductId, "
    ."    productos.categoria_id as productCategory, "
    ."    productos.nombre as productName, "
    ."    categorias.nombre as categoryName, "
    ."    categorias.id as categoryId "
    ."FROM almacenes "
    ."    INNER JOIN productos ON almacenes.producto_id = productos.id "
    ."        AND productos.activo = 1 "
    ."    INNER JOIN categorias ON productos.categoria_id = categorias.id "
    ."        AND categorias.activo = 1 "
    ."WHERE almacenes.tienda_id = '$store' "
    ."ORDER BY categoryId, productName ";
    $resGetStockStore=$con->query($sqlGetStockStore);
    $optStockStore='';
    // echo $sqlGetStockStore;
    if($resGetStockStore->num_rows > 0){
        while($rowGetStockStore = $resGetStockStore->fetch_assoc()){
            
            // $optStockStore.='<tr>';
            // $optStockStore.='<td><input type="hidden" value="'.$rowGetStockStore['stockId'].'" name="stockId[]" >';
            // $optStockStore.=''.$rowGetStockStore['productName'].'</td>';
            // $optStockStore.='<td>'.$rowGetStockStore['categoryName'].'</td>';
            // $optStockStore.='<td>'.$rowGetStockStore['stockCant'].'</td>';
            // $optStockStore.='<td class="col-sm-2"><input type="number" name="inputAlm[]" id="inputAlm" value="0" class="form-control" data-id="'.$rowGetStockStore['stockId'].'"></td>';
            // $optStockStore .= '<td><a href="#" class="btn btn-primary linkSave">Guardar</a></td>';
            // $optStockStore.='<input type="hidden" value="'.$rowGetStockStore['stockStore'].'" name="tienda" id="tienda" ';
            // $optStockStore.='</tr>';

            $arrProductsStock[] = array( 'stockId' => $rowGetStockStore['stockId'], 
                'productName' => $rowGetStockStore['productName'], 
                'categoryName' => $rowGetStockStore['categoryName'],
                'stockCantidad' => $rowGetStockStore['stockCant'],
                'stockStore' => $rowGetStockStore['stockStore']
            );
        }
    }else{
        $banStock = 'false';
        $msgErr .= 'Error al leer almacen.';
    }
    
    if($banStock){
        echo json_encode( array( "error" => 0, "dataRes" => $arrProductsStock ) );
    }else{
        echo json_encode( array( "error" => 1, "msgErr" => $msgErr ) );
    }

?>