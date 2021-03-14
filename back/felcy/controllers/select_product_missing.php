<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $sqlGetProducts = "SELECT $tStock.id as id, "
                . "$tProduct.nombre as nombre, "
                . "$tCategory.nombre as categoria, "
                . "$tSubCategory.nombre as subcategoria, "
                . "$tProduct.img as img, "
				. "$tProduct.cant_minima as cantMin, "
				. "$tStock.cantidad as cant, "
				. "$tStore.nombre as tienda "
                . "FROM $tStock "
				. "INNER JOIN $tProduct ON $tProduct.id = $tStock.producto_id "
                . "INNER JOIN $tCategory ON $tCategory.id = $tProduct.categoria_id "
                . "INNER JOIN $tSubCategory ON $tSubCategory.id = $tProduct.subcategoria_id "
                . "INNER JOIN $tStore ON $tStore.id = $tStock.tienda_id "
				. "WHERE $tStock.cantidad <= $tProduct.cant_minima  ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
            $sqlGetProducts .= " ORDER BY ".$vorder;
	}else{
            $sqlGetProducts .= " ORDER BY categoria, nombre ";
        }
        
        //Ejecutamos query
        //echo '<br>query: '.$sqlGetProducts.'<br>';
        $resGetProducts = $con->query($sqlGetProducts);
        $datos = '';
        //$datos .= '<tr><td colspan="7">'.$sqlGetCateories.'</td></tr>';
        while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
            $datos .= ($rowGetProducts['cant'] != 0) ? '<tr class="warning">' : '<tr class="danger">';
            $datos .= '<td>'.$rowGetProducts['id'].'</td>';
            $datos .= '<td><img src="' . $rutaImgProd . $rowGetProducts['img'] . '" class="img-product-list"></td>';
            $datos .= '<td>'.$rowGetProducts['nombre'].'</td>';
            $datos .= '<td>'.$rowGetProducts['categoria'].'</td>';
            $datos .= '<td>'.$rowGetProducts['subcategoria'].'</td>';
            $datos .= '<td>'.$rowGetProducts['tienda'].'</td>';
			$datos .= ($rowGetProducts['cant'] == 0) ? '<td>Sin existencias</td>' : '<td>Pocas unidades ['.$rowGetProducts['cant'].']</td>';
            
            $datos .= '</tr>';
        }
        echo $datos;
    }
    
?>
