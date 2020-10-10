<?php
	require_once("db_.php");
  $texto=$_REQUEST['texto'];
  $idcliente=$_REQUEST['idcliente'];
  $id2=$_REQUEST['id2'];

  $sql="SELECT * from clientes where nombre like '%$texto%' limit 100";
  $sth = $db->dbh->prepare($sql);
  $sth->execute();
  echo "<table class='table table-sm'>";
  echo "<tr><th>-</th><th>Prof.</th><th>Nombre </th><th>Correo</th><th>Teléfono</th></tr>";
  foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
    echo "<tr>";
      echo "<td>";
        echo "<div class='btn-group'>";
        echo "<button type='button' is='b-link' db='a_citas/db_' fun='agrega_cliente' des='a_citas/editar' desid='idcitas' dix='trabajo' v_idcliente='$key->idcliente' cmodal='2' class='btn btn-warning btn-sm' title='Seleccionar cliente'><i class='fas fa-plus'></i></button>";
        echo "</div>";
      echo "</td>";
      echo "<td>";
          echo $key->profesion;
      echo "</td>";
      echo "<td>";
          echo $key->nombre." ".$key->apellidop." ".$key->apellidom;
      echo "</td>";
      echo "<td>";
          echo $key->correo;
      echo "</td>";
      echo "<td>";
          echo $key->telefono;
      echo "</td>";
    echo "</tr>";
  }
  echo "</table>";
?>
