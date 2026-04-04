<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->id }}</title>

    <style>
        @page {
            margin: 12px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2937;
            margin: 0;
            line-height: 1.3;
        }

        .page {
            min-height: 267mm;
        }

        .header {
            border-bottom: 2px solid #111827;
            padding-bottom: 8px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            color: #111827;
            letter-spacing: 0.3px;
        }

        .subtitle {
            margin-top: 3px;
            color: #4b5563;
            font-size: 9px;
        }

        .meta {
            margin-top: 6px;
            font-size: 8px;
            color: #6b7280;
        }

        .reference-card {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 7px 10px;
            margin-bottom: 10px;
            background: #f9fafb;
            page-break-inside: avoid;
        }

        .reference {
            font-size: 12px;
            font-weight: 700;
            color: #111827;
            margin-top: 2px;
        }

        .content {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            table-layout: fixed;
        }

        .content td {
            vertical-align: top;
            width: 50%;
            padding: 0;
        }

        .panel {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 8px;
            min-height: 222mm;
            box-sizing: border-box;
        }

        .section-title {
            margin: 0 0 5px;
            font-size: 10px;
            font-weight: 700;
            color: #111827;
            border-left: 3px solid #111827;
            padding-left: 6px;
            page-break-after: avoid;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            page-break-inside: avoid;
        }

        .data-table th,
        .data-table td {
            padding: 5px 6px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        .data-table th {
            width: 28%;
            background: #f3f4f6;
            text-align: left;
            color: #374151;
            font-weight: 700;
        }

        .text-block {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 6px;
            min-height: 34px;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .text-block p {
            margin: 0;
        }

        .support-list {
            margin: 0;
            padding-left: 16px;
            page-break-inside: avoid;
        }

        .support-list li {
            margin-bottom: 3px;
        }

        .footer {
            margin-top: 12px;
            font-size: 8px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

@php
    $reference = 'INC-' . str_pad((string) $ticket->id, 6, '0', STR_PAD_LEFT);
@endphp

<div class="page">
    <div class="header">
        <p class="title">Reporte de Incidencia</p>
        <p class="subtitle">Ticket Management - Documento de seguimiento tecnico</p>
        <p class="meta">Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="reference-card">
        <div>Numero de referencia</div>
        <div class="reference">{{ $reference }}</div>
    </div>

    <table class="content">
        <tr>
            <td>
                <div class="panel">
                    <div class="section-title">Informacion General</div>
                    <table class="data-table">
                        <tr>
                            <th>ID</th>
                            <td>{{ $ticket->id }}</td>
                        </tr>
                        <tr>
                            <th>Cliente</th>
                            <td>{{ $ticket->client_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $ticket->client_email ?: 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <th>Responsable</th>
                            <td>{{ $ticket->owner_name ?: 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <th>Ubicacion</th>
                            <td>{{ $ticket->location ?: 'No especificada' }}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>{{ ucfirst($ticket->status) }}</td>
                        </tr>
                        <tr>
                            <th>Tipo de visita</th>
                            <td>{{ $ticket->visitType?->name ?: 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de llamada</th>
                            <td>{{ $ticket->call_time ? \Carbon\Carbon::parse($ticket->call_time)->format('d/m/Y H:i') : 'No especificada' }}</td>
                        </tr>
                        <tr>
                            <th>Inicio de atencion</th>
                            <td>{{ $ticket->start_time ? \Carbon\Carbon::parse($ticket->start_time)->format('d/m/Y H:i') : 'No especificada' }}</td>
                        </tr>
                        <tr>
                            <th>Fin de atencion</th>
                            <td>{{ $ticket->end_time ? \Carbon\Carbon::parse($ticket->end_time)->format('d/m/Y H:i') : 'No especificada' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td>
                <div class="panel">
                    <div class="section-title">Descripcion del problema</div>
                    <div class="text-block"><p>{{ $ticket->problem_description ?: 'Sin detalle registrado.' }}</p></div>

                    <div class="section-title">Solucion aplicada</div>
                    <div class="text-block"><p>{{ $ticket->solution_applied ?: 'Sin solucion registrada.' }}</p></div>

                    <div class="section-title">Observaciones</div>
                    <div class="text-block"><p>{{ $ticket->observations ?: 'Sin observaciones.' }}</p></div>

                    <div class="section-title">Personal de soporte</div>
                    @if ($ticket->supportStaff->isNotEmpty())
                        <ul class="support-list">
                            @foreach ($ticket->supportStaff->take(8) as $staff)
                                <li>{{ $staff->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-block"><p>No se asigno personal de soporte.</p></div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <p class="footer">
        Documento emitido automaticamente por Ticket Management. Para consultas, mencionar la referencia <strong>{{ $reference }}</strong>.
    </p>
</div>

</body>
</html>
