<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    
    /* Obtenemos los productos */
		$sqlGetProducts = "SELECT $tProduct.id, $tProduct.nombre FROM $tProduct LEFT JOIN $tStock ON $tProduct.id = $tStock.producto_id WHERE $tStock.id IS NULL ORDER BY $tProduct.nombre ";
		$resGetProducts = $con->query($sqlGetProducts);
		$optProducts = '<option></option>';
		if ($resGetProducts->num_rows > 0) {
			while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
				$optProducts.='<option value="' . $rowGetProducts['id'] . '">' . $rowGetProducts['nombre'] . '</option>';
			}
		} else {
			$optProducts = '<option>No existen productos aún</option>';
		}
    
    echo $optProducts;
?>