<?php 
session_start();

require 'database.php';


if(isset($_POST['boleta']) && isset($_POST['CURP'])){

    $boleta=mysqli_real_escape_string($conexion,$_POST['boleta']); 
    $CURP=mysqli_real_escape_string($conexion,$_POST['CURP']); 

    $res=mysqli_query($conexion,"SELECT * FROM alumnos WHERE boleta='$boleta' and CURP='$CURP'");
    $datos=mysqli_fetch_array($res,MYSQLI_ASSOC);

    if(mysqli_num_rows($res)==1){
        $_SESSION['boleta']=$datos['boleta'];
        echo $datos['boleta'];
    }

    }
?>