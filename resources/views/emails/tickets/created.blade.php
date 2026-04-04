<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencia Creada</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f6fb;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;color:#1f2937;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f3f6fb;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="padding:28px 32px;background:linear-gradient(135deg,#0f172a,#1e293b);color:#f8fafc;">
                        <div style="font-size:12px;letter-spacing:1.2px;text-transform:uppercase;opacity:.85;">Ticket Management</div>
                        <h1 style="margin:10px 0 0;font-size:24px;line-height:1.35;font-weight:700;">Incidencia registrada correctamente</h1>
                    </td>
                </tr>

                <tr>
                    <td style="padding:26px 32px 8px;">
                        <p style="margin:0 0 14px;font-size:15px;line-height:1.65;">
                            Hola{{ $ticket->client_name ? ' ' . e($ticket->client_name) : '' }},
                        </p>
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.65;color:#374151;">
                            Te confirmamos que hemos creado tu incidencia en el sistema. A continuacion compartimos el numero de referencia y el resumen del caso.
                        </p>

                        <table role="presentation" cellspacing="0" cellpadding="0" style="width:100%;margin:18px 0;background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;">
                            <tr>
                                <td style="padding:16px 18px;">
                                    <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.8px;margin-bottom:6px;">Numero de referencia</div>
                                    <div style="font-size:22px;font-weight:800;color:#0f172a;letter-spacing:.5px;">{{ $referenceNumber }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 32px 20px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;width:34%;">Cliente</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ $ticket->client_name ?: 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Responsable</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ $ticket->owner_name ?: 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Tipo de visita</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ $ticket->visitType?->name ?: 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Ubicacion</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ $ticket->location ?: 'No especificada' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Fecha de creacion</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ optional($ticket->created_at)->format('d/m/Y H:i') ?: 'No disponible' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 32px 24px;">
                        <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:14px 16px;">
                            <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.8px;margin-bottom:8px;">Descripcion del problema</div>
                            <div style="font-size:14px;line-height:1.65;color:#1f2937;">
                                {{ $ticket->problem_description ?: 'No especificada' }}
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 32px 30px;">
                        <p style="margin:0;font-size:14px;line-height:1.7;color:#4b5563;">
                            Conserva este correo para futuras consultas y menciona siempre el numero de referencia <strong>{{ $referenceNumber }}</strong>.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 32px;background:#f8fafc;border-top:1px solid #e5e7eb;">
                        <p style="margin:0;font-size:12px;line-height:1.6;color:#6b7280;">
                            Este es un mensaje automatico de Ticket Management.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
