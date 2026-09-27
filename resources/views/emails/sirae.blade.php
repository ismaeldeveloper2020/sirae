<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f3f6fb;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 100%;
            padding: 40px 0;
        }

        .card {
            width: 600px;
            background: #ffffff;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
        }

        .header {
            background: #E22275;
            text-align: center;
            padding: 35px 20px;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            line-height: 30px;
        }

        .header img {
            width: 150px;
            margin-bottom: 20px;
        }

        .content {
            padding: 40px;
            color: #333333;
            text-align: left;
        }

        .title {
            color: #E22275;
            font-size: 24px;
            margin-top: 0;
        }

        .button {
            display: inline-block;
            background: #E22275;
            color: #ffffff !important;
            padding: 14px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
        }

        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 20px;
            color: #777777;
            font-size: 12px;
        }

    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <div class="container">
                    <table class="card" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="header">
                                <h2>
                                    INSTITUTO DE ELECCIONES Y PARTICIPACIÓN CIUDADANA
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="content">
                                <h2 class="title">
                                    {{ $titulo }}
                                </h2>
                                <p>
                                    {{ $mensaje }}
                                </p>
                                <!-- BOTON CENTRADO -->
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center">
                                            <a href="{{ $url }}" class="button">
                                                {{ $boton }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <p>
                                    Si no realizaste esta acción puedes ignorar este correo.
                                </p>
                                <br>
                                <p>
                                    Atentamente
                                </p>
                                <p>
                                    Dirección Ejecutiva de Educación Cívica y Capacitación
                                </p>
                                <hr>
                                <br><br>
                                <p style="font-size:13px;color:#666;">
                                    {{ $url_texto }}
                                </p>
                                <p style="
                                font-size:12px;
                                word-break:break-all;
                                color:#555;
                                ">
                                    {{ $url_respaldo }}

                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="footer">
                                © {{ date('Y') }} SIRAE
                                <br>
                                Sistema Institucional
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
