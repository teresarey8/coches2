<style>
    th{
        width: 8rem;
        text-align: left;
        border-bottom: 1px solid black;
    }
    td{
        width: 8rem;
    }
</style>

<h1>Ejemplo 6: Vista de coche</h1>
<table>
    <tr>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Color</th>
        <th>Propietario</th>
    </tr>
<!--Este ejemplo muestra la información de un único coche en la
 tabla. En lugar de utilizar un bucle foreach, se accede directamente
 a un solo objeto $rowset, que contiene los datos del coche individual seleccionado.-->
    <tr>
        <td><?php echo $rowset->getMarca() ?></td>
        <td><?php echo $rowset->getModelo() ?></td>
        <td><?php echo $rowset->getColor() ?></td>
        <td><?php echo $rowset->getPropietario() ?></td>
    </tr>
</table>