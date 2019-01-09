<h2>Registro de Respaldo</h2>

<form action='control/usuario_controller.php' method='post'>
    <input type='hidden' name='action' value='register'>
    <table>
        <tr>
            <td><label>Nro. Preventivo:</label></td><td><input type='number' name='nroPreventivo' placeholder="1"></td>
        </tr>
        <tr>
            <td><label>Nro. Compromiso: </label></td><td><input type='number' name='nroCompromiso' placeholder="0"></td>
        </tr>
        <tr>
            <td><label>Nro. Devengado:</label></td><td><input type='number' name='nroDevengado' placeholder="0"></td>
        </tr>
        <tr>
            <td><label>Nro. Pago:</label></td><td><input type='number' name='nroPago' value="0"></td>
        </tr>
        <tr>
            <td><label>Nro. Secuencia: </label></td><td><input type='number' name='nroSecuencia' value="0"></td>
        </tr>
        <tr>
            <td><label>Tipo de Doc. Respaldo:</label></td><td><input type='number' name='tipoDocRdo' value="4"></td>
        </tr>
        <tr>
            <td><label>Nro. de Doc. Respaldo:</label></td><td><input type='number' name='nroDocRdo' placeholder="10962"></td>
        </tr>
        <tr>
            <td><label>Secuencia Facturas y Planillas:</label></td><td><input type='number' name='secDocRdo' value="1"></td>
        </tr>
        <tr>
            <td><label>Total del Doc. Respaldo: </label></td><td><input type='number' name='totalDocRdo' value="1"></td>
        </tr>
        <tr>
            <td><label>Fecha Elaboracion de Respaldo:</label></td><td><input type='date' name='fechaElaboracionRdo' "></td>
        </tr>
        <tr>
            <td><label>Fecha Recepcion de Respaldo:</label></td><td><input type='date' name='fechaRecepcionRdo' value="0"></td>
        </tr>
        <tr>
            <td><label>Fecha Vencimiento de Respaldo:</label></td><td><input type='date' name='fechaVencimientoRdo' disabled="0"></td>
        </tr>
    </table>

    <input type='submit' value='Enviar'>
</form>