{{-- {{ $mensaje }} --}}

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">


    <style>
        .container{
            max-width: 100%;
            background-color: #f8f9fa;
        }

        .modal-body{
            width: 100%;
            height: 90%;
            background-color: #222;
            color: #eee;
            font-family: monospace;
            padding: 2rem;
        }
        .form-container {
            max-width: 100%;
            height: 100%;

            /* margin: 50px auto; */
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-row{
            height: 100%;
            width: 100%;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group select,
        .form-group input,
        .form-group textarea {
            border-radius: 5px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            font-size: 15px;
        }



    </style>
</head>
<body>
    <div class="container" style="margin-top: 1%;">
        <div class="form-header">
            <h2>PAGINA DE INICIO</h2>
        </div>

        <div class="modal-body">


            <div class="form-row" >
                <div class="form-group col-md-6">
                    <div class=" form-container" >
                        <iframe id="ytplayer" type="text/html" width="100%" height="100%"
                        src="https://www.youtube.com/embed/KJOhOCwRchQ?autoplay=1&origin=https://youtu.be/KJOhOCwRchQ&start=2500" allowfullscreen
                        frameborder="0">
                        </iframe>
                        {{-- <iframe id="liveVideo" width="100%" height="100%" src="https://www.youtube.com/embed/A-V_73gaUg8?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> --}}

                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="form-container" >
                        <iframe src=" https://aldeadigitaliztapalapa.telmex.com/ " width="100%" height="100%"></iframe>

                    </div>
                </div>


            </div>
        </div>



    </div>





    <br>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>



