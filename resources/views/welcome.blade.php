<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        *{
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: poppins,sans-serif;
            text-decoration: none;
        }
        body{
            overflow-x: hidden;
        }
        .hero-header{
            width:100%;
            height: 100%;
            min-height: 100vh;
        }
        .wrapper{
            width:1280px;
            max-width: 95%;
            margin: 0 auto;
            padding: 0 20px;
        }
        header{
            padding: 40px 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        nav .togglebtn{
            width: 35px;
            height: 35px;
            position: absolute;
            top:45px;
            right: 3%;
            z-index: 5;
            cursor: pointer;
            display: none;
        }
        nav .togglebtn span{
            display: block;
            background-color: #007ced;
            margin: 5px 0px;
            width:100%;
            height:3px;
            transition: 0.3s;
            transition-property:  transform, opacity;

        }
        nav .navlinks{
            list-style-type: none;
        }
        nav .navlinks li{
            display: inline-block;
        }
        nav .navlinks li a{
            color:#007ced;
            margin-right: 2.5rem;
            z-index: 1;
            font-weight: 200;
            letter-spacing: 4px;
        }
        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding-top:4rem;
        }
        .container .hero-pic{
            width: 300px;
            height: 300px;
            border-radius: 50%;
            overflow: hidden;
            border: 15px solid #444;
            box-shadow: 5px 7px 25px rgba(0,0,0,0.5);
        }
        .hero-pic img{
            height: 100%;
            width: 100%;
            transition: 0.5s;
        }
        .hero-pic img:hover{
            transform: scale(1.07);
        }
        .hero-text{
            max-width: 550px;
            display: flex;
            flex-direction: column;
        }

        .hero-text h5 span{
            color:#007ced;
            font-size: 16px;
        }
        .hero-text h1{
            color: #007ced;
            font-size: 3rem;
        }

        @media(max-width:1000px)
        {
            .container{
                flex-direction: column;
                padding-top:2rem;
            }
            .hero-text{
                padding:40px 0px;
            }
            .hero-text h1{
                color: #007ced;
                font-size: 2rem;
            }

            .container .hero-pic{
                width: 200px;
                height: 200px;
                border-radius: 50%;
                overflow: hidden;
                border: 15px solid #444;
                box-shadow: 5px 7px 25px rgba(0,0,0,0.5);
            }
        }

        .button {
            height: 50px;
            width: 200px;
            position: relative;
            background-color: transparent;
            cursor: pointer;
            border: 2px solid #252525;
            overflow: hidden;
            border-radius: 30px;
            color: #333;
            transition: all 0.5s ease-in-out;
        }

        .btn-txt {
            z-index: 1;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .type1::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            transition: all 0.5s ease-in-out;
            background-color: #3977ba ;
            border-radius: 30px;
            visibility: hidden;
            height: 10px;
            width: 10px;
            z-index: -1;
        }

        .button:hover {
            box-shadow: 0.5px 0.5px 200px #8ebcef ;
            color: #fff;
            border: none;
        }

        .type1:hover::after {
            visibility: visible;
            transform: scale(100) translateX(2px);
        }
    </style>
</head>
<body>
    <div class="hero-header">
        <div class="wrapper">
            <header>
                <div class="logo">

                </div>
                <nav>
                    <ul class="navlinks">
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ url('/home') }}"><i class="fa-solid fa-house"></i></a></li>
                            @else
                                <li><a href="{{ route('login.tickets') }}"><i class="fa-solid fa-user-tie"></i></a></li>
                            @endauth
                        @endif
                    </ul>
                </nav>
            </header>
            <div class="container">
                <div class="hero-pic">
                <img src="{{ asset('img/telmex-welcome.png') }}" alt="profile pic">
                </div>
                <div class="hero-text">
                    <h5> <span class="input">Gestión</span></h5>
                    <h1>Sistema de Integración</h1>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" style="text-align: center;">
                                <button class="button type1" style="margin-top: 5%; ">
                                    Acceder
                                </button>
                            </a>
                        @else
                            <a href="{{ route('login.tickets') }}" style="text-align: center;">
                                <button class="button type1" style="margin-top: 5%; ">
                                    Acceder
                                </button>
                            </a>
                        @endauth
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.10/typed.min.js"></script>
    <script>

        var typed=new Typed(".input",{
            strings:["Mantenimientos","Tutorias","Reportes"],
            typedSpeed:70,
            backSpeed:55,
            loop:true
        })
    </script>
</body>
</html>
