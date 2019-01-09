<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8" />
    <title>Prueba SIGEP</title>
</head>
<br>
<h1>SIGEP Prueba de Servicios </h1>
<h2>Etapa: PREVENTIVO</h2>
<section>
    <table border ='1'>
        <tr><td><a href="vista/Egaconsulta.php">Consulta de Documento</a></td></tr>
        <tr><td><a href="vista/Egadocumentos.php">Registro Documento C31</a></td></tr>
        <tr><td><a href="vista/Egapartida.php">Estructura Programatica</a></td></tr>
        <tr><td><a href="vista/Egarespaldo.php">Registro Respaldo C31</a></td></tr>
        <tr><td><a href="vista/Egaverifica.php">Verificar</a></td></tr>
        <tr><td><a href="vista/Egaaprueba.php">Aprobar</a></td></tr>
    </table>
</section>
</br>
    <button onclick="myFunction()">Siguiente Etapa</button>

    <p>IMPORTANTE!!! Para pasar a la siguiente etapa el documento C-31 debe estar en estado APROBADO.</p>

    <script>
        function myFunction() {
            document.getElementById("field2").value = document.getElementById("field1").value;
        }
    </script>
</body>
</html>