
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
            background-color: #107c41;
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
            color: #107c41;
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
            border: 1px solid #107c41;
            background-color: #107c41;
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
            <h1>Informe de Nuevo Reporte de Mantenimientos</h1>

            @if (@empty($data['destinatario']))
            @else
                <p>Estimado/a {{ $data['destinatario'] }},</p>
            @endif
            <p>
                A continuación, se adjuntan los resumenes de los reportes de daño.
            </p>

            <p>
                <h2 style="margin: 0;">Biblioteca Digital Telmex.</h2>

			</p>
        </div>
        <div class="footer">
            &copy; 2024 Telmex. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
