<?php 
session_start();

require 'database.php';


if(isset($_POST['user']) && isset($_POST['password'])){

    $user=mysqli_real_escape_string($conexion,$_POST['user']); 
    $password=mysqli_real_escape_string($conexion,$_POST['password']); 

    $res=mysqli_query($conexion,"SELECT * FROM administradores WHERE usuario='$user' and contrasena='$password'");
    $datos=mysqli_fetch_array($res,MYSQLI_ASSOC);

    if(mysqli_num_rows($res)==1){
        $_SESSION['user']=$datos['usuario'];
        echo $datos['usuario'];
        header('Location:vistaGeneral.php');
    }

}
?>