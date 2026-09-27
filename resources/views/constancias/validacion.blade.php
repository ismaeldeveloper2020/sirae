<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Validación de Constancia</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .contenedor {
            max-width: 650px;
            margin: 50px auto;
        }

        .tarjeta {
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0,0,0,.12);
        }

        .encabezado {
            text-align: center;
            margin-bottom: 30px;
        }

        .icono {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
        }

        .valida {
            background: #198754;
        }

        .invalida {
            background: #dc3545;
        }

        h1 {
            margin: 0;
            font-size: 27px;
        }

        .valida-texto {
            color: #198754;
        }

        .invalida-texto {
            color: #dc3545;
        }

        .mensaje {
            margin-top: 10px;
            color: #666;
        }

        .datos {
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .fila {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .valor {
            text-align: right;
            color: #222;
        }

        .motivo {
            margin-top: 25px;
            padding: 15px;
            border-radius: 8px;
            background: #f8d7da;
            color: #842029;
        }

        .pie {
            margin-top: 25px;
            text-align: center;
            color: #777;
            font-size: 13px;
        }

        @media(max-width: 600px) {
            .tarjeta {
                padding: 25px 20px;
            }

            .fila {
                flex-direction: column;
                gap: 4px;
            }

            .valor {
                text-align: left;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <div class="tarjeta">

        <div class="encabezado">

            @if($valida)

                <div class="icono valida">
                    ✓
                </div>

                <h1 class="valida-texto">
                    Constancia válida
                </h1>

                <div class="mensaje">
                    La constancia ha sido verificada correctamente.
                </div>

            @else

                <div class="icono invalida">
                    ✕
                </div>

                <h1 class="invalida-texto">
                    Constancia no válida
                </h1>

                <div class="mensaje">
                    {{ $mensaje }}
                </div>

            @endif

        </div>


        @if($constancia)

            <div class="datos">

                <div class="fila">
                    <span class="label">
                        Folio
                    </span>

                    <span class="valor">
                        {{ $constancia->folio }}
                    </span>
                </div>

                <div class="fila">
                    <span class="label">
                        Nombre
                    </span>

                    <span class="valor">
                        {{ $constancia->nombre }}
                    </span>
                </div>

                <div class="fila">
                    <span class="label">
                        Tipo de enlace
                    </span>

                    <span class="valor">
                        {{ $constancia->tipo_enlace }}
                    </span>
                </div>

                <div class="fila">
                    <span class="label">
                        Distrito / Municipio
                    </span>

                    <span class="valor">
                        {{ $constancia->distrito_municipio }}
                    </span>
                </div>

                <div class="fila">
                    <span class="label">
                        Fecha de emisión
                    </span>

                    <span class="valor">
                        {{ \Carbon\Carbon::parse($constancia->fecha_emision)->format('d/m/Y H:i') }}
                    </span>
                </div>

            </div>


            @if($constancia->estatus != 1 && $constancia->motivo)

                <div class="motivo">

                    <strong>
                        Motivo de invalidez:
                    </strong>

                    <br>

                    {{ $constancia->motivo }}

                </div>

            @endif

        @endif


        <div class="pie">
            Validación electrónica de constancia
        </div>

    </div>

</div>

</body>
</html>
