<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimiento de documentación</title>
    <style>
        body{
            margin:0;
            padding:20px 10px;
            background:#f5f5f5;
            font-family:Arial, Helvetica, sans-serif;
        }

        .card{
            width:600px;
            max-width:600px;
            background:#ffffff;
            border:1px solid #dddddd;
            border-radius:8px;
            padding:15px 20px;
            box-sizing:border-box;
        }

        .header{
            background:#e22275;
            background-color:#e22275;
            color:#ffffff;
            padding:8px;
            text-align:center;
            font-size:18px;
            font-weight:bold;
            border-radius:6px;
            display:block;
            width:100%;
            box-sizing:border-box;
        }

        .info{
            background:#f5f5f5;
            border-left:5px solid #e22275;
            padding:15px;
            margin-top:20px;
            line-height:1.7;
        }

        p{
            font-size:15px;
            color:#333333;
            line-height:1.7;
        }

        .footer{
            margin-top:30px;
            border-top:1px solid #e5e5e5;
            padding-top:15px;
            text-align:center;
            color:#777777;
            font-size:12px;
            line-height:1.6;
        }
    </style>
</head>
<body style="margin:0;padding:40px 20px;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0"  border="0">
        <tr>
            <td align="center">
                <table class="card">
                    <tr>
                        <td style="padding:35px 40px;">
                            <div class="header">
                                Instituto de Elecciones y Participación Ciudadana
                            </div>
                            <br>
                            <h2 style="color:#333333;">
                                Hola {{ $nombre }},
                            </h2>
                            <p>
                                Durante el proceso de revisión de tu registro se detectaron
                                <b>documentos con observaciones pendientes</b>.
                            </p>
                            <div class="info">
                                <b>Información:</b>
                                <br><br>
                                Se generó un archivo PDF con el detalle de los documentos
                                que requieren atención y la observación correspondiente.
                            </div>
                            <p>
                                El archivo PDF con el <b>Requerimiento de documentación</b>
                                se encuentra adjunto en este correo para que puedas realizar
                                las correcciones necesarias.
                            </p>
                            <p>
                                Te solicitamos atender las observaciones indicadas para continuar
                                con el proceso de validación.
                            </p>
                            <p>
                                Gracias por participar en el
                                <b>Proceso Electoral Local Ordinario 2027.</b>
                            </p>
                            <div class="footer">
                                <strong>
                                    Instituto de Elecciones y Participación Ciudadana
                                </strong>
                                <br>
                                Proceso Electoral Local Ordinario 2027
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
