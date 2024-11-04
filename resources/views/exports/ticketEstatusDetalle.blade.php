<table>
    <tbody>
        <tr>
            <th colspan="7"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#76b5c5'>
                <b>PENDIENTE A REALIZAR</b>
            </th>
        </tr>

        <tr>
            {{-- PENDIENTES --}}
            <th  width="15" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>SITIO</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>AREA</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>GERENTE</b>
            </th>
            <th  width="8" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>INICIO</b>
            </th>
            <th  width="11" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>COTIZACION</b>
            </th>
            <th  width="11" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>COMPROMISO</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>DETALLE</b>
            </th>
        </tr>

        @foreach ($resultado['pendientes'] as $ticket)
            <tr>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->CASA }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->AREA_RESPONSABLE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->GERENTE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_INICIO }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    ${{ $ticket->COTIZACION }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_COMPROMISO }}
                </td>
                <td  height="55" colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle'  bgcolor='#FFFFFF'>
                    {{ $ticket->DETALLE }}<br>
                </td>
            </tr>
        @endforeach

        {{-- EN PROCESO --}}
        <tr>
            <th colspan="7"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#ffa500'>
                <b>EN PROCESO A REALIZAR</b>
            </th>
        </tr>

        <tr>
            <th  width="15" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>SITIO</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>AREA</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>GERENTE</b>
            </th>
            <th  width="8" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>INICIO</b>
            </th>
            <th  width="11" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>COTIZACION</b>
            </th>
            <th  width="11" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>COMPROMISO</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>DETALLE</b>
            </th>
        </tr>

        @foreach ($resultado['procesados'] as $ticket)
            <tr>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->CASA }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->AREA_RESPONSABLE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->GERENTE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_INICIO }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    ${{ $ticket->COTIZACION }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_COMPROMISO }}
                </td>
                <td  height="55" colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle'  bgcolor='#FFFFFF'>
                    {{ $ticket->DETALLE }}<br>
                </td>
            </tr>
        @endforeach

        {{-- FINALIZADOS --}}
        <tr>
            <th colspan="7"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#28a745'>
                <b>FINALIZADO</b>
            </th>
        </tr>

        <tr>
            <th  width="15" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>SITIO</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>AREA</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>GERENTE</b>
            </th>
            <th  width="8" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>INICIO</b>
            </th>
            <th  width="11" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>COTIZACION</b>
            </th>
            <th  width="11" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>COMPROMISO</b>
            </th>
            <th  width="25" style=" border-bottom: solid;" valign='middle ' align='center' bgcolor='#FFFFFF'>
                <b>DETALLE</b>
            </th>
        </tr>

        @foreach ($resultado['finalizados'] as $ticket)
            <tr>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->CASA }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->AREA_RESPONSABLE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->GERENTE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_INICIO }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    ${{ $ticket->COTIZACION }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_COMPROMISO }}
                </td>
                <td  height="55" colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000" valign='middle'  bgcolor='#FFFFFF'>
                    {{ $ticket->DETALLE }}<br>
                </td>
            </tr>
        @endforeach



    </tbody>
</table>