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

            /*margin: 145px 40px 95px 40px;*/
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #334155;
            line-height: 1.4;
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
            color: #ffffff;
            text-align: center;
            font-size: 8px;
            padding: 5px;
            line-height: 1.4;
            border-radius: 10px;
        }
        /* MARCA DE AGUA */
        .watermark {
            position: fixed;
            top: 160px;
            left: 70px;
            opacity: 1;
            z-index: -1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
        /* TITULOS DE SECCION */
        .seccion {

            margin-top: 18px;
            color: #e22275;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            padding: 8px;

            border-left: 2px solid #e22275;
            border-right: 1px solid #e2e2e2;
            border-top: 1px solid #e2e2e2;
            border-bottom: 1px solid #e2e2e2;

            border-radius: 3px;

            /* evita que el título quede solo al final de página */
            page-break-after: avoid;
        }
        .primera {
            margin-top: -2px;
        }

        .bloque {

            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 10px;
            margin-top: 6px;

            /* evita cortes feos al cambiar página */
            page-break-inside: avoid;
        }

        .campo {
            border-bottom: 1px solid #cbd5e1;
            min-height: 18px;
            text-align: center;
            font-weight: bold;
            color: #371f35;
        }
        .label {
            text-align: center;
            color: #e22275;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .tabla {
            margin-top: 8px;
        }
        .tabla th {
            background: #fcfafa;
            color: #e22275;
            border: 1px solid #6b696a;
            padding: 7px;
            font-size: 10px;
            text-align: center;
        }
        .tabla td {
            border: 1px solid #e5e7eb;
            padding: 6px;
        }
        .tabla tr:nth-child(even) {
            
        }

        .tabla thead {
            display: table-header-group;
        }

        .tabla-documentos{
    width:100%;
    margin-top:15px;
    border-collapse:collapse;
}

.tabla-documentos th{
    background:#e22275;
    color:#ffffff;
    border:1px solid #c2185b;
    padding:10px;
    text-align:center;
    font-size:11px;
    font-weight:bold;
}

.tabla-documentos td{
    border:1px solid #d9d9d9;
    padding:10px;
    vertical-align:top;
    font-size:11px;
    color:#333333;
}

.tabla-documentos tbody tr:nth-child(even){
    /*background:#fafafa;*/
}
    </style>
</head>
<body>
    <div id="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none !important;">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('imagenes/iepc2.png') }}" width="180">
                </td>
                <td align="center">
                    <b>
                        INSTITUTO DE ELECCIONES Y PARTICIPACIÓN CIUDADANA
                    </b>
                    <br>
                    <span>
                        PROCESO ELECTORAL LOCAL ORDINARIO 2027
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <div id="footer">
        Instituto de Elecciones y Participación Ciudadana<br>
        Periférico Sur Poniente #2185, Col. Penipak, Tuxtla Gutiérrez, Chiapas, C.P. 29060<br>
        Conmutador: (961) 264 00 20 al 23 | Lada sin costo: 01800 050 IEPC (4372)<br>
        capacitacion@iepc-chiapas.org.mx
    </div>
        <!-- MARCA DE AGUA -->
    <div class="watermark">
        <img src="{{ public_path('imagenes/recurso1.png') }}" width="620">
    </div>
    <div class="titulo">
        REQUERIMIENTO DE DOCUMENTACIÓN
    </div>
    <div class="info">
        <b>Aspirante:</b>
        {{ $usuario->nombre }}
        {{ $usuario->apaterno }}
        {{ $usuario->amaterno }}
        <br><br>
        <b>Fecha:</b>
        {{ $fecha->format('d/m/Y') }}
    </div>
    <p>
        Durante la revisión de la documentación presentada se detectaron
        las siguientes observaciones:
    </p>
<table class="tabla-documentos">
    <thead>
        <tr>
            <th width="30%">Documento</th>
            <th width="70%">Observación</th>
        </tr>
    </thead>

    <tbody>
        @foreach($documentos as $doc)
            <tr>
                <td>
                    <strong>{{ $doc->documento }}</strong>
                </td>
                <td>
                    {{ $doc->observacion }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    <br>
    <p>
        Favor de atender las observaciones señaladas para continuar con el proceso de validación.
    </p>
</body>
</html>
