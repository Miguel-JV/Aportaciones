<table>
    <tbody>
        {{-- PENDIENTES --}}
        <tr>
            <th colspan="7"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #76b5c5;" valign='middle' align='center' bgcolor='#76b5c5'>
                <b>PENDIENTE A REALIZAR</b>
            </th>
        </tr>

        <tr>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>SITIO</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>AREA</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>GERENTE</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>INICIO</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>COTIZACION</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>COMPROMISO</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>DETALLE</b>
            </th>
        </tr>

        @foreach ($resultado['pendientes'] as $ticket)
            <tr>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->CASA }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->AREA_RESPONSABLE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->GERENTE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_INICIO }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    ${{ $ticket->COTIZACION }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_COMPROMISO }}
                </td>
                <td  height="55" colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle'  bgcolor='#FFFFFF'>
                    {{ $ticket->DETALLE }}<br>
                </td>
            </tr>
        @endforeach

        {{-- EN PROCESO --}}
        <tr>
            <th colspan="7"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffa500;" valign='middle' align='center' bgcolor='#ffa500'>
                <b>EN PROCESO A REALIZAR</b>
            </th>
        </tr>

        <tr>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>SITIO</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>AREA</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>GERENTE</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>INICIO</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>COTIZACION</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>COMPROMISO</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>DETALLE</b>
            </th>
        </tr>

        @foreach ($resultado['procesados'] as $ticket)
            <tr>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->CASA }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->AREA_RESPONSABLE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->GERENTE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_INICIO }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    ${{ $ticket->COTIZACION }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_COMPROMISO }}
                </td>
                <td  height="55" colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle'  bgcolor='#FFFFFF'>
                    {{ $ticket->DETALLE }}<br>
                </td>
            </tr>
        @endforeach

        {{-- FINALIZADOS --}}
        <tr>
            <th colspan="7"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #28a745;" valign='middle' align='center' bgcolor='#28a745'>
                <b>FINALIZADO</b>
            </th>
        </tr>

        <tr>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>SITIO</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>AREA</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>GERENTE</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>INICIO</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>COTIZACION</b>
            </th>
            <th  width="20" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>FECHA<br>FIN</b>
            </th>
            <th  width="40" style=" border-bottom: solid; background-color: #FFFFFF;" valign='middle' align='center' bgcolor='#FFFFFF'>
                <b>DETALLE</b>
            </th>
        </tr>

        @foreach ($resultado['finalizados'] as $ticket)
            <tr>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->CASA }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->AREA_RESPONSABLE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->GERENTE }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_INICIO }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    ${{ $ticket->COTIZACION }}
                </td>
                <td colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000; background-color: #ffffff;" valign='middle' align='center' bgcolor='#FFFFFF'>
                    {{ $ticket->FECHA_FIN }}
                </td>
                <td  height="55" colspan="1"  style=" border-top: solid; border-bottom: solid; color: #000000 ; background-color: #ffffff;" valign='middle'  bgcolor='#FFFFFF'>
                    {{ $ticket->DETALLE }}<br>
                </td>
            </tr>
        @endforeach



    </tbody>
</table>
