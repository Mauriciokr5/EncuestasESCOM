<?php

     $conexion = mysqli_connect("localhost", "root", "n0m3l0", "sistemaencuestas");
     /*$sql = "SELECT * FROM alumnos WHERE boleta = '2020630039'";
     $res = mysqli_query($conexion, $sql);
     $datos = mysqli_fetch_row($res);

     if(mysqli_num_rows($res)==1){
          echo $datos[0];
     }else{
          echo "<p>Error en la conexion a la base de datos</p>";
     }*/

     if( $conexion ) {
          //echo $datos;
     }else{
          die( print_r( sqlsrv_errors(), true));
     }
 ?>
