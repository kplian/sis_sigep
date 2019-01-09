<h2>Registro de Documento C-31</h2>

<form action='control/usuario_controller.php' method='post'>
    <input type='hidden' name='action' value='register'>
    <table>
        <tr>
            <td><label>Nro. Preventivo:</label></td><td><input type='number' name='nroPreventivo' value="1"></td>
        </tr>
        <tr>
            <td><label>Nro. Compromiso: </label></td><td><input type='number' name='nroCompromiso' value="0"></td>
        </tr>
        <tr>
            <td><label>Nro. Devengado:</label></td><td><input type='number' name='nroDevengado' value="0"></td>
        </tr>
        <tr>
            <td><label>Documento Preventivo(S/N):</label></td><td><input type='text' name='Preventivo' value="S"></td>
        </tr>
        <tr>
            <td><label>Documento Compromiso (S/N): </label></td><td><input type='text' name='Compromiso' value="N"></td>
        </tr>
        <tr>
            <td><label>Documento Devengado (S/N):</label></td><td><input type='text' name='Devengado' value="N"></td>
        </tr>
        <tr>
            <td><label>Fecha de Elaboracion:</label></td><td><input type='date' name='fechaElaboracion'></td>
        </tr>
        <tr>
            <td><label>Clase de Gasto CIP: </label></td><td><input type='number' name='ClaseGastoCip' value="4"></td>
        </tr>
        <tr>
            <td><label>Resumen de la Operacion:</label></td><td><input type='text' name='resumenOperacion' placeholder="descripcion..."></td>
        </tr>
        <tr>
            <td><label>Monto Total Autorizado(*):</label></td><td><input type='number' name='totalAutorizadoMo' value="0"></td>
        </tr>
        <tr>
            <td><label>Monto Total de Retenciones:</label></td><td><input type='number' name='totalRetencionesMo' value="0"></td>
        </tr>
        <tr>
            <td><label>Monto Total de Multas:</label></td><td><input type='number' name='totalRetencionesMo' value="0"></td>
        </tr>
        <tr>
            <td><label>Monto Liquido Pagable(*): </label></td><td><input type='number' name='liquidoPagableMo' value="0"></td>
        </tr>
    </table>

    <input type='submit' value='Enviar'>
</form>