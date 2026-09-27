<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 429</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .error {
            width: 90%;
            max-width: 600px;
            padding: 50px 30px;
            text-align: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        }

        .code {
            font-size: 80px;
            font-weight: bold;
            color: #971B60;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 25px;
            margin: 10px 0;
        }

        p {
            color: #666;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 22px;
            color: #fff;
            background: #971B60;
            text-decoration: none;
            border-radius: 4px;
        }

        a:hover {
            background: #7d164f;
        }
    </style>
</head>

<body>

    <div class="error">

        <div class="code">429</div>

        <h1>Demasiadas solicitudes</h1>

        <p>
            Se han realizado demasiadas solicitudes.
            Espere unos momentos e inténtelo nuevamente.
        </p>

        <a href="{{ url('/') }}">Regresar</a>

    </div>

</body>
</html>
