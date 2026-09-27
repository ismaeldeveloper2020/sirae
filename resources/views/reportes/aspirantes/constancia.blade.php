<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin-top: 185px;
            margin-right: 40px;
            margin-bottom: 95px;
            margin-left: 40px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.45;
        }
        /* HEADER */
        #header {
            position: fixed;
            top: -175px;
            left: 0;
            right: 0;
            height: 120px;
        }
        /* FOOTER */
        #footer {
            position: fixed;
            bottom: -75px;
            left: 0;
            right: 0;
            background: #e22275;
            color: white;
            text-align: center;
            font-size: 8px;
            padding: 5px;
            line-height: 1.4;
            border-radius: 10px;
        }
        .folio {
            background: #e22275;
            color: white;
            display: inline-block;
            text-align: center;
            font-size: 16px;
            padding:4px 15px;
            line-height: 1.4;
            border-radius: 10px;
            margin-top:2px;
        }
        /* MARCA AGUA */
        .watermark {
            position: fixed;
            top: 220px;
            left: 70px;
            opacity: .8;
            z-index: -1;
        }
        /* TITULO */
        .titulo {
            text-align: center;
            font-size: 24px;
            font-weight: normal;
            color: #222;
            margin-bottom: 35px;
        }
        /* CONTENIDO */
        .contenido {
            text-align: justify;
            font-size: 10.5px;
            line-height: 1.25;
        }
        p {
            text-align:justify;
            margin-bottom:10px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div id="header">
        <table width="100%">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('imagenes/iepc2.png') }}" width="220">
                </td>
                <td width="40%" align="center">
                    <div style="
                        margin-top: 20px;
                        font-size:14px;
                        font-weight:bold;
                        color:#1f2937;
                        line-height:1.3;
                    ">
                        INSTITUTO DE ELECCIONES Y PARTICIPACIÓN CIUDADANA
                    </div>
                    <div style="
                        width:90px;
                        height:2px;
                        background:#e22275;
                        margin:6px auto;
                    ">
                    </div>
                    <div style="
                        font-size:10px;
                        color:#64748b;
                        font-weight:bold;
                        line-height:1.4;
                    ">
                        PROCESO ELECTORAL LOCAL ORDINARIO 2027
                    </div>
                </td>
                <td width="30%" align="right">
                     <div style="
                      margin-top: 20px;
                        font-size:10px;
                        color:#64748b;
                        font-weight:bold;
                        line-height:1.4;
                    ">
                                           <b>
                        FOLIO DE REGISTRO
                    </b>
                    <br>
                    <span class="folio">
                        {{ $datos->folio }}
                    </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <!-- FOOTER -->
    <div id="footer">
        Instituto de Elecciones y Participación Ciudadana<br>
        Periférico Sur Poniente #2185, Col. Penipak, Tuxtla Gutiérrez, Chiapas<br>
        Conmutador: (961) 264 00 20 al 23<br>
        capacitacion@iepc-chiapas.org.mx
    </div>
    <!-- MARCA AGUA -->
    <div class="watermark">
        <img src="{{ public_path('imagenes/recurso1.png') }}" width="620">
    </div>
    <!-- CONTENIDO -->
    <div class="titulo">
        CONSTANCIA DE REGISTRO
    </div>
    <div class="contenido">
        <p style="text-align:center;">
            <b>
                C. {{ $datos->nombre }}
                {{ $datos->apaterno }}
                {{ $datos->amaterno }}
            </b>
            <br>
            <b>
                Aspirante a enlace del consejo {{ $tipoConsejo." de ".$descripcion_distrito_municipio}}
            </b>
            <br>
            <b>
                P R E S E N T E
            </b>
        </p>
        <p>
            De conformidad con lo dispuesto en los Lineamientos del Instituto de Elecciones y Participación Ciudadana para el reclutamiento, selección, contratación y funcionamiento de las personas enlaces distritales y municipales para el Proceso Electoral Local Ordinario 2024, y toda vez que ha cumplido con los requisitos establecidos, se expide la presente:
        </p>
        <p style="text-align:center;font-size:16px;">
            <b>
                CONSTANCIA DE REGISTRO
            </b>
        </p>
        <p>
            Que acredita al aspirante para participar en el procedimiento de selección de las personas enlaces distritales y municipales del Instituto de Elecciones y Participación Ciudadana para el Proceso Electoral Local Ordinario 2024.
        </p>
        <p>
            El presente documento contiene el folio asignado al registro electrónico,
            mismo que permitirá identificar la participación dentro del procedimiento correspondiente.
        </p>
        <p>
            En caso de requerir más información, comunicarse a los teléfonos:
            961 247 43 57,
            961 580 13 52,
            961 290 99 55 y
            961 297 80 57
            o al correo:
            capacitacion@iepc-chiapas.org.mx
            Horario de atención:
            Lunes a viernes de 09:00 a 16:00 horas y sábados de 09:00 a 14:00 horas.
        </p>
<div style="
    margin-top:20px;
    text-align:center;
">

    <img 
        src="{{ $codigoQR }}"
        style="
            width:150px;
            height:150px;
        "
    >

    <br>

    <span style="
        font-size:9px;
        color:#666;
    ">
        Validación electrónica
    </span>

</div>
        <div style="margin-top:35px; text-align:center; font-size:11px;">
            <b>
                Validado por:
            </b>
            <br><br>
            Dirección Ejecutiva de Educación Cívica y Capacitación.
        </div>
</body>
</html>
