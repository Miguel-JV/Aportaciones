{{-- vista extendida del layout --}}
@extends('layouts.landing')

@section('title')
    Portal
@endsection

@section('style')
    {{-- Intro --}}
    <style>
        html {
            height: 100%;
        }

        body {
            overflow: hidden;
            /* background: #bcdee7 url('img/bgaldea.png') no-repeat center center fixed; */
            background-size: cover;
            position: fixed;
            padding: 0px;
            margin: 0px;
            width: 100%;
            height: 100%;
            font: normal 14px/1.618em "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body:before {
            content: "";
            height: 0px;
            padding: 0px;
            border: 130em solid #4d4d4d6b;
            position: absolute;
            left: 50%;
            top: 100%;
            z-index: 2;
            display: block;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            -webkit-animation: puff 0.5s 1.8s cubic-bezier(0.55, 0.055, 0.675, 0.19) forwards, borderRadius 0.2s 2.3s linear forwards;
            animation: puff 0.5s 1.8s cubic-bezier(0.55, 0.055, 0.675, 0.19) forwards, borderRadius 0.2s 2.3s linear forwards;
        }

        h1,
        h2 {
            font-weight: 500;
            margin: 0px 0px 5px 0px;
        }

        h1 {
            font-size: 24px;
        }

        h2 {
            font-size: 16px;
        }

        p {
            margin: 0px;
        }

        .profile-card {
            background: #b60940;
            width: 56px;
            height: 56px;
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 2;
            overflow: hidden;
            opacity: 0;
            margin-top: 70px;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            -webkit-border-radius: 50%;
            border-radius: 50%;
            -webkit-box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16), 0px 3px 6px rgba(0, 0, 0, 0.23);
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16), 0px 3px 6px rgba(0, 0, 0, 0.23);
            -webkit-animation: init 0.5s 0.2s cubic-bezier(0.55, 0.055, 0.675, 0.19) forwards, moveDown 1s 0.8s cubic-bezier(0.6, -0.28, 0.735, 0.045) forwards, moveUp 1s 1.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, materia 0.5s 2.7s cubic-bezier(0.86, 0, 0.07, 1) forwards;
            animation: init 0.5s 0.2s cubic-bezier(0.55, 0.055, 0.675, 0.19) forwards, moveDown 1s 0.8s cubic-bezier(0.6, -0.28, 0.735, 0.045) forwards, moveUp 1s 1.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, materia 0.5s 2.7s cubic-bezier(0.86, 0, 0.07, 1) forwards;
        }

        .profile-card header {
            width: 179px;
            height: 280px;
            padding: 40px 20px 30px 20px;
            display: inline-block;
            float: left;
            border-right: 2px dashed #EEEEEE;
            background: #FFFFFF;
            color: #000000;
            margin-top: 50px;
            opacity: 0;
            text-align: center;
            -webkit-animation: moveIn 1s 3.1s ease forwards;
            animation: moveIn 1s 3.1s ease forwards;
        }

        .profile-card header h1 {
            color: #ca1c5c;
        }

        .profile-card header a {
            display: inline-block;
            text-align: center;
            position: relative;
            margin: 25px 30px;
        }

        .profile-card header a:after {
                position: absolute;
                content: "";
                bottom: 3px;
                right: 3px;
                width: 20px;
                height: 20px;
                border: 4px solid #FFFFFF;
                -webkit-transform: scale(0);
                transform: scale(0);
                background: linear-gradient(#d43c6b 0%, #c82164 50%, #089cdc 50%, #089cdc 100%);
                -webkit-border-radius: 50%;
                border-radius: 50%;
                -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
                box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
                -webkit-animation: scaleIn 0.3s 3.5s ease forwards;
                animation: scaleIn 0.3s 3.5s ease forwards;
        }

        .profile-card header a > img {
            width: 100px;
            height: 100px;
            max-width: 100%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            -webkit-transition: -webkit-box-shadow 0.3s ease;
            transition: box-shadow 0.3s ease;
            -webkit-box-shadow: 0px 0px 0px 8px rgba(255, 35, 185, 0.06);
            box-shadow: 0px 0px 0px 8px rgba(0, 0, 0, 0.06);
        }

        .profile-card header a:hover > img {
            -webkit-box-shadow: 0px 0px 0px 12px rgba(90, 219, 255, 0.248);
            box-shadow: 0px 0px 0px 6px rgba(232, 107, 232, 0.494);
        }

        .profile-card .profile-bio {
            width: 175px;
            height: 180px;
            display: inline-block;
            float: right;
            padding: 50px 20px 30px 20px;
            background: #FFFFFF;
            color: #333333;
            margin-top: 50px;
            text-align: center;
            opacity: 0;
            -webkit-animation: moveIn 1s 3.1s ease forwards;
            animation: moveIn 1s 3.1s ease forwards;
        }

        .profile-social-links {
            width: 218px;
            float: right;
            margin: 0px;
            padding: 15px 20px;
            background: #FFFFFF;
            margin-top: 10px;
            text-align: center;
            opacity: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-animation: moveIn 1s 3.1s ease forwards;
            animation: moveIn 1s 3.1s ease forwards;

        }

        .profile-social-links li {
            list-style: none;
            float: left;
            width: 33%;
            text-align: center;
        }

        @-webkit-keyframes init {
            0% {
                width: 0px;
                height: 0px;
            }
            100% {
                width: 56px;
                height: 56px;
                margin-top: 0px;
                opacity: 1;
            }
        }

        @keyframes init {
            0% {
                width: 0px;
                height: 0px;
            }
            100% {
                width: 56px;
                height: 56px;
                margin-top: 0px;
                opacity: 1;
            }
        }

        @-webkit-keyframes puff {
            0% {
                top: 100%;
                height: 0px;
                padding: 0px;
            }
            100% {
                top: 50%;
                height: 100%;
                padding: 0px 100%;
            }
        }

        @keyframes puff {
            0% {
                top: 100%;
                height: 0px;
                padding: 0px;
            }
            100% {
                top: 50%;
                height: 100%;
                padding: 0px 100%;
            }
        }

        @-webkit-keyframes borderRadius {
            0% {
                -webkit-border-radius: 50%;
            }
            100% {
                -webkit-border-radius: 0px;
            }
        }

        @keyframes borderRadius {
            0% {
                -webkit-border-radius: 50%;
            }
            100% {
                border-radius: 0px;
            }
        }

        @-webkit-keyframes moveDown {
            0% {
                top: 50%;
            }
            50% {
                top: 40%;
            }
            100% {
                top: 100%;
            }
        }

        @keyframes moveDown {
            0% {
                top: 50%;
            }
            50% {
                top: 40%;
            }
            100% {
                top: 100%;
            }
        }

        @-webkit-keyframes moveUp {
            0% {
                background: #dc2c63;
                top: 100%;
            }
            50% {
                top: 40%;
            }
            100% {
                top: 50%;
                background: #E0E0E0;
            }
        }

        @keyframes moveUp {
            0% {
                background: #dc2c63;
                top: 100%;
            }
            50% {
                top: 40%;
            }
            100% {
                top: 50%;
                background: #E0E0E0;
            }
        }

        @-webkit-keyframes materia {
            0% {
                background: #E0E0E0;
            }
            50% {
                -webkit-border-radius: 4px;
            }
            100% {
                width: 440px;
                height: 280px;
                background: #FFFFFF;
                -webkit-border-radius: 4px;
            }
        }

        @keyframes materia {
            0% {
                background: #E0E0E0;
            }
            50% {
                border-radius: 4px;
            }
            100% {
                width: 440px;
                height: 280px;
                background: #FFFFFF;
                border-radius: 4px;
            }
        }

        @-webkit-keyframes moveIn {
            0% {
                margin-top: 50px;
                opacity: 0;
            }
            100% {
                opacity: 1;
                margin-top: -20px;
            }
        }

        @keyframes moveIn {
            0% {
                margin-top: 50px;
                opacity: 0;
            }
            100% {
                opacity: 1;
                margin-top: -20px;
            }
        }

        @-webkit-keyframes scaleIn {
                0% {
                    -webkit-transform: scale(0);
                }
                100% {
                    -webkit-transform: scale(1);
                }
            }

            @keyframes scaleIn {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }

        @-webkit-keyframes ripple {
            0% {
                transform: scale3d(0, 0, 0);
            }
            50%,
            100% {
                -webkit-transform: scale3d(1, 1, 1);
            }
            100% {
                opacity: 0;
            }
        }

        @keyframes ripple {
            0% {
                transform: scale3d(0, 0, 0);
            }
            50%,
            100% {
                transform: scale3d(1, 1, 1);
            }
            100% {
                opacity: 0;
            }
        }

        @media screen and (min-aspect-ratio: 4/3) {
            body {
                background-size: cover;
            }
            body:before {
                width: 0px;
            }
            @ -webkit-keyframes puff {
                0% {
                    top: 100%;
                    width: 0px;
                    padding-bottom: 0px;
                }
                100% {
                    top: 50%;
                    width: 100%;
                    padding-bottom: 100%;
                }
            }
            @keyframes puff {
                0% {
                    top: 100%;
                    width: 0px;
                    padding-bottom: 0px;
                }
                100% {
                    top: 50%;
                    width: 100%;
                    padding-bottom: 100%;
                }
            }
        }

        @media screen and (min-height: 480px) {
            .profile-card header {
                width: auto;
                height: auto;
                padding: 30px 20px;
                display: block;
                float: none;
                border-right: none;
            }
            .profile-card .profile-bio {
                width: auto;
                height: auto;
                padding: 15px 20px 30px 20px;
                display: block;
                float: none;
            }
            .profile-social-links {
                width: 100%;
                display: block;
                float: none;
            }
            @ -webkit-keyframes materia {
                0% {
                    background: #E0E0E0;
                }
                50% {
                    -webkit-border-radius: 4px;
                }
                100% {
                    width: 280px;
                    height: 440px;
                    background: #FFFFFF;
                    -webkit-border-radius: 4px;
                }
            }
            @keyframes materia {
                0% {
                    background: #E0E0E0;
                }
                50% {
                    border-radius: 4px;
                }
                100% {
                    width: 280px;
                    height: 440px;
                    background: #FFFFFF;
                    border-radius: 4px;
                }
            }
        }

        .more:hover{
            transform: scale(2);
            transition: 0.8s ease-in-out;
        }
        .more:not(:hover){
            transform: scale(1.0);
            transition: 0.8s ease-in-out;
        }
    </style>

@endsection


@section('content')

    <div id="tsparticles"></div>

    <section class="profile-card">
        <header>
            <a target="_blank" href="https://aldeadigitaliztapalapa.telmex.com/">
                <img src="{{ asset('img/telmex.png') }}" class="hoverZoomLink">
            </a>

            <h1>
                Aldea Iztapalapa
            </h1>

            <h2>
                    Telmex-Telcel
            </h2>

        </header>

        <div class="profile-bio">

            <p>
                Aldea Digital Iztapalapa TELMEX TELCEL es un espacio educativo dotado de tecnología de última generación, conectividad de alta velocidad y experiencias de aprendizaje gratuitas.
            </p>

        </div>

        <ul class="profile-social-links" >
            <li>
                <a target="_blank" href="https://www.facebook.com/BibliotecaDigitalTelmex">
                    <i class="fa-brands fa-facebook more" style="color: #1f5ebf;"></i>
                </a>
            </li>
            <li>
                <a  href="{{ route('landing.videos') }}">
                    <i class="fa-solid fa-circle-plus more" style="color:#b60940;"></i>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://www.youtube.com/channel/UCrP4JrjqIP59P5NGi2KLL1Q">
                    <i class="fa-brands fa-youtube more" style="color:red;"></i>
                </a>
            </li>

        </ul>
    </section>

@endsection

@section('script')
    {{-- Configuracion Particulas --}}
    <script type="text/javascript">
        const options = {
            fullScreen : {
                enable: true,
                zIndex: -1
            },
            background: {
                color: {
                    value: '#1b1b1b',
                },
            },
            fpsLimit:120,
            interactivity: {
                events:{
                    onClick:{
                        enable: false,
                        mode: 'push',
                    },
                    onHover:{
                        enable:true,
                        mode:'repulse',
                    },
                    resize:true,
                },
                modes:{
                    push:{
                        quantity: 30
                    },
                    repulse: {
                        distance: 60,
                        duration: 0.1,
                    },
                },
            },
            particles: {
                color: {
                    value:'#0c2c68',
                },
                links:{
                    color: '#cc3c6c',
                    distance: 100,
                    enable: true,
                    opacity: 0.9,
                    width: 0.5
                },
                collisions: {
                    enable:true,
                },
                move:{
                    directions: 'none',
                    enable: true,
                    outModes: {
                        default: 'bounce',
                    },
                    random: false,
                    speed: 1,
                    straight: false
                },
                number: {
                    density: {
                        enable: true,
                        area: 500
                    },
                    value:150,
                },
                opacity:{
                    value: 0.5,
                },
                shape: {
                    type:'triangle',
                },
                size: {
                    value: { min: 1, max: 5},
                },
            },
            detectRetina: true,
        };

        tsParticles.load("tsparticles", options);
    </script>
@endsection



