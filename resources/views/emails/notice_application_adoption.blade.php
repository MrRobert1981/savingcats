<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Notificación</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f7f7f7;">
    <table width="100%" bgcolor="#f7f7f7" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="600" align="center" cellpadding="40" cellspacing="0" bgcolor="#ffffff"
                    style="margin: 30px auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h1 style="margin: 0; color: #333333;">🐾 {{ $title }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #555555; font-size: 16px; line-height: 1.6;">
                            <p>Hola <strong>{{ $recipient_name }}</strong>,</p>
                            <p>{{ $body_message }}</p>
                            <p>Si necesitas más información, no dudes en contactarnos.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 30px;">
                            <a href="{{ url('/') }}"
                                style="background-color: #4CAF50; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">Visitar
                                el sitio</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 40px; font-size: 12px; color: #999999;" align="center">
                            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>