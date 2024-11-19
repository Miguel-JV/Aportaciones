<table>
    <thead>
        <tr>

            <th colspan="1" valign='middle' align='center' bgcolor='#ffffff'></th>
            <th colspan="4" style=" color: #000000; background-color: #76b5c5;" valign='middle' align='center' bgcolor='#76b5c5'>
                PENDIENTE A REALIZAR
            </th>
            <th colspan="1" style=" color: #000000; background-color: #ffa500;" valign='middle' align='center' bgcolor='#ffa500'>
                EN PROCESO
            </th>
            <th colspan="3" style=" color: #000000; background-color: #28a745;" valign='middle' align='center' bgcolor='#28a745'>
                FINALIZADO<br>
                MES
            </th>

            <th colspan="2" height="30" style=" color: #000000; background-color: #ffffff;" valign='middle' align='center'>
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
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                MONTO<br>
                TOTAL
            </td>

            {{-- EN PROCESO --}}
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                CANTIDAD
            </td>


            {{-- FINALIZADOS --}}
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                CANTIDAD
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                PAGADOS
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                MONTO<br>
                TOTAL
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                ACUMULADO<br>
                HISTORICO
            </td>
            <td width="15"  valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                MONTO<br>
                ACUMULADO
            </td>
        </tr>

{{-- Aldea --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                Aldea
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['aldea']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['aldea']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['aldea']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $pendientes_data['aldea']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $procesados_data['aldea']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['aldea']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['aldea']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $finalizados_data['aldea']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $acumulados_data['historico']['aldea'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $acumulados_data['monto']['aldea'] }}
            </td>
        </tr>

{{-- Sedena --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                Sedena
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['sedena']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['sedena']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['sedena']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $pendientes_data['sedena']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $procesados_data['sedena']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['sedena']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['sedena']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $finalizados_data['sedena']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $acumulados_data['historico']['sedena'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $acumulados_data['monto']['sedena'] }}
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
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $pendientes_data['semar']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $procesados_data['semar']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['semar']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['semar']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $finalizados_data['semar']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $acumulados_data['historico']['semar'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $acumulados_data['monto']['semar'] }}
            </td>
        </tr>


{{-- Campeche --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                Campeche
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['campeche']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['campeche']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['campeche']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $pendientes_data['campeche']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $procesados_data['campeche']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['campeche']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['campeche']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $finalizados_data['campeche']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $acumulados_data['historico']['campeche'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $acumulados_data['monto']['campeche'] }}
            </td>
        </tr>

{{-- Cuautla --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                Cuautla
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['cuautla']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['cuautla']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['cuautla']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $pendientes_data['cuautla']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $procesados_data['cuautla']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['cuautla']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['cuautla']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $finalizados_data['cuautla']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $acumulados_data['historico']['cuautla'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $acumulados_data['monto']['cuautla'] }}
            </td>
        </tr>

{{-- Culiacán --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                Culiacán
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['culiacan']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['culiacan']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['culiacan']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $pendientes_data['culiacan']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $procesados_data['culiacan']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['culiacan']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['culiacan']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $finalizados_data['culiacan']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $acumulados_data['historico']['culiacan'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $acumulados_data['monto']['culiacan'] }}
            </td>
        </tr>

{{-- Saltillo --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                Saltillo
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['saltillo']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['saltillo']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['saltillo']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $pendientes_data['saltillo']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $procesados_data['saltillo']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['saltillo']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['saltillo']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $finalizados_data['saltillo']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $acumulados_data['historico']['saltillo'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $acumulados_data['monto']['saltillo'] }}
            </td>
        </tr>

{{-- Tapachula --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                Tapachula
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['tapachula']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['tapachula']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['tapachula']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $pendientes_data['tapachula']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $procesados_data['tapachula']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['tapachula']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['tapachula']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $finalizados_data['tapachula']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $acumulados_data['historico']['tapachula'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $acumulados_data['monto']['tapachula'] }}
            </td>
        </tr>

{{-- Tuxtla --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                Tuxtla
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['tuxtla']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['tuxtla']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $pendientes_data['tuxtla']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $pendientes_data['tuxtla']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $procesados_data['tuxtla']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['tuxtla']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $finalizados_data['tuxtla']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $finalizados_data['tuxtla']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                {{ $acumulados_data['historico']['tuxtla'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #eeeee4;"  align='center' >
                ${{ $acumulados_data['monto']['tuxtla'] }}
            </td>
        </tr>

{{-- Veracruz --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                Veracruz
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['veracruz']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['veracruz']['cotizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $pendientes_data['veracruz']['autorizados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $pendientes_data['veracruz']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $procesados_data['veracruz']['cantidad'] }}
            </td>


            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['veracruz']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $finalizados_data['veracruz']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $finalizados_data['veracruz']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                {{ $acumulados_data['historico']['veracruz'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #ffffff;"  align='center' >
                ${{ $acumulados_data['monto']['veracruz'] }}
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
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                ${{ $totales_data['pendientes']['montoTotal'] }}
            </td>

            {{-- EN PROCESO --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['procesados']['cantidad'] }}
            </td>

            {{-- FINALIZADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['finalizados']['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['finalizados']['pagados'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                ${{ $totales_data['finalizados']['montoTotal'] }}
            </td>

            {{-- ACUMULADOS --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['acumulados']['historico'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                ${{ $totales_data['acumulados']['monto'] }}
            </td>
        </tr>

    </tbody>
</table>
