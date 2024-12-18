<html lang="es"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            border-radius: 8px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 10px;
        }

        .header {
            text-align: center;
            background-color: #305496;
            color: white;
            min-width: max-content;

        }

        .head_abiertas{
            background-color: #08cc04;
            text-align: center;
            color: white;
            max-height: fit-content;

        }

        .head_cerradas{
            background-color: #888484;
            text-align: center;
            color: white;
            max-height: fit-content;
        }
        /* ------------------------------------------------------ */
        .bdt_abiertas_totales table {
            width: 100%;
        }

        .bdt_abiertas_totales .subtitulos{
            text-align: justify;
            background-color: #a0fc9c;
            font-weight: bold;
        }

        .bdt_abiertas_totales .contenido{
            text-align: center;
            background-color: #ccfccc;

        }

        /* ------------------------------------------------------ */
        .bdt_abiertas_internas table {
            width: 100%;
        }

        .bdt_abiertas_internas .subtitulos{
            text-align: justify;
            background-color: #a0fc9c;
            font-weight: bold;
        }

        .bdt_abiertas_internas .contenido{
            text-align: center;
            background-color: #ccfccc;

        }

        /* ------------------------------------------------------ */
        .bdt_cerradas table {
            width: 100%;

        }

        .bdt_cerradas .subtitulos{
            text-align: justify;
            background-color: #d8dcec;
            font-weight: bold;
        }

        .bdt_cerradas .contenido{
            text-align: center;
            background-color: #ececf4;

        }

        /* ------------------------------------------------------ */
        .solicitudes table {
            width: 100%;
        }

        .solicitudes .head{
            text-align: center;
            background-color: #595959;
            color: white;
            font-weight: bold;
        }

        .solicitudes .subtitulos{
            text-align: center;
            background-color: #d0cece;
            font-weight: bold;
        }

        .solicitudes .contenido{
            text-align: center;
            background-color: #f2f2f2;

        }
    </style>
