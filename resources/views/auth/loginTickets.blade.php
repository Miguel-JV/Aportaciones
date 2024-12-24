<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Open Sans", sans-serif;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        padding: 0 10px;
    }

    body::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
    }

    .wrapper {
        width: 400px;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        border: 1px solid rgba(184, 184, 184, 0.5);
        box-shadow: 5px 7px 25px rgba(0,0,0,0.5);

        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    form {
        display: flex;
        flex-direction: column;
    }

    h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #007ced;
    }

    .input-field {
        position: relative;
        border-bottom: 2px solid #ccc;
        margin: 15px 0;
    }

    .input-field label {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        color: #007ced;
        font-size: 16px;
        pointer-events: none;
        transition: 0.15s ease;
    }

    .input-field input {
        width: 100%;
        height: 40px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 16px;
        color: #007ced;
    }

    .input-field input:focus~label,
    .input-field input:valid~label {
        font-size: 0.8rem;
        top: 10px;
        transform: translateY(-120%);
    }



    .wrapper a {
        color: #efefef;
        text-decoration: none;
    }

    .wrapper a:hover {
        text-decoration: underline;
    }

    button {
        background: #007ced;
        color: #ffffff;
        font-weight: 600;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        border-radius: 3px;
        font-size: 16px;
        border: 2px solid transparent;
        transition: 0.3s ease;
    }

    button:hover {
        color: #007ced;
        border-color: #007ced;
        background: rgba(255, 255, 255, 0.15);
    }

    .register {
        text-align: center;
        margin-top: 30px;
        color: #007ced;
    }
    </style>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="{{ route('login.tickets.submit') }}">
            @csrf
            <div class="input-field">
            <input id="folio" type="text" class="form-control" name="folio" value="{{ old('folio') }}" required autofocus>
            <label>Folio</label>
        </div>
        <div class="input-field">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            <label>Contraseña</label>
        </div>
        <button type="submit">Acceder</button>

        </form>
    </div>
</body>
</html>
