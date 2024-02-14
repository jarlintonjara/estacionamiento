<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inchcape</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table cellpadding="0" cellspacing="0" border="0" width="100%"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 5px; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 20px;">
                <h1 style="color: #333333;">¡Gracias por Reservar!</h1>

                <table cellspacing="0" cellpadding="0" border="0" align="center" style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">Sede</td>
                        {{-- <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">{{ $reserva['sede']['name'] }}</td> --}}
                    </tr>
                    <tr>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">Estacionamiento</td>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">{{ $reserva['parking']['numero']  }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">Fecha</td>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">{{ $reserva['fecha'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">Horario</td>
                        <td style="padding: 20px; border: 1px solid #cccccc; text-align: center;">{{ $reserva['hora_inicio'] }} - {{ $reserva['hora_fin'] }}</td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>

</body>

</html>
