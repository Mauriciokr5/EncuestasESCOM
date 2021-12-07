<?php
session_start();
require 'database.php';

if(empty($_SESSION['user'])){
    header('Location: inicioSesionAdmin.php');
}

$sqlAlumnosInscritos = "SELECT COUNT(*) FROM alumnos;";
$resAlumnosInscritos = mysqli_query($conexion, $sqlAlumnosInscritos);
$datosAlumnosInscritos = mysqli_fetch_row($resAlumnosInscritos);


$sqlEncuestasContestadas = "SELECT count(DISTINCT boleta) 
FROM materiaGrupo mg 
inner join materiaAlumno ma on ma.idMateriaGrupo = mg.idMateriaGrupo
inner join respuestas r on r.idMateriaAlumno = ma.idMateriaAlumno;";
$resEncuestasContestadas = mysqli_query($conexion, $sqlEncuestasContestadas);
$datosEncuestasContestadas = mysqli_fetch_row($resEncuestasContestadas);

$EncuestasNoContestadas = $datosAlumnosInscritos[0]-$datosEncuestasContestadas[0];


$sqlPromedioPregunta = "SELECT AVG(q1),AVG(q2),AVG(q3),AVG(q4),AVG(q5) FROM respuestas;";
$resPromedioPregunta = mysqli_query($conexion, $sqlPromedioPregunta);
$datosPromedioPregunta = mysqli_fetch_row($resPromedioPregunta);

$sqlComentarios = "SELECT * FROM comentarios;";
$resComentarios = mysqli_query($conexion, $sqlComentarios);





?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv=refresh content=2>-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/navbar_css.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <title>Vista General</title>
</head>

<body>
    <header>
        <div class="container">
            <h1 class="logo">Encuestas ESCOM</h1>

            <nav>
                <ul>
                    <li><a href="vistaGeneral.php">Vista General</a></li>
                    <li><a href="tablaMaterias.php">Materias</a></li>
                    <li><a href="logOutAdmin.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="row ">
            <div class="col-lg-6 col-12 espacio-div" style="display: inline-table;">
                <div style="display: table-cell; vertical-align: middle;">
                    <table class="table espacio-tabla">
                        <tbody>
                            <tr>
                                <th scope="row">CANTIDAD TOTAL DE ENCUESTAS CONTESTADAS</th>
                                <td><?php echo $datosEncuestasContestadas[0];?></td>
                            </tr>
                            <tr>
                                <th scope="row">CANTIDAD TOTAL DE ALUMNOS INSCRITOS</th>
                                <td><?php echo $datosAlumnosInscritos[0];?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 col-12 espacio-div">
                <canvas id="donaEncCont"></canvas>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-7 col-12 espacio-div">
                <canvas id="barraPromMat"></canvas>
            </div>
            <div class="col-lg-5 col-12 espacio-div" style="display: inline-table;">
                <div style="display: table-cell; vertical-align: middle;">
                    <table class="table espacio-tabla">
                        <tbody>
                            <tr>
                                <th scope="row">Te gusta el chocolate?</th>
                                <td><?php echo $datosPromedioPregunta[0];?></td>
                            </tr>
                            <tr>
                                <th scope="row">Las saladitas son horneadas</th>
                                <td><?php echo $datosPromedioPregunta[1];?></td>
                            </tr>
                            <tr>
                                <th scope="row">Y esto que es?</th>
                                <td><?php echo $datosPromedioPregunta[2];?></td>
                            </tr>
                            <tr>
                                <th scope="row">Esta mamalona la grafica</th>
                                <td><?php echo $datosPromedioPregunta[3];?></td>
                            </tr>
                            <tr>
                                <th scope="row">A poco no raza?</th>
                                <td><?php echo $datosPromedioPregunta[4];?></td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="espacio-div">
            <h1>Comentarios</h1><br>
            <table class="table espacio-tabla">
                <tbody>
                    <?php
                        while ($Comentario = mysqli_fetch_array($resComentarios, MYSQLI_ASSOC)) {
                            echo "<tr>";
                            echo "<td scope=\"row\">".$Comentario['comentario']."</td>";
                            echo "</tr>";
                        }
                        mysqli_close($conexion);                
                        
                    ?>
                </tbody>
            </table>
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
<script>
    const donaEncContData = {
        labels: ['Contestadas', 'No contestadas'],
        datasets: [{
            label: 'Encuestas Contestadas',
            data: [<?php echo $datosEncuestasContestadas[0].",".$EncuestasNoContestadas;?>],
            backgroundColor: ['rgb(92, 122, 234)', 'rgb(255, 99, 132)'],
        }]
    };
    const donaEncContConfig = {
        type: 'doughnut',
        data: donaEncContData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Encuestas Contestadas'
                }
            }
        },
    };
    const donaEncCont = new Chart(
        document.getElementById('donaEncCont'),
        donaEncContConfig
    );
</script>
<script>
    const DATA_COUNT = 7;
    const NUMBER_CFG = {
        count: DATA_COUNT,
        min: -100,
        max: 100
    };

    const barraPromMatData = {
        labels: ['Te gusta el chocolate?', 'Las saladitas son horneadas', 'Y esto que es?', 'Esta mamalona la grafica', 'A poco no raza?'],
        datasets: [{
            label: 'Promedio',
            data: [<?php echo $datosPromedioPregunta[0].",".$datosPromedioPregunta[1].",".$datosPromedioPregunta[2].",".$datosPromedioPregunta[3].",".$datosPromedioPregunta[4].",";?>],
            borderColor: ['rgb(92, 122, 234)', 'rgb(255, 99, 132)'],
            backgroundColor: ['rgb(92, 122, 234)', 'rgb(255, 99, 132)'],
        }]
    };
    const barraPromMatConfig = {
        type: 'bar',
        data: barraPromMatData,
        options: {
            indexAxis: 'y',
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Promedio de cada pregunta'
                }
            }
        },
    };
    const barraPromMat = new Chart(
        document.getElementById('barraPromMat'),
        barraPromMatConfig
    );
</script>


<style>
    .espacio-tabla th {
        padding: 20px;
    }
    
    .espacio-tabla td {
        padding: 20px;
    }
    
    .espacio-div {
        margin: 50px auto 100px auto;
    }
</style>

</html>