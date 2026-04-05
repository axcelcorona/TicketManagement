<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencia Cerrada</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f6fb;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;color:#1f2937;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f3f6fb;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="padding:28px 32px;background:linear-gradient(135deg,#14532d,#166534);color:#f0fdf4;">
                        <div style="font-size:12px;letter-spacing:1.2px;text-transform:uppercase;opacity:.85;">Ticket Management</div>
                        <h1 style="margin:10px 0 0;font-size:24px;line-height:1.35;font-weight:700;">Incidencia cerrada correctamente</h1>
                    </td>
                </tr>

                <tr>
                    <td style="padding:26px 32px 8px;">
                        <p style="margin:0 0 14px;font-size:15px;line-height:1.65;">
                            Hola{{ $ticket->client_name ? ' ' . e($ticket->client_name) : '' }},
                        </p>
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.65;color:#374151;">
                            Te informamos que la incidencia fue cerrada. Adjuntamos el PDF con el detalle completo del caso.
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
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Tipo de visita</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ $ticket->visitType?->name ?: 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Estado</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">Cerrado</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#64748b;">Fecha de cierre</td>
                                <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px;color:#111827;">{{ $ticket->end_time ? \Carbon\Carbon::parse($ticket->end_time)->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 32px 30px;">
                        <p style="margin:0;font-size:14px;line-height:1.7;color:#4b5563;">
                            En el adjunto encontraras el reporte PDF del incidente <strong>{{ $referenceNumber }}</strong>.
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
