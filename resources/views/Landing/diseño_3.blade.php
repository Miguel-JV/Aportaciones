{{-- vista extendida del layout --}}
@extends('layouts.landing')

@section('title')
    Videos Aldea
@endsection

@section('style')
    {{-- Intro --}}
    <style>
        * {
        box-sizing: border-box;
        margin: 0;
        }

        h1 {
        margin: 1rem 0;
        }

        h2 {
        color: rgb(0, 0, 0);
        opacity: 0;
        font-size: 3rem;
        animation: fadeIn 2s ease forwards;
        }

        p {
        font-size: 4rem;
        opacity: 0;
        animation: fadeInText 2s ease forwards 3s;
        }

        .intro {
        height: 100%;
        background-color: rgba(182, 182, 182, 0.146);
        display: flex;
        justify-content: center;
        align-items: center;
        }

        main {
        position: absolute;
        top: 0;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: mistyrose;
        transform: scale(0, 0);
        animation: animate 1s ease-in forwards 2s;
        overflow: hidden;
        }

        .content {
        width: 100%;
        text-align: center;
        /* overflow-y: auto; */
        }

        @keyframes animate {
        0% {
            transform: scale(0, 0.005);
        }
        50% {
            transform: scaleY(0.005);
        }
        100% {
            transform: scale(1, 1);
        }
        }

        @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(50%);
        }
        to {
            opacity: 1;
            transform: translateY(-50%);
        }
        }

        @keyframes fadeInText {
        from {
            opacity: 0;
            transform: translateY(50%);
        }
        to {
            opacity: 1;
            transform: translateY(0%);
        }
        }
    </style>


    {{-- General --}}
    <style>

        .container-subtitle{
            width: 100%;
            backdrop-filter: blur(1px);
            border-radius: 5px;
            box-shadow: 0 15px 25px rgba(255, 255, 255, 0.1);

            color: rgb(0, 0, 0);
            text-align: center;

            padding: 10px 0;
        }
        .subtitle{
            margin-top: 20px;

        }
    .algo{
        color:
        #d43c6b  #c82164  #dc2c63  #d42561  #d23464  #cc2c64  #ca1c5c  #cc3c6c

        #eaa94b  #1f5ebf  #06a0b2  #58cbf3  #333c66  #7776c4  #453c3a  #262a61 #0c2c68
    }
    </style>

    {{-- Poigono SVG --}}
    <style>

        @keyframes bounce {
        0%,100% {
                translate: 0px 36px;
            }
            50% {
                translate: 0px 46px;
            }
        }
        @keyframes bounce2 {
            0%,100% {
                translate: 0px 46px;
            }
            50% {
                translate: 0px 56px;
            }
        }

        @keyframes umbral {
            0% {
                stop-color: #d310cc2e;
            }
            50% {
                stop-color: #b54bea;
            }
            100% {
                stop-color: #1095d32e;
            }
        }
        @keyframes partciles {
            0%,100% {
                translate: 0px 16px;
            }
            50% {
                translate: 0px 6px;
            }
        }
        #particles {
            animation: partciles 4s ease-in-out infinite;
        }
        #animatedStop {
            animation: umbral 4s infinite;
        }
        #bounce {
            animation: bounce 4s ease-in-out infinite;
            translate: 0px 36px;
        }
        #bounce2 {
            animation: bounce2 4s ease-in-out infinite;
            translate: 0px 46px;
            animation-delay: 0.5s;
        }
    </style>

    {{-- YouTube --}}
    <style>

        .container-youtube {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;


            margin-left: auto;

            width: 90%;
            height: 100%;

            /* background-color: rgba(255, 255, 255, 0.1); */
            /* box-shadow: 0 15px 25px rgba(255, 255, 255, 0.1); */

            border-radius: 5px;
            backdrop-filter: blur(1px);

            color: rgb(0, 0, 0);
        }

        h1 {
            margin-bottom: 20px;
        }

        #videosContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

            /* transform: scale(2);
            transition: 0.8s ease-in-out; */
            /* transform: scale(1.0);
            transition: 0.8s ease-in-out; */
        }

        .video {
            width: 300px;
            margin: 10px;
            cursor: pointer;
        }

        .video img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Modal */
        #myModal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
        }

        #modal-content {
            position: relative;
            background-color: #fff;
            margin: auto;
            padding: 20px;
            width: 80%;
            max-width: 900px;
            border-radius: 10px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 25px;
            color: #000;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: red;
            text-decoration: none;
            cursor: pointer;
        }

        iframe {
            width: 100%;
            height: 500px;
            border: none;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination button {
            padding: 10px 15px;
            margin: 0 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination button.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .video {
                width: 100%;
            }

            iframe {
                height: 300px;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>

    {{-- Extra --}}
    <style>
        .more:hover{
            transform: scale(1.05);
            transition: 0.8s ease-in-out;
        }
        .more:not(:hover){
            transform: scale(1.0);
            transition: 0.8s ease-in-out;
        }

        .btn-outline-pink-color, .btn-outline-pink-color:hover, .btn-outline-pink-color:active, .btn-outline-pink-color:visited {
            background-color: transparent !important;
            border-color: #cc3c6c !important;
            color: #cc3c6c !important;
        }

        .btn-outline-pink-color:hover{
            background-color: #cc3c6c !important;
            color: white !important;
            transition: 0.8s ease-in-out;

        }

        .btn-outline-pink-color:not(:hover){
            background-color: transparent !important;
            border-color: #cc3c6c !important;
            color: #cc3c6c !important;
            transition: 0.8s ease-in-out;
        }



        .btn-outline-gray-color, .btn-outline-gray-color:hover, .btn-outline-gray-color:active, .btn-outline-gray-color:visited {
            background-color: transparent !important;
            border-color: #a9a9a9 !important;
            color: #a9a9a9 !important;
        }

        .btn-outline-gray-color:hover{
            background-color: #a9a9a9 !important;
            color: white !important;
            transition: 0.8s ease-in-out;

        }

        .btn-outline-gray-color:not(:hover){
            background-color: transparent !important;
            border-color: #a9a9a9 !important;
            color: #a9a9a9 !important;
            transition: 0.8s ease-in-out;
        }
    </style>
@endsection


@section('content')

    <div class="container">

        <div class="intro">
            <h2>DESCUBRE</h2>
        </div>
        <main>
            <div class="content">

                <div id="tsparticles"></div>

                {{-- Youtube --}}
                <section class="container-subtitle">
                    <div class="subtitle">
                        {{-- <h1>Video Conferencias Aldea</h1> --}}

                        <iframe id="liveVideo" width="100%" height="100%" src="https://www.youtube.com/embed/A-V_73gaUg8?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                    </div>
                </section>
                
                <section class="container-youtube">
                    <div id="videosContainer" ></div>
                    <div class="pagination">

                        <button id="prevPage" class="disabled btn-outline-gray-color">
                            <i class="fa-solid fa-backward"></i>
                        </button>
                        <button id="nextPage" class="btn-outline-pink-color">
                            <i class="fa-solid fa-forward"></i>
                        </button>
                    </div>
                    <br>
                    {{-- Portal Animado --}}
                    <a href="{{ redirect()->getUrlGenerator()->previous() }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="200" width="200">
                            <g style="order: -1;">
                                {{-- Linea Base Superior --}}
                                <polygon
                                transform="rotate(45 100 100)"
                                stroke-width="1"
                                stroke="#d23464"
                                fill="none"
                                points="70,70 148,50 130,130 50,150"
                                id="bounce"
                                ></polygon>

                                {{-- Linea Base Inferior --}}

                                <polygon
                                transform="rotate(45 100 100)"
                                stroke-width="1"
                                stroke="#d23464"
                                fill="none"
                                points="70,70 148,50 130,130 50,150"
                                id="bounce2"
                                ></polygon>

                                <polygon
                                transform="rotate(45 100 100)"
                                stroke-width="2"
                                stroke=""
                                fill="#414750"
                                points="70,70 150,50 130,130 50,150"
                                ></polygon>
                                <polygon
                                stroke-width="2"
                                stroke=""
                                fill="url(#gradiente)"
                                points="100,70 150,100 100,130 50,100"
                                ></polygon>
                                <defs>
                                <linearGradient y2="100%" x2="10%" y1="0%" x1="0%" id="gradiente">
                                    <stop style="stop-color: #1e2026;stop-opacity:1" offset="20%"></stop>
                                    <stop style="stop-color:#414750;stop-opacity:1" offset="60%"></stop>
                                </linearGradient>
                                </defs>
                                <polygon
                                transform="translate(20, 31)"
                                stroke-width="2"
                                stroke=""
                                {{-- Centro izquierda --}}
                                fill="#58cbf3"
                                points="80,50 80,75 80,99 40,75"
                                ></polygon>
                                <polygon
                                transform="translate(20, 31)"
                                stroke-width="2"
                                stroke=""
                                fill="url(#gradiente2)"
                                points="40,-40 80,-40 80,99 40,75"
                                ></polygon>
                                <defs>

                                {{-- Iluminacion --}}
                                <linearGradient y2="100%" x2="0%" y1="-17%" x1="10%" id="gradiente2">
                                    <stop style="stop-color: #d3109500;stop-opacity:1" offset="20%"></stop>
                                    <stop
                                    style="stop-color:#ff2cf454;stop-opacity:1"
                                    offset="100%"
                                    id="animatedStop"
                                    ></stop>
                                </linearGradient>
                                </defs>
                                <polygon
                                transform="rotate(180 100 100) translate(20, 20)"
                                stroke-width="2"
                                stroke=""

                                {{-- Centro derecha --}}
                                fill="#58cbf3"
                                points="80,50 80,75 80,99 40,75"
                                ></polygon>
                                <polygon
                                transform="rotate(0 100 100) translate(60, 20)"
                                stroke-width="2"
                                stroke=""
                                fill="url(#gradiente3)"
                                points="40,-40 80,-40 80,85 40,110.2"
                                ></polygon>
                                <defs>

                                {{-- Iluminacion --}}
                                <linearGradient y2="100%" x2="10%" y1="0%" x1="0%" id="gradiente3">
                                    <stop style="stop-color: #d3108200;stop-opacity:1" offset="20%"></stop>
                                    <stop
                                    style="stop-color:#ff21f8bf;stop-opacity:1"
                                    offset="100%"
                                    id="animatedStop"
                                    ></stop>
                                </linearGradient>
                                </defs>

                                {{-- Particulas (3) --}}
                                <polygon
                                transform="rotate(45 100 100) translate(80, 95)"
                                stroke-width="2"
                                stroke=""
                                fill="#ff21f8bf"
                                points="5,0 5,5 0,5 0,0"
                                id="particles"
                                ></polygon>
                                <polygon
                                transform="rotate(45 100 100) translate(80, 55)"
                                stroke-width="2"
                                stroke=""
                                fill="#ff21f8bf"
                                points="6,0 6,6 0,6 0,0"
                                id="particles"
                                ></polygon>
                                <polygon
                                transform="rotate(45 100 100) translate(70, 80)"
                                stroke-width="2"
                                stroke=""
                                fill="#ff21f8bf"
                                points="2,0 2,2 0,2 0,0"
                                id="particles"
                                ></polygon>
                                <polygon
                                stroke-width="2"
                                stroke=""
                                fill="#292d34"
                                points="29.5,99.8 100,142 100,172 29.5,130"
                                ></polygon>

                                <polygon
                                    transform="translate(50, 92)"
                                    stroke-width="2"
                                    stroke=""
                                    fill="#1f2127"
                                    points="50,50 120.5,8 120.5,35 50,80"
                                    >
                                </polygon>
                            </g>
                        </svg>
                    </a>
                </section>

            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="myModal">
        <div id="modal-content">
            <span class="close">&times;</span>
            <iframe id="videoIframe" src="" allowfullscreen></iframe>
        </div>
    </div>
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
                    value: '#ffff',
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
                        distance: 30,
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


    {{-- Youtube --}}
    <script>
        // API Key obtenida de Google Developers Console
        const API_KEY = 'AIzaSyBs8008RgdORx9YQuX1XJ0ETY4JM-Fas9M';

        // ID del canal de Biblioteca Digital Telmex
        const channelID = 'UCrP4JrjqIP59P5NGi2KLL1Q';

        // Parámetros de la API de YouTube
        let nextPageToken = '';
        let prevPageToken = '';
        const maxResults = 3; // Videos por página

        // Elementos de la página
        const prevButton = document.getElementById('prevPage');
        const nextButton = document.getElementById('nextPage');
        const videosContainer = document.getElementById('videosContainer');
        const modal = document.getElementById('myModal');
        const modalContent = document.getElementById('modal-content');
        const videoIframe = document.getElementById('videoIframe');
        const closeModal = document.getElementsByClassName('close')[0];

        // Función para obtener los videos del canal
        async function fetchVideos(pageToken = '') {
            const baseURL = `https://www.googleapis.com/youtube/v3/search?key=${API_KEY}&channelId=${channelID}&part=snippet&type=video&order=date&maxResults=${maxResults}&pageToken=${pageToken}`;

            try {
                const response = await fetch(baseURL);
                const data = await response.json();

                // Actualizar tokens de paginación
                nextPageToken = data.nextPageToken || '';
                prevPageToken = data.prevPageToken || '';

                // Desactivar botones si no hay más páginas
                prevButton.classList.toggle('disabled', !prevPageToken);
                nextButton.classList.toggle('disabled', !nextPageToken);

                // Limpiar el contenedor antes de agregar nuevos videos
                videosContainer.innerHTML = '';

                // Recorre los videos y crea una miniatura para cada uno
                data.items.forEach(item => {
                    if (item.id.kind === 'youtube#video') {
                        const videoElement = document.createElement('div');
                        videoElement.classList.add('video');
                        videoElement.classList.add('more');
                        videoElement.innerHTML = `
                            <img src="${item.snippet.thumbnails.medium.url}" alt="${item.snippet.title}" >
                            <h4>${item.snippet.title}</h4>
                        `;
                        videoElement.addEventListener('click', () => openModal(item.id.videoId));
                        videosContainer.appendChild(videoElement);
                    }
                });

            } catch (error) {
                console.error("Error al obtener los videos: ", error);
            }
        }

        // Abrir el modal con el video
        function openModal(videoId) {
            videoIframe.src = `https://www.youtube.com/embed/${videoId}`;
            modal.style.display = "block";
        }

        // Cerrar el modal
        closeModal.onclick = function() {
            modal.style.display = "none";
            videoIframe.src = ''; // Limpiar el src para detener el video
        }

        // Cerrar el modal al hacer clic fuera de él
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
                videoIframe.src = ''; // Limpiar el src para detener el video
            }
        }

        // Manejadores de eventos para los botones de paginación
        prevButton.addEventListener('click', () => {
            if (prevPageToken) {
                fetchVideos(prevPageToken);
            }
        });

        nextButton.addEventListener('click', () => {
            if (nextPageToken) {
                fetchVideos(nextPageToken);
            }
        });

        // Llama a la función para mostrar los videos de la primera página
        fetchVideos();
    </script>
@endsection