</head>
<body>

    <div class="container">

        <div class="header">
            <h1>Estatus Bibliotecas Digitales Telmex</h1>
            {{-- <h1>{{ $data['hola'] }}</h1> --}}
            <h2>Agosto 2024</h2>
        </div>

        <table style="width: 100%;">
            <thead>

                <tr>
                    <th class="head_abiertas" colspan="2">
                        103 ABIERTAS
                    </th>

                    <th class="head_cerradas" colspan="1">
                        8 CERRADAS (INTERNAS)
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="bdt_abiertas_totales">

                        <table>
                            <tbody>
                                <tr>
                                    <td class="subtitulos" style="text-align: center;" colspan="50%">103 Totales (externas e internas)</td>
                                    <td class="subtitulos" style="text-align: center;" colspan="50%">Cerradas del mes: 5</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%"><b>•100</b> externas (55 en escuelas)</td>
                                    <td class="contenido" colspan="50%" rowspan="2">Por falta de equipos y baja de Infinitum</td>
                                </tr>
                                <tr>
                                    <td class="contenido" colspan="50%"><b>•3</b> internas (Casas TELMEX)</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos"colspan="100%" >1. Internet (promedio 2,67.51GB, 49 > a 110 GB)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%">
                                        <b>88</b> BDT con <b>98</b> líneas<br>
                                        (paga la entidad)
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>15</b> BDT con <b>26</b> líneas y <b>2</b> enlaces <br>
                                        (paga Telmex)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="contenido" colspan="50%">
                                        $55512.55
                                    </td>

                                    <td class="contenido" colspan="50%">
                                        $230782.66
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="50%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="contenido">Sin consumo</td>
                                                    <td class="contenido">Bajo</td>
                                                </tr>

                                                <tr>
                                                    <td class="contenido">2</td>
                                                    <td class="contenido">52</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                    <td colspan="50%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="contenido">Medio</td>
                                                    <td class="contenido">Alto</td>
                                                    <td class="contenido">Heavy</td>
                                                    <td class="contenido">Atipico</td>
                                                </tr>

                                                <tr>
                                                    <td class="contenido">28</td>
                                                    <td class="contenido">9</td>
                                                    <td class="contenido">12</td>
                                                    <td class="contenido">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">2. Equipamiento (PC, Laptop, Netbook, Classmate & XO)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Total del proyecto</td>
                                    <td class="contenido" colspan="33%">Abiertas Inicial</td>
                                    <td class="contenido" colspan="33%">Abiertas Funcional</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">23,567</td>
                                    <td class="contenido" colspan="33%">2,907</td>
                                    <td class="contenido" colspan="33%">1,805</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">3. Mobiliario BDT externas (sillas, mesas y libreros) </td>
                                </tr>

                                <tr>
                                    <td class="contenido" rowspan="2" colspan="50%">Total del proyecto</td>
                                    <td class="contenido" colspan="50%">BDT Abiertas</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">Inicial</td>
                                    <td class="contenido" colspan="25%">Funcional</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%">21,135</td>
                                    <td class="contenido" colspan="25%">4,107</td>
                                    <td class="contenido" colspan="25%">3,940</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">4. Estatus convenio</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Indeterminado</td>
                                    <td class="contenido" colspan="33%">Vencido</td>
                                    <td class="contenido" colspan="33%">Vigente</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">99</td>
                                    <td class="contenido" colspan="33%">3</td>
                                    <td class="contenido" colspan="33%">1</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">5. Usuarios BDTs y Plataforma (acumulado 2024)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">BDTs(33)</td>
                                    <td class="contenido" colspan="25%">Registros</td>
                                    <td class="contenido" colspan="25%">Inscritos</td>
                                    <td class="contenido" colspan="25%">Constancias</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">8,732</td>
                                    <td class="contenido" colspan="25%">17,340</td>
                                    <td class="contenido" colspan="25%">24,587</td>
                                    <td class="contenido" colspan="25%">11,279</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">6. Oferta educativa</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">Nuevos</td>
                                    <td class="contenido" colspan="25%">Talleres</td>
                                    <td class="contenido" colspan="25%">En Linea</td>
                                    <td class="contenido" colspan="25%">En Desarrollo</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">7</td>
                                    <td class="contenido" colspan="25%">396</td>
                                    <td class="contenido" colspan="25%">340</td>
                                    <td class="contenido" colspan="25%">171</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">7. Nuevas solicitudes 2024 ( 10 recibidas )</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%" style="text-align: justify;">
                                        Solicitud de BDT o donación equipos
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>7</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%" style="text-align: justify;">
                                        Solicitud de reequipamiento
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>0</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%" style="text-align: justify;">
                                        Retiro de equipos
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>4</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%" style="text-align: justify;">
                                        Otros (visitas a museo, acuario, etc.)
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>3</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">8. BDT Cerradas</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%" style="text-align: justify;">
                                        Equipos dañados u obsoletos y cancelación de internet por parte de la entidad.
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>5</b>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </td>

                    <td class="bdt_abiertas_internas">

                        <table>
                            <tbody>
                                <tr>
                                    <td class="subtitulos" colspan="100%" style="text-align: center;">3 Internas</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="100%"><b>•1</b> con personal interno (Aldea Digital Iztapalapa)</td>
                                </tr>
                                <tr>
                                    <td class="contenido" colspan="100%"><b>•2</b> con personal externo (CT SEDENA y CT SEMAR)</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">1. Internet (uso promedio 796.26 GB,  3 > a 110 GB)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%">
                                        <b>2</b>CT con <b>13</b> infinitum y  <b>9</b> de voz<br>
                                        (paga Telmex)
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>1</b> CT con <b>1</b> enlace <br>
                                        (paga Telmex)
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%">
                                        $9823
                                    </td>

                                    <td class="contenido" colspan="50%">
                                        $41190.00
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="50%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="contenido">Sin consumo</td>
                                                    <td class="contenido">Bajo</td>
                                                </tr>

                                                <tr>
                                                    <td class="contenido">-</td>
                                                    <td class="contenido">-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                    <td colspan="50%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="contenido">Medio</td>
                                                    <td class="contenido">Alto</td>
                                                    <td class="contenido">Heavy</td>
                                                </tr>

                                                <tr>
                                                    <td class="contenido">-</td>
                                                    <td class="contenido">2</td>
                                                    <td class="contenido">1</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">2. Equipamiento (PC, Laptop, Netbook, Classmate & XO)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Total del proyecto</td>
                                    <td class="contenido" colspan="33%">Funcional</td>
                                    <td class="contenido" colspan="33%">Baja, Dañado, Obsoleto o Faltante</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">393</td>
                                    <td class="contenido" colspan="33%">313</td>
                                    <td class="contenido" colspan="33%">80</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">3. Mobiliario y gadgets</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">Mesas</td>
                                    <td class="contenido" colspan="25%">Sillas, bancos y puff</td>
                                    <td class="contenido" colspan="25%">Libreros</td>
                                    <td class="contenido" colspan="25%">Tv</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">239</td>
                                    <td class="contenido" colspan="25%">647</td>
                                    <td class="contenido" colspan="25%">9</td>
                                    <td class="contenido" colspan="25%">32</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Archiveros y lockers</td>
                                    <td class="contenido" colspan="33%">Racks</td>
                                    <td class="contenido" colspan="33%">Carrito cargador</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">11</td>
                                    <td class="contenido" colspan="33%">24</td>
                                    <td class="contenido" colspan="33%">8</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">4. Estatus convenio</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Indeterminado</td>
                                    <td class="contenido" colspan="33%">Vencido</td>
                                    <td class="contenido" colspan="33%">Vigente</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">2</td>
                                    <td class="contenido" colspan="33%">-</td>
                                    <td class="contenido" colspan="33%">
                                        1
                                        (Iztapalapa 4/oct/2046)</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">5. Usuarios (acumulado 2024) 177,768</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">CT Abiertas</td>
                                    <td class="contenido" colspan="25%">Meta</td>
                                    <td class="contenido" colspan="25%">Real</td>
                                    <td class="contenido" colspan="25%">%</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%" style="text-align: justify;">Aldea Digital Iztapalapa</td>
                                    <td class="contenido" colspan="25%" >80,784</td>
                                    <td class="contenido" colspan="25%" >55,215</td>
                                    <td class="contenido" colspan="25%" >68%</td>

                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%" style="text-align: justify;">CT SEDENA</td>
                                    <td class="contenido" colspan="25%" >87,168</td>
                                    <td class="contenido" colspan="25%" >74,401</td>
                                    <td class="contenido" colspan="25%" >85%</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%" style="text-align: justify;">CT SEMAR</td>
                                    <td class="contenido" colspan="25%" >59,500</td>
                                    <td class="contenido" colspan="25%" >48,152</td>
                                    <td class="contenido" colspan="25%" >81%</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">6. Gasto mensual $190,530/ Acumulado 2024 $524,891.62</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">Renta</td>
                                    <td class="contenido" colspan="25%">Aseo</td>
                                    <td class="contenido" colspan="25%">Luz</td>
                                    <td class="contenido" colspan="25%">Vigilancia</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">-</td>
                                    <td class="contenido" colspan="25%">-</td>
                                    <td class="contenido" colspan="25%">-</td>
                                    <td class="contenido" colspan="25%">-</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Agua potable</td>
                                    <td class="contenido" colspan="33%">Nómina operación</td>
                                    <td class="contenido" colspan="33%">Nómina Gcia.</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">-</td>
                                    <td class="contenido" colspan="33%">$103,090.72</td>
                                    <td class="contenido" colspan="33%">$87,438.81</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="25%" rowspan="3">Mantenimientos Total:</td>
                                    <td class="contenido" colspan="25%">$37,593</td>
                                    <td class="subtitulos" colspan="25%">Ejercido</td>
                                    <td class="contenido" colspan="25%">$0</td>
                                </tr>


                            </tbody>
                        </table>

                    </td>

                    <td class="bdt_cerradas">

                        <table>
                            <tbody>
                                <tr>
                                    <td class="subtitulos" colspan="100%" style="text-align: center;">3 Internas</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="100%"><b>•1</b> con personal interno (Aldea Digital Iztapalapa)</td>
                                </tr>
                                <tr>
                                    <td class="contenido" colspan="100%"><b>•2</b> con personal externo (CT SEDENA y CT SEMAR)</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">1. Internet (uso promedio 796.26 GB,  3 > a 110 GB)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%">
                                        <b>2</b>CT con <b>13</b> infinitum y  <b>9</b> de voz<br>
                                        (paga Telmex)
                                    </td>
                                    <td class="contenido" colspan="50%">
                                        <b>1</b> CT con <b>1</b> enlace <br>
                                        (paga Telmex)
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="50%">
                                        $9823
                                    </td>

                                    <td class="contenido" colspan="50%">
                                        $41190.00
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="50%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="contenido">Sin consumo</td>
                                                    <td class="contenido">Bajo</td>
                                                </tr>

                                                <tr>
                                                    <td class="contenido">-</td>
                                                    <td class="contenido">-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                    <td colspan="50%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="contenido">Medio</td>
                                                    <td class="contenido">Alto</td>
                                                    <td class="contenido">Heavy</td>
                                                </tr>

                                                <tr>
                                                    <td class="contenido">-</td>
                                                    <td class="contenido">2</td>
                                                    <td class="contenido">1</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">2. Equipamiento (PC, Laptop, Netbook, Classmate & XO)</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Total del proyecto</td>
                                    <td class="contenido" colspan="33%">Funcional</td>
                                    <td class="contenido" colspan="33%">Baja, Dañado, Obsoleto o Faltante</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">393</td>
                                    <td class="contenido" colspan="33%">313</td>
                                    <td class="contenido" colspan="33%">80</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">3. Mobiliario y gadgets</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">Mesas</td>
                                    <td class="contenido" colspan="25%">Sillas, bancos y puff</td>
                                    <td class="contenido" colspan="25%">Libreros</td>
                                    <td class="contenido" colspan="25%">Tv</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">239</td>
                                    <td class="contenido" colspan="25%">647</td>
                                    <td class="contenido" colspan="25%">9</td>
                                    <td class="contenido" colspan="25%">32</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Archiveros y lockers</td>
                                    <td class="contenido" colspan="33%">Racks</td>
                                    <td class="contenido" colspan="33%">Carrito cargador</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">11</td>
                                    <td class="contenido" colspan="33%">24</td>
                                    <td class="contenido" colspan="33%">8</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">4. Estatus convenio</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Indeterminado</td>
                                    <td class="contenido" colspan="33%">Vencido</td>
                                    <td class="contenido" colspan="33%">Vigente</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">2</td>
                                    <td class="contenido" colspan="33%">-</td>
                                    <td class="contenido" colspan="33%">
                                        1
                                        (Iztapalapa 4/oct/2046)</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">5. Usuarios (acumulado 2024) 177,768</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">CT Abiertas</td>
                                    <td class="contenido" colspan="25%">Meta</td>
                                    <td class="contenido" colspan="25%">Real</td>
                                    <td class="contenido" colspan="25%">%</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%" style="text-align: justify;">Aldea Digital Iztapalapa</td>
                                    <td class="contenido" colspan="25%" >80,784</td>
                                    <td class="contenido" colspan="25%" >55,215</td>
                                    <td class="contenido" colspan="25%" >68%</td>

                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%" style="text-align: justify;">CT SEDENA</td>
                                    <td class="contenido" colspan="25%" >87,168</td>
                                    <td class="contenido" colspan="25%" >74,401</td>
                                    <td class="contenido" colspan="25%" >85%</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%" style="text-align: justify;">CT SEMAR</td>
                                    <td class="contenido" colspan="25%" >59,500</td>
                                    <td class="contenido" colspan="25%" >48,152</td>
                                    <td class="contenido" colspan="25%" >81%</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="100%">6. Gasto mensual $190,530/ Acumulado 2024 $524,891.62</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">Renta</td>
                                    <td class="contenido" colspan="25%">Aseo</td>
                                    <td class="contenido" colspan="25%">Luz</td>
                                    <td class="contenido" colspan="25%">Vigilancia</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="25%">-</td>
                                    <td class="contenido" colspan="25%">-</td>
                                    <td class="contenido" colspan="25%">-</td>
                                    <td class="contenido" colspan="25%">-</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">Agua potable</td>
                                    <td class="contenido" colspan="33%">Nómina operación</td>
                                    <td class="contenido" colspan="33%">Nómina Gcia.</td>
                                </tr>

                                <tr>
                                    <td class="contenido" colspan="33%">-</td>
                                    <td class="contenido" colspan="33%">$103,090.72</td>
                                    <td class="contenido" colspan="33%">$87,438.81</td>
                                </tr>

                                <tr>
                                    <td class="subtitulos" colspan="25%" rowspan="3">Mantenimientos Total:</td>
                                    <td class="contenido" colspan="25%">$37,593</td>
                                    <td class="subtitulos" colspan="25%">Ejercido</td>
                                    <td class="contenido" colspan="25%">$0</td>
                                </tr>


                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>


            <tfoot class="solicitudes">
                <tr>
                    <td colspan="3">
                        <table>
                            <thead>
                                <tr>
                                    <th class="head" colspan="3">Solicitudes relevantes del mes: </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="subtitulos">Entidad:</td>
                                    <td class="subtitulos">Solicitante:</td>
                                    <td class="subtitulos">Apoyo requerido:</td>
                                </tr>

                                <tr>
                                    <td class="contenido">-</td>
                                    <td class="contenido">-</td>
                                    <td class="contenido">-</td>
                                </tr>

                                <tr>
                                    <td class="contenido">-</td>
                                    <td class="contenido">-</td>
                                    <td class="contenido">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
