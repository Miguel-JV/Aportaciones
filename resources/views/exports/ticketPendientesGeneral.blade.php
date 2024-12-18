<table>
    <thead>
        <tr>

            <th colspan="3" style=" color: #000000; background-color: #76b5c5;" valign='middle' align='center' bgcolor='#76b5c5'>
                PENDIENTE A REALIZAR
            </th>

        </tr>
    </thead>

    <tbody>

        <tr>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                SITIO
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                CANTIDAD
            </td>
            <td width="15" valign='middle' align='center' bgcolor='#ffffff' style= "background-color: #ffffff;">
                MONTO<br>
                TOTAL
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
                ${{ $pendientes_data['aldea']['montoTotal'] }}
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
                ${{ $pendientes_data['sedena']['montoTotal'] }}
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
                ${{ $pendientes_data['semar']['montoTotal'] }}
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
                ${{ $pendientes_data['campeche']['montoTotal'] }}
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
                ${{ $pendientes_data['cuautla']['montoTotal'] }}
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
                ${{ $pendientes_data['culiacan']['montoTotal'] }}
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
                ${{ $pendientes_data['saltillo']['montoTotal'] }}
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
                ${{ $pendientes_data['tapachula']['montoTotal'] }}
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
                ${{ $pendientes_data['tuxtla']['montoTotal'] }}
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
                ${{ $pendientes_data['veracruz']['montoTotal'] }}
            </td>
        </tr>

        {{-- TOTALES --}}
        <tr>
            {{-- PENDIENTES --}}
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                TOTAL
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                {{ $totales_data['cantidad'] }}
            </td>
            <td  valign='middle' style="border-bottom: solid; background-color: #bdf7af;"  align='center' >
                ${{ $totales_data['montoTotal'] }}
            </td>
        </tr>

    </tbody>
</table>
