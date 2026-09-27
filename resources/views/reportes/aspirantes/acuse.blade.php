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
                        {{ $folio_registro }}
                    </span>
                    </div>

                </td>
            </tr>
        </table>
    </div>
    <!-- FOOTER -->
    <div id="footer">
        Instituto de Elecciones y Participación Ciudadana<br>
        Periférico Sur Poniente #2185, Col. Penipak, Tuxtla Gutiérrez, Chiapas, C.P. 29060<br>
        Conmutador: (961) 264 00 20 al 23 | Lada sin costo: 01800 050 IEPC (4372)<br>
        capacitacion@iepc-chiapas.org.mx
    </div>
    <!-- MARCA AGUA -->
    <div class="watermark">
        <img src="{{ public_path('imagenes/recurso1.png') }}" width="620">
    </div>
    <!-- CONTENIDO -->
    <div class="titulo">
        SOLICITUD DE REGISTRO ELECTRÓNICO
    </div>
    <div class="contenido">
        <p>
            <b>Fecha de registro:</b>
            {{ $fecha_creacion_final }}
            <br>
            <b>Hora:</b>
            {{ $hora_creacion_final.' hrs' }}
        </p>
        <br>
        <p>
            Estimada(o) <b>{{ $nombre }}</b> has completado tu solicitud de registro como aspirante a <b> Coordinador(a) del Consejo </b>
            <b>
                {{ $distrital_municipal }}
                {{ $descripcion_distrito_municipio }}
            </b>
            para el Proceso Electoral Local Ordinario 2027.
        </p>
        <p>
            Por lo anterior, con base en lo dispuesto en los lineamientos para el reclutamiento, selección y contratación de las personas aspirantes del Instituto de Elecciones y Participación Ciudadana, en caso de que se omita adjuntar alguno o algunos de los archivos comprobatorios solicitados, se le requerirá a través del correo electrónico registrado, para que dentro del término establecido subsane la omisión correspondiente.
        </p>
        <p>
            Una vez requisitada la solicitud de registro y validados los documentos digitalizados, el sistema generará la constancia correspondiente, misma que contendrá tus datos y el número de folio que te acreditará como inscrita o inscrito en el procedimiento de selección.
        </p>
        <p>
            Las y los aspirantes que resulten seleccionados deberán presentar sus documentos originales para cotejo ante las áreas correspondientes del Instituto; posteriormente deberán entregar la documentación requerida para su contratación.
        </p>
        <p>
            Será indispensable presentar también la documentación fiscal correspondiente, incluyendo el Registro Federal de Contribuyentes (RFC) con homoclave expedido por el Servicio de Administración Tributaria (SAT).
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
    </div>
</body>
</html>
