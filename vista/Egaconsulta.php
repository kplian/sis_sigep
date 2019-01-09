<h2>Consulta Estado Documento C-31!</h2>

<form action='../control/ATPRconsultadoc.php' method='post'>
    <input type='hidden' name='action' value='register'>
    <table>
        <tr>
            <td><label>Nro. Preventivo:</label></td><td><input type='number' name='nroPreventivo' placeholder="1"></td>
        </tr>
        <tr>
            <td><label>Nro. Compromiso: </label></td><td><input type='number' name='nroCompromiso' placeholder="1"></td>
        </tr>
        <tr>
            <td><label>Nro. Devengado:</label></td><td><input type='number' name='nroDevengado' placeholder="1"></td>
        </tr>
        <tr>
            <td><label>Nro. Pago:</label></td><td><input type='number' name='nroPago' value="0"></td>
        </tr>
        <tr>
            <td><label>Nro. Secuencia: </label></td><td><input type='number' name='nroSecuencia' value="0"></td>
        </tr>
    </table>

    <input type='submit' value='Guardar'>
</form>