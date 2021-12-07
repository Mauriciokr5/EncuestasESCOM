<?php
session_start();
require 'database.php';

if(empty($_SESSION['boleta'])){
    header('Location: index.php');
}


$boleta = $_SESSION['boleta'];

$sql = "SELECT COUNT(a.boleta) FROM materiaAlumno ma inner join alumnos a on a.boleta = ma.boleta inner join respuestas r on r.idMateriaAlumno = ma.idMateriaAlumno WHERE a.boleta = '$boleta'";
$res = mysqli_query($conexion, $sql);
$datos = mysqli_fetch_row($res);


if($datos[0]>0){
    mysqli_close($conexion);
    header('Location: encuestaContestada.php');
}


$res=mysqli_query($conexion,"SELECT a.boleta, ma.idMateriaAlumno, m.nomMateria FROM materiaGrupo mg inner join materias m on m.idMateria = mg.idMateria inner join materiaAlumno ma on ma.idMateriaGrupo = mg.idMateriaGrupo inner join alumnos a on a.boleta = ma.boleta WHERE a.boleta = '$boleta'");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv=refresh content=2>-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/navbar_css.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <title>Encuesta</title>
</head>

<body>
    <br>
    <br>
    <a href="logOutAlumnos.php">Cerrar Sesión</a>
    <div class="container ref">
        <h1 class="titulo">Encuesta de satifaccion escolar</h1>
        <p style="font-size: 20px;">Contestar todas las pregunta y realizar un comentario</p>
        <div class="row ">
            <div class="col-lg-12 col-12 espacio-div" style="text-align: center;">
                <form action="responderEncuesta.php" method="POST">
                    <div class="table-responsive">
                        <table class="table espacio-tabla">
                            <thead>
                                <tr class="centrarPreguntas">
                                    <th scope="col">Materia</th>
                                    <th scope="col">Te gusta el chocolate?</th>
                                    <th scope="col">Las saladitas son horneadas</th>
                                    <th scope="col">Y esto que es?</th>
                                    <th scope="col">A poco no raza?</th>
                                    <th scope="col">Me falto una jsjs</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                
                                while ($fila = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo "<tr>";
                                    echo "<th scope=\"row\">".$fila['nomMateria']."</th>";
                                    echo "<input name = \"idMateriaAlumno[]\" type=\"hidden\" value=\"".$fila['idMateriaAlumno']."\">";
                                    
                                    for ($j = 0; $j<5; $j++) {
                                        echo "<td><p class=\"clasificacion\">";
                                        for ($i = 0; $i<5; $i++) {
                                            echo "<input id=\"".$fila['idMateriaAlumno']."radio".$i."-".$j."\" type=\"radio\" name=\"q".($j+1)."[]\" value=\"".(5-$i)."\">";
                                            echo "<label for=\"".$fila['idMateriaAlumno']."radio".$i."-".$j."\">★</label>";
                                        }
                                        echo "</p></td>";
                                    }
                                    echo "</tr>";
                                }
                                mysqli_close($conexion);
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <input class="comentario" type="text" name="comentario" placeholder="Comentario" required="true">
                    <br><br>
                    <input type="submit" name="Aceptar" value="Enviar" class="form-control bot" required="true">
                </form>


            </div>
        </div>
    </div>
    <footer class="page-footer">

        <div class="foocool">
            <div class="container">
                <p class="piedepagina">© Team Chulada 2021</p>
            </div>
        </div>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<style>
    .centrarPreguntas {
        text-align: center;
    }
    
    .espacio-tabla th {
        padding: 20px;
    }
    
    .espacio-tabla td {
        padding: 20px;
    }
    
    .espacio-div {
        margin: 50px auto 100px auto;
    }
    
    #form {
        width: 250px;
        margin: 0 auto;
        height: 50px;
    }
    
    #form p {
        text-align: center;
    }
    
    #form label {
        font-size: 20px;
    }
    
    input[type="radio"] {
        display: none;
    }
    
    label {
        color: grey;
    }
    
    .clasificacion {
        direction: rtl;
        unicode-bidi: bidi-override;
        text-align: center;
    }
    
    label:hover,
    label:hover~label {
        color: orange;
    }
    
    input[type="radio"]:checked~label {
        color: orange;
    }
    
    th {
        min-width: 200px;
    }
    
    .comentario {
        width: 100%;
        color: black;
        background-color: #E6E6E6;
        border: hidden;
        font-size: 110%;
        padding: 20px;
    }
    
    .bot {
        width: 20%;
        display: inline-block;
        vertical-align: top;
        background-color: #5C7AEA;
        color: #fff;
        font-weight: 700;
    }
    
    .titulo {
        /*margin: 25% auto;*/
        font-size: 200%;
        text-transform: uppercase;
        text-align: left;
        font: bold;
        font-family: Arial;
        font-weight: 700;
        color: #444444;
    }
    
    body {
        background-image: url('./src/sol.png');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: top right;
        
    }
    
    table {
        background-color: #fff;
    }
    .ref{
        min-height:86.8vh;
    }
</style>

</html>



