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


        .title_intro {
            color: rgb(217, 6, 143);
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

            text-align: center;
        }

        main {
            position: absolute;
            top: 0;

            /* CONTENIDO ADAPTABLE */
            height: auto;

            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgb(0, 0, 0);
            transform: scale(0, 0);
            animation: animate 1s ease-in forwards 2s;
            overflow: hidden;
        }

        .content {
            width: 100%;
            text-align: center;
            height: 100%;
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


    {{-- YouTube --}}
    <style>

        .container-youtube {
            max-width: 500px;
            margin: 0 auto;
            /* padding: 20px; */
            text-align: center;


            margin-left: auto;

            height: 100%;

            background-color: rgb(255, 28, 28);
            /* box-shadow: 0 15px 25px rgba(255, 255, 255, 0.1); */

            border-radius: 5px;
            /* backdrop-filter: blur(1px); */

            color: rgb(0, 0, 0);
            font-family: Times, "Times New Roman", Georgia, serif;
            font-size: x-small;
        }

        #videosContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

            margin-top: 50px;
        }

        .video {
            width: 45%;
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

        .video-Iframe {
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

    </style>

    {{-- Botones --}}
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

    {{-- Grid --}}
    <style>
        /* *{
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;
        } */

        html{
            height: 100%;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.3rem;
            min-height: auto;


        }

        .grid-container > * { /* hereda a todo dentro de la clase*/
            /* box-shadow: -1px 1px 7px 0px black; */
            border-radius: 4px;
            padding: 10px;
            text-align: center;
        }

        .grid-container{ /* estilos de grilla segun los objetos */
            height: 1000px;
            display: grid;
            gap: 10px;
            grid-template:
                "logo"  15%

                "conferencia-frame" 20%
                "navbar" 35%

                "footer" 30%;

        }


        @media (min-width: 600px){
            .grid-container{
                grid-template:
                "logo              logo              logo"   200px
                "conferencia-frame conferencia-frame navbar" 500px
                "footer            footer            footer" 300px
            }
        }




        .logo{
            grid-area: logo;
            background-color: rgba(255, 255, 255, 0);
        }

        .logo img{
            transform: scale(0.9);
            background-color: rgba(255, 255, 255, 0);

            /* margin-right: 30px; */
        }



        .conferencia-frame{
            grid-area: conferencia-frame;
            background-color: rgba(255, 192, 203, 0);

            backdrop-filter: blur(1px);

        }
        .conferencia-frame iframe{
            border-radius: 10px;
        }

        .navbar{
            grid-area: navbar;
            background-color: rgba(255, 181, 132, 0);

            backdrop-filter: blur(1px);
        }

        .footer{
            grid-area: footer; /* contenido de la tabla/grilla */
            background-color: rgba(0, 0, 0, 0);
            color: white;

            backdrop-filter: blur(1px);

        }

        .footer iframe{
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .footer img {
            height: auto;
            max-width: 90%;
            border-radius: 10px;
        }

    </style>

    {{-- Titulos --}}
    <style>
        h4{
            color: rgb(0, 0, 0);
        }

        a{
            text-decoration: none;
        }

        .aldea-embed-title:hover{
            color: #cc1b61;
            transition: 0.3s ease-in-out;
        }

        .aldea-embed-title:not(:hover){
            color: #000000;
            transition: 0.3s ease-in-out;
        }

        .font-subtitle{
            font-family: 'Courier New', Courier, monospace;
        }

        .font-subtitle-site{
            font-size: 3.5vw;
            margin-bottom: 1%;
        }

    </style>

    {{-- Boton Conócenos--}}
    <style>
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
        background-color: #3977ba;
        border-radius: 30px;
        visibility: hidden;
        height: 10px;
        width: 10px;
        z-index: -1;
        }

        .button:hover {
        box-shadow: 1px 1px 200px #3977ba;
        color: #fff;
        border: none;
        }

        .type1:hover::after {
        visibility: visible;
        transform: scale(100) translateX(2px);
        }

    </style>
@endsection


@section('content')

    <div class="container">

        <div class="intro">
            <div id="tsparticles"></div>
            <h2 class="title_intro font-subtitle">
                DESCUBRE MÁS SOBRE NOSOTROS!
            </h2>
        </div>


        <main>
            <div id="tsparticles_content"></div>
            <div class="content grid-container">


                <section class="logo">
                    <a href="https://telmexeducacion.com/" >
                        <img src="{{ asset('img/telemexeducacion-logo.svg') }}" alt="">
                    </a>
                </section>

                <section class="conferencia-frame">
                    <h4 id="liveVideoTitle" class="font-subtitle">ULTIMA VIDEO CONFERENCIA</h4>
                    <iframe id="liveVideo" width="90%" height="90%" src="https://www.youtube.com/embed/A-V_73gaUg8?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </section>

                <section class="navbar container-youtube">
                    <h2 class="font-subtitle">TAMBIÉN TE PODRIA INTERESAR...</h2>

                    <div id="videosContainer"></div>

                    <div class="pagination">
                        <button id="prevPage" class="disabled btn-outline-gray-color">
                            <i class="fa-solid fa-backward"></i>
                        </button>
                        <button id="nextPage" class="btn-outline-pink-color">
                            <i class="fa-solid fa-forward"></i>
                        </button>
                    </div>
                </section>

                <footer class="footer">
                    <a href="https://telmexeducacion.com/" >
                        <h4 class="aldea-embed-title font-subtitle-site">¡Estamos conectados contigo!</h4>
                        <p class="aldea-embed-title font-subtitle-site" style="font-size:medium;">
                            Participa en nuestras actividades desde este sitio o visitanos en alguna de nuestras sedes y
                            <br>desarrolla tus habilidades digitales.
                        </p>
                    </a>

                    <a href="https://telmexeducacion.com/" >
                        <button class="button type1" style="margin-top: 2%;">
                            <span class="btn-txt">Conócenos</span>
                        </button>
                    </a>

                </footer>


                <!-- Modal -->
                <div id="myModal">
                    <div id="modal-content">
                        <span class="close">&times;</span>
                        <iframe class="video-Iframe" id="videoIframe" src="" allowfullscreen></iframe>
                    </div>
                </div>

            </div>
        </main>
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
                    value: '#000000',
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
                        enable:false,
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
                    value: { min: 3, max: 5},
                },
            },
            detectRetina: true,
        };

        const options_2 = {
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
                    value:'#00c7ff',
                },
                links:{
                    color: '#FF7DA3',
                    distance: 100,
                    enable: true,
                    opacity: 0.9,
                    width: 0.5
                },
                collisions: {
                    enable:false,
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
                    value: { min: 3, max: 5},
                },
            },
            detectRetina: true,
        };

        tsParticles.load("tsparticles", options);
        tsParticles.load("tsparticles_content", options_2);
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

        // Elemento de ultima videoconferencia
        const lastvideoIframe = document.getElementById('liveVideo');
        const lastvideoTitle = document.getElementById('liveVideoTitle');


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


                // Videos de live streaming
                for (let i = 0; i < data.items.length; i++) {
                    if(data.items[i].id.kind === 'youtube#video'){
                        lastvideoIframe.src= `https://www.youtube.com/embed/${data.items[i].id.videoId}`;
                        // lastvideoTitle.innerHTML= `${data.items[i].snippet.title}`;
                        break;
                    }
                }


                // Recorre los videos y crea una miniatura para cada uno
                data.items.forEach(item => {
                    if (item.id.kind === 'youtube#video') {
                        const videoElement = document.createElement('div');
                        videoElement.classList.add('video');
                        videoElement.innerHTML = `
                            <img src="${item.snippet.thumbnails.medium.url}" alt="${item.snippet.title}">
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



