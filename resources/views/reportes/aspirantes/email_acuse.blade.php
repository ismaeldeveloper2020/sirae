<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acuse de registro electrónico</title>

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

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">

            <table class="card" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding:35px 40px;">
                        <div class="header">
                            Instituto de Elecciones y Participación Ciudadana
                        </div>
                        <br>
                        <h2 style="margin-top:0;color:#333333;"> Hola {{ $nombre }},</h2>
                        <p style="font-size:15px;color:#333333;line-height:1.7;">
                            Tu <b>Acuse de Registro Electrónico</b> fue generado correctamente.
                        </p>
                        <div class="info" style="background:#f5f5f5;border-left:5px solid #e22275;padding:15px;margin-top:20px;line-height:1.7;">
                            <b>Folio del Aspirante:</b>
                            {{ $folio }}
                        </div>
                        <p style="font-size:15px;color:#333333;line-height:1.7;">
                            El archivo PDF correspondiente a tu <b> Acuse de Registro Electrónico</b> se encuentra adjunto en este correo para tu consulta.
                        </p>
                        <p style="font-size:15px;color:#333333;line-height:1.7;">
                            Gracias por participar en el Proceso Electoral Local Ordinario 2027.
                        </p>
                        <div class="footer" style="margin-top:30px;border-top:1px solid #e5e5e5;padding-top:15px;text-align:center;color:#777777;font-size:12px;line-height:1.6;">
                            <strong>Instituto de Elecciones y Participación Ciudadana</strong>
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
