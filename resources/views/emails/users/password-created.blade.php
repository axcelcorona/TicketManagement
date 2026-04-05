<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de acceso</title>
</head>
<body style="margin:0;padding:0;background:#eef3f8;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;color:#18212f;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#eef3f8;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border:1px solid #dbe4ee;border-radius:18px;overflow:hidden;">
                <tr>
                    <td style="padding:30px 32px;background:linear-gradient(135deg,#0f172a,#1d4ed8);color:#f8fafc;">
                        <div style="font-size:12px;letter-spacing:1.4px;text-transform:uppercase;opacity:.82;">
                            {{ config('app.name') }}
                        </div>
                        <h1 style="margin:10px 0 0;font-size:26px;line-height:1.25;font-weight:800;">
                            Tus credenciales de acceso ya estan listas
                        </h1>
                        <p style="margin:12px 0 0;font-size:14px;line-height:1.7;color:rgba(248,250,252,.88);">
                            Se ha creado o actualizado tu acceso al panel. Debajo encontraras los datos para ingresar.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:28px 32px 10px;">
                        <p style="margin:0 0 14px;font-size:15px;line-height:1.7;">
                            Hola <strong>{{ $user->name }}</strong>,
                        </p>
                        <p style="margin:0 0 18px;font-size:15px;line-height:1.7;color:#475569;">
                            Guarda este correo temporalmente y usa estas credenciales para entrar al sistema.
                        </p>

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;border:1px solid #dbe4ee;border-radius:14px;">
                            <tr>
                                <td style="padding:18px 20px;border-bottom:1px solid #e2e8f0;">
                                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:6px;">Correo de acceso</div>
                                    <div style="font-size:16px;font-weight:700;color:#0f172a;">{{ $user->email }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:18px 20px;">
                                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:6px;">Contrasena temporal</div>
                                    <div style="font-size:22px;font-weight:800;letter-spacing:.5px;color:#0f172a;">{{ $plainPassword }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:10px 32px 0;">
                        @if ($mustChangePassword)
                            <div style="background:#fff7ed;border:1px solid #fdba74;border-radius:14px;padding:16px 18px;">
                                <div style="font-size:12px;font-weight:800;letter-spacing:.8px;text-transform:uppercase;color:#c2410c;margin-bottom:6px;">
                                    Accion requerida
                                </div>
                                <div style="font-size:14px;line-height:1.7;color:#9a3412;">
                                    Debes cambiar esta contrasena en tu primer ingreso antes de continuar usando el panel.
                                </div>
                            </div>
                        @else
                            <div style="background:#ecfdf5;border:1px solid #86efac;border-radius:14px;padding:16px 18px;">
                                <div style="font-size:12px;font-weight:800;letter-spacing:.8px;text-transform:uppercase;color:#15803d;margin-bottom:6px;">
                                    Acceso habilitado
                                </div>
                                <div style="font-size:14px;line-height:1.7;color:#166534;">
                                    Puedes ingresar con esta contrasena y cambiarla mas adelante si lo deseas.
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 32px 18px;">
                        <a href="{{ url('/admin') }}"
                           style="display:inline-block;background:#0f172a;color:#ffffff;text-decoration:none;font-size:14px;font-weight:700;padding:13px 18px;border-radius:12px;">
                            Ir al panel
                        </a>
                        <p style="margin:14px 0 0;font-size:13px;line-height:1.7;color:#64748b;">
                            Si el boton no funciona, copia y pega esta direccion en tu navegador:<br>
                            <span style="color:#1d4ed8;">{{ url('/admin') }}</span>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 32px 26px;">
                        <div style="border-top:1px solid #e2e8f0;padding-top:18px;font-size:13px;line-height:1.7;color:#64748b;">
                            Por seguridad, evita compartir esta contrasena por otros medios y elimina este correo cuando ya no lo necesites.
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 32px;background:#f8fafc;border-top:1px solid #e2e8f0;">
                        <p style="margin:0;font-size:12px;line-height:1.6;color:#6b7280;">
                            Este es un mensaje automatico de {{ config('app.name') }}.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
