
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Cotizado</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #7b1fa2;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px;
            text-align: justify;
        }
        .content h1 {
            color: #7b1fa2;
            font-size: 24px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #666666;
        }

        .evidencia {
            padding: 20px;
            text-align: center;
        }

        .evidencia img {
            max-width: 150px;
            height: 100px;
            border-radius: 3%;
        }

        .footer {
            background-color: #e0e0e0;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }

        /* Boton de Validación */
        button {
            border: 1px solid #7b1fa2;
            background-color: #7b1fa2;
            border-radius: 0.7em;
            cursor: pointer;
            padding: 0.5em 1em 0.6em 0.8em;
            font-size: 10px;
        }

        button span {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: 500;
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://bibliotecadigital.telmex.com/bibliotecaDigital/resources/img/LOGO_BDT_Flag.png" alt="Telmex">
        </div>
        <div class="content">
            @if ($data['ticket']->ESTATUS_COTIZACION == 'SI')
                <h1>Informe de Nueva Cotizacion Ticket <br>
                    {{ $data['folio'] }} <br>
                    {{ $data['casa'] }} -  {{ $data['area'] }}
                </h1>
            @else
                <h1>Informe de Nueva Fecha Compromiso Ticket <br>
                    {{ $data['folio'] }} <br>
                    {{ $data['casa'] }} -  {{ $data['area'] }}
                </h1>
            @endif

            @if (@empty($data['destinatario']))
            @else
                <p>Estimado/a {{ $data['destinatario'] }},</p>
            @endif
            <p>
                A continuación, se detalla los datos del reporte de daño.
            </p>
            <p>
                Detalle del ticket:
            </p>
            <!-- Tabla de cambios realizados -->
            <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Detalle</th>
                        <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Descripción</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Fecha de Expedición</td>
                        <td style="text-align: justify;"> {{ $data['fecha_inicio'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Estatus</td>
                        <td style="text-align: justify;">{{ $data['estatus'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Afeccion</td>
                        <td style="text-align: justify;">{{ $data['afeccion'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Reinicidencia</td>
                        <td style="text-align: justify;">{{ $data['reinicidencia'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Entorno</td>
                        <td style="text-align: justify;">{{ $data['entorno'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Sitio</td>
                        <td style="text-align: justify;">{{ $data['sitio'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Espacio</td>
                        <td style="text-align: justify;">{{ $data['espacio'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Objeto - Elemento</td>
                        <td style="text-align: justify;">{{ $data['objeto'] }} - {{ $data['elemento'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Daño</td>
                        <td style="text-align: justify;">{{ $data['daño'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Prioridad</td>
                        <td style="text-align: justify;">{{ $data['prioridad'] }}</td>

                    </tr>
                    <tr>

                        <td style="text-align: center; font-weight: bold;">Detalle</td>
                        <td style="text-align: justify;">{{ $data['detalle'] }}</td>

                    </tr>
                </tbody>
            </table>
            <br>

            <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        @if ($data['ticket']->ESTATUS_COTIZACION == 'NO')
                            <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Fecha Compromiso</th>
                        @else
                            <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Fecha Compromiso</th>
                            <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Monto Cotizado</th>
                        @endif


                    </tr>
                </thead>

                <tbody>
                    <tr>
                        @if ($data['ticket']->ESTATUS_COTIZACION == 'NO')
                            <td style="text-align: center;" class="evidencia">
                                {{ $data['fecha_compromiso'] }}
                            </td>

                        @else
                            <td style="text-align: center;" class="evidencia">
                                {{ $data['fecha_compromiso'] }}
                            </td>

                            <td style="text-align: center;" class="evidencia">
                                ${{ $data['monto'] }}MXN
                            </td>
                        @endif


                    </tr>
                </tbody>
            </table><br>

            @if (!empty($data['fotos']))
                <h1>Evidencias</h1>
                <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Foto Evidencia Obligatotia</th>
                            <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Foto Evidencia Extra</th>
                            <th style="background-color: #7b1fa2; color: #ffffff; text-align: center;">Foto Evidencia Extra</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            @foreach ($data['fotos'] as $foto)

                                <td style="text-align: center;" class="evidencia">
                                    <img src="{{ $message->embed(public_path() . "/storage/tickets/evidencias/inicio/" . $foto )}}" alt="Imagen No Encontrada" class="img-fluid img-thumbnail">
                                </td>

                            @endforeach
                        </tr>
                    </tbody>
                </table><br>
            @else

            @endif

            

            @if ($data['coordinador_bdt'])
                <a href="{{ route('autorizar.ticket', [
                        'ticket'    =>  $data['ticket'],
                        'encargado' =>  $data['encript']
                    ])
                }}">
                    <button>
                        <span>
                            Autorizar
                        </span>
                    </button>
                </a>
            @else

            @endif






            <p>
                Si tiene alguna pregunta o necesita más detalles sobre estos cambios, no dude en ponerse en contacto con nosotros. Agradecemos su colaboración continua para mejorar las condiciones de la casa.
            </p>
            <p>
                <h2 style="margin: 0;">Biblioteca Digital Telmex.</h2>

                <div class="MsoNormal" style="margin: 0cm 0.4pt 0cm 0cm; text-align: justify; border: none;"><strong style="mso-bidi-font-weight: normal;"><span style="color: black;">Director(a): </span></strong><span style="color: black;">: </span><strong style="mso-bidi-font-weight: normal;"><span style="color: rgb(0, 144, 204);">{{ $data['director'] }}</span></strong></div>
                {{-- <div class="MsoNormal" style="margin: 0cm 0.4pt 0cm 0cm; text-align: justify; border: none;"><strong style="mso-bidi-font-weight: normal;"><span style="color: rgb(0, 144, 204);"><span style="color: black;">Tutor</span><span style="color: black;">: <span style="color: rgb(0, 144, 204);">777 458 32 23</span></span></span></strong></div> --}}
                {{-- <div class="MsoNormal" style="margin: 0cm 0.4pt 0cm 0cm; text-align: justify;"><span style="color: black;">Opiniones y sugerencias:</span><strong style="mso-bidi-font-weight: normal;"><span style="color: rgb(0, 144, 204);"> 800 122 12 12 Opción 2</span></strong></div> --}}
                <div class="MsoNormal" style="margin: 0cm 0.4pt 0cm 0cm; text-align: justify;"><strong style="mso-bidi-font-weight: normal;">{{ $data['casa'] }}</strong>
                    {{-- <a href="{{ $data['drive'] }}"><span style="color: rgb(5, 99, 193);">Link de carpeta de fotos.</span></a> --}}
                </div>
			</p>
        </div>
        <div class="footer">
            &copy; 2024 Telmex. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
