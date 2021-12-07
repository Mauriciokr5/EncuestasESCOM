<?php 
session_start();
if(empty($_SESSION['boleta'])){
    header('Location: index.php');
}

require 'database.php';

$boleta=$_SESSION['boleta'];
$idMateriaAlumno=$_POST['idMateriaAlumno'];
$q1=$_POST['q1'];
$q2=$_POST['q2'];
$q3=$_POST['q3'];
$q4=$_POST['q4'];
$q5=$_POST['q5'];


for ($i=0; $i < sizeof($idMateriaAlumno); $i++) { 
    $sql="INSERT INTO respuestas (idMateriaAlumno, q1, q2, q3, q4, q5) VALUES(".$idMateriaAlumno[$i].",".$q1[$i].",".$q2[$i].",".$q3[$i].",".$q4[$i].",".$q5[$i].")";
    if (mysqli_query($conexion, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
      
    mysqli_close($conexion);

}
header('Location: encuestaContestada.php');




/*if(isset($_POST['boleta']) && isset($_POST['CURP'])){

    $boleta=mysqli_real_escape_string($conexion,$_POST['boleta']); 
    $CURP=mysqli_real_escape_string($conexion,$_POST['CURP']); 

    $res=mysqli_query($conexion,"SELECT * FROM alumnos WHERE boleta='$boleta' and CURP='$CURP'");
    $datos=mysqli_fetch_array($res,MYSQLI_ASSOC);

    if(mysqli_num_rows($res)==1){
        $_SESSION['boleta']=$datos['boleta'];
        echo $datos['boleta'];
    }

}*/
?>