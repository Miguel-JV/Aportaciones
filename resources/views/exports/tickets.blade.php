
<table >
    <thead>
        <tr >
            <th width="25" style="color: #ffffff; background-color: #000000; border: 20px solid #000;" valign='middle '  align='center' bgcolor='black'>
                <b>1. Folio</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>2. Fecha</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>3. Status</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>4. Casa</b>
            </th>
            <th width="30" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>5. Director</b>
            </th>
            <th width="30" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>6. Afecta</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>7. Área Responsable</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>8. Prioridad</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>9. Reincidencia</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>10. Entorno</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>11. Sitio</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>12. Objeto</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>13. Elemento</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>14. Daño</b>
            </th>
            <th width="100" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>15.Liga de Fotos</b>
            </th>
            <th width="100" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='black'>
                <b>16. Descripcion Detallada</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='orange'>
                <b>17. Fecha de Terminación</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='orange'>
                <b>18. Area que Atendió</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='orange'>
                <b>19. Personal que Atendió</b>
            </th>
            <th width="25" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='orange'>
                <b>20. Estatus Actual</b>
            </th>
            <th width="100" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='orange'>
                <b>21. Observacciones  Complementarias</b>
            </th>
            <th width="100" style="color: #ffffff; background-color: #000000; border: 1px solid #000;" valign='middle ' align='center' bgcolor='orange'>
                <b>22. Link imagen Evidencia</b>
            </th>
        </tr>

    </thead>
    <tbody>
        @foreach ($tickets as $ticket)
            <tr>
                <td>
                    {{ $ticket->FOLIO}}
                </td>
                <td align='center'>
                    {{ $ticket->FECHA_INICIO}}
                </td>
                <td align='center'>
                    {{ $ticket->ESTATUS_INICIAL}}
                </td>
                <td align='center'>
                    {{ $ticket->CASA}}
                </td>
                <td align='center'>
                    {{ $ticket->DIRECTOR}}
                </td>
                <td align='center'>
                    {{ $ticket->AFECCION}}
                </td>
                <td align='center'>
                    {{ $ticket->AREA_RESPONSABLE}}
                </td>
                <td align='center'>
                    {{ $ticket->PRIORIDAD}}
                </td>
                <td align='center'>
                    {{ $ticket->REINCIDENCIA}}
                </td>
                <td align='center'>
                    {{ $ticket->ENTORNO}}
                </td>
                <td >
                    {{ $ticket->SITIO}}
                </td>
                <td>
                    {{ $ticket->OBJETO}}
                </td>
                <td>
                    {{ $ticket->ELEMENTO}}
                </td>
                <td>
                    {{ $ticket->DAÑO}}
                </td>
                <td>
                    {{ $ticket->DRIVE}}
                </td>
                <td>
                    {{ $ticket->DETALLE}}
                </td>
                <td>
                    {{ $ticket->FECHA_FIN}}
                </td>
                <td>
                    {{ $ticket->AREA_ATENCION}}
                </td>
                <td>
                    {{ $ticket->PERSONA_ATENCION}}
                </td>
                <td>
                    {{ $ticket->ESTATUS_ACTUAL}}
                </td>
                <td>
                    {{ $ticket->OBSERVACIONES}}
                </td>
                <td>
                    {{ $ticket->EVIDENCIA}}
                </td>
            </tr>

        @endforeach
    </tbody>
</table>
