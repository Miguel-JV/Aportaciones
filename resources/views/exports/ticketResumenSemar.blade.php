<table>
    <thead>
        <tr>

            <th colspan="1" valign='middle' align='center' bgcolor='#ffffff'></th>
            <th colspan="3" style=" color: #000000; background-color: #76b5c5;" valign='middle' align='center' bgcolor='#76b5c5'>
                PENDIENTE A REALIZAR
            </th>
            <th colspan="1" style=" color: #000000; background-color: #ffa500;" valign='middle' align='center' bgcolor='#ffa500'>
                EN PROCESO
            </th>
            <th colspan="1" style=" color: #000000; background-color: #28a745;" valign='middle' align='center' bgcolor='#28a745'>
                FINALIZADO<br>
                MES
            </th>

            <th colspan="1" height="30" style=" color: #000000; background-color: #ffffff;" valign='middle' align='center'>
                ACUMULADOS<br>
                {{ $mesAcumulado }} - {{ $mesCorte }}
            </th>

        </tr>
    </thead>

    <tbody>

        <tr>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                SITIO
            </td>
            {{-- PENDIENTES --}}
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                CANTIDAD
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                COTIZADO<br>
                SITIO
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                AUTORIZADOS<br>
                SITIO
            </td>


            {{-- EN PROCESO --}}
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                CANTIDAD
            </td>


            {{-- FINALIZADOS --}}
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                CANTIDAD
            </td>

            {{-- ACUMULADOS --}}
            <td width="30" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                ACUMULADO<br>
                HISTORICO
            </td>
        </tr>


{{-- Semar --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                Semar
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['semar']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['semar']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['semar']['autorizados'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $procesados_data['semar']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['semar']['cantidad'] }}
            </td>


            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $acumulados_data['historico']['semar'] }}
            </td>
        </tr>

{{-- TOTALES --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                TOTAL
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['pendientes']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['pendientes']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['pendientes']['autorizados'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['procesados']['cantidad'] }}
            </td>

            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['finalizados']['cantidad'] }}
            </td>


            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['acumulados']['historico'] }}
            </td>
        </tr>

    </tbody>
</table>
