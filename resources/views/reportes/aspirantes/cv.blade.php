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
            top: 220px;
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
    </style>
</head>
<body>
    <!-- HEADER -->
    <div id="header">
        <table width="100%">
            <tr>
                <td width="30%" valign="middle">
                    <img src="{{ public_path('imagenes/iepc2.png') }}"
                         style="width:220px;">
                </td>
                <td width="40%" align="center" style="padding-top: 6%;">
                    <div style="
   
                        font-size:18px;
                        font-weight:bold;
                        color:#1f2937;
                        letter-spacing:1px;
                    ">
                        CURRÍCULUM VITAE
                    </div>
                    <div style="
                        width:120px;
                        height:3px;
                        background:#e22275;
                        margin:6px auto;
                    ">
                    </div>
                    <div style="
                  
                        margin-bottom : 4%;
                        font-size:12px;
                        color:#64748b;
                    ">
                        Información curricular de la persona aspirante
                    </div>
                </td>
                <td width="30%" align="right" style="padding-top: 6%;">
                    <div style="
                        font-size:14px;
                        font-weight:bold;
                        color:#334155;
                    ">
                        PROCESO ELECTORAL
                    </div>
                    <div style="
                        font-size:12px;
                        font-weight:bold;
                        color:#e22275;
                    ">
                        LOCAL ORDINARIO 2027
                    </div>
                </td>
            </tr>
        </table>
         <!--
        <div style="
            margin-top:1px;
            border-bottom:0px solid #e22275;
        ">
        </div>-->
    </div>
    <!-- FOOTER -->
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
    <!-- DATOS PERSONALES -->
    <div class="seccion primera">
        DATOS PERSONALES
    </div>
    <div class="bloque">
        <table>
            <tr>
                <td colspan="1">
                    <div class="campo">
                        {{$datos->nombre}}
                    </div>
                    <div class="label">
                        Nombre
                    </div>
                </td>

                <td colspan="1"> 
                    <div class="campo">
                        {{$datos->apaterno}}
                    </div>
                    <div class="label">
                        Primer apellido
                    </div>
                </td>

                <td colspan="1">
                    <div class="campo">
                        {{$datos->amaterno}}
                    </div>
                    <div class="label">
                        Segundo apellido
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    <div class="campo">
                        {{$datos->curp ?? ''}}
                    </div>
                    <div class="label">
                        CURP
                    </div>
                </td>
                <td colspan="1">
                    <div class="campo">
                        {{$datos->rfc."-".$datos->homoclave ?? ''}}
                    </div>
                    <div class="label">
                        RFC
                    </div>
                </td>
                <td colspan="1">
                    <div class="campo">
                        {{$datos->clave_elector ?? ''}}
                    </div>
                    <div class="label">
                        Clave de elector
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <div class="campo">
                        {{$datos->licencia}}
                    </div>
                    <div class="label">
                        Tipo de licencia
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->fecha_nacimiento ?? ''}}
                    </div>
                    <div class="label">
                        Fecha de nacimiento
                    </div>
                </td>

                <td>
                    <div class="campo">
                        {{$datos->genero}}
                    </div>
                    <div class="label">
                        Sexo
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->edad ?? ''}}
                    </div>
                    <div class="label">
                        Edad
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="campo">
                        {{$datos->discapacidad ?? ''}}
                    </div>
                    <div class="label">
                        Discapcidad
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->telefono_casa ?? ''}}
                    </div>
                    <div class="label">
                        Teléfono de casa
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->telefono_movil ?? ''}}
                    </div>
                    <div class="label">
                        Teléfono celular
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->email}}
                    </div>
                    <div class="label">
                        Correo electrónico
                    </div>
                </td>
            </tr>
            <tr>

                <td>
                    <div class="campo">
                        {{$datos->etnia ?? ''}}
                    </div>
                    <div class="label">
                         Autoadscripción indígena
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->idioma_predominante}}
                    </div>
                    <div class="label">
                        Lengua predominante
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->otro_idioma ?? ''}}
                    </div>
                    <div class="label">
                       Otra lengua
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->ocupacion_actual ?? ''}}
                    </div>
                    <div class="label">
                        Ocupación actual
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <!-- DOMICILIO -->
    <div class="seccion">
        DOMICILIO
    </div>
    <div class="bloque">
        <table>
            <tr>
                <td>
                    <div class="campo">
                        {{$datos->calle ?? ''}}
                    </div>
                    <div class="label">
                        Calle
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->colonia ?? ''}}
                    </div>
                    <div class="label">
                        Colonia
                    </div>
                </td>
                <td>
                    <div class="campo">
                         {{ $datos->num_casa_exterior ?? 's/n' }}
                    </div>
                    <div class="label">
                        Número exterior
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{ $datos->num_casa_interior ?? 's/n' }}
                    </div>
                    <div class="label">
                        Número interior
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="campo">
                        {{$datos->municipio_nacio ?? ''}}
                    </div>
                    <div class="label">
                        Municipio
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->estado ?? ''}}
                    </div>
                    <div class="label">
                        Estado
                    </div>
                </td>
                <td>
                    <div class="campo">
                        {{$datos->cp ?? ''}}
                    </div>
                    <div class="label">
                        Código postal
                    </div>
                </td>
            </tr>
        </table>
    </div>
        <!-- FORMACIÓN ACADÉMICA -->
    <div class="seccion">
        FORMACIÓN ACADÉMICA
    </div>
    <div class="bloque">
        <table class="tabla">
            <tr>
                <th>
                    Nivel
                </th>
                <th>
                    Carrera
                </th>
                <th>
                    Estatus
                </th>
            </tr>
            @foreach($pad_datos_academicos as $a)
            <tr>
                <td>
                    {{$a->nivel_estudio}}
                </td>
                <td>
                    {{filled($a->otra_carrera)
                    ? $a->otra_carrera
                    : ($a->carrera ?? '')}}
                </td>
                <td>
                    {{$a->estatus_nivel_estudio}}
                </td>
            </tr>
            @endforeach
        </table>
        <table class="tabla" style="margin-top: 20px;">
            <tr>
                <th>
                    Estudios de posgrado
                </th>
                <th>
                    Posgrado
                </th>
                <th>
                    Estatus
                </th>
            </tr>
            @foreach($pad_datos_academicos as $a)
            <tr>
                <td>
                    {{$a->nivel_posgrado}}
                </td>
                <td>
                    {{$a->posgrado}}
                </td>
                <td>
                    {{$a->estatus_otros_estudios}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- EXPERIENCIA LABORAL -->
    <div class="seccion">
        EXPERIENCIA LABORAL
    </div>
    <div class="bloque">
        <table class="tabla">
            <tr>
                <th>
                    Giro
                </th>
                <th>
                    Institución
                </th>
                <th>
                    Puesto
                </th>
                <th>
                    Periodo
                </th>
            </tr>
            @foreach($pad_experiencias_laboral as $e)
            <tr>
                <td>
                    {{$e->giro}}
                </td>
                <td>
                    {{$e->institucion_el}}
                </td>
                <td>
                    {{$e->puesto_el}}
                </td>
                <td>
                    {{$e->periodo_el}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- EXPERIENCIA ELECTORAL -->
    <div class="seccion">
        EXPERIENCIA ELECTORAL
    </div>
    <div class="bloque">
        <table class="tabla">
            <tr>
                <th>
                    Cargo
                </th>
                <th>
                    Institución
                </th>
                <th>
                    Periodo
                </th>
            </tr>
            @foreach($pad_experiencias_electoral as $e)

            <tr>
                <td>
                    {{filled($e->descripcion_otro_cargo_ee)
                        ? $e->descripcion_otro_cargo_ee
                        : ($e->cargo_ocupado ?? '')}}
                </td>

                <td>
                    {{filled($e->descripcion_otro_institucion_ee)
                        ? $e->descripcion_otro_institucion_ee
                        : ($e->instituto ?? '')}}
                </td>

                <td>
                    {{ filled($e->periodo_ee ?? null) ? $e->periodo_ee : ($e->periodo ?? '') }}
                </td>
            </tr>

            @endforeach
    </div>
        <!-- CONOCIMIENTOS ELECTORALES -->
    <div class="seccion">
        CONOCIMIENTOS ELECTORALES
    </div>
    <div class="bloque">
        <table class="tabla">
            <tr>
                <th>
                    Conocimiento
                </th>
                <th>
                    Institución
                </th>
                <th>
                    Periodo
                </th>
            </tr>
            @foreach($pad_conocimientos_electoral as $c)
            <tr>
                <td>
                    {{
                        $c->id_tipo_ce == 9
                        ? $c->otro_ce
                        : $c->conocimiento
                    }}
                </td>
                <td>
                    {{$c->institucion_ce}}
                </td>
                <td>
                    {{$c->periodo_ce}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- EXPERIENCIA DOCENTE -->
    <div class="seccion">
        EXPERIENCIA DOCENTE
    </div>
    <div class="bloque">
        <table class="tabla">
            <tr>
                <th>
                    Descripción
                </th>
            </tr>
            @foreach($pad_trayectorias as $t)
            <tr>
                <td style="text-align: justify;">
                    {{$t->descripcion_docente}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
