<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            padding: 6px;
            border: 1px solid #ccc;
        }

        th {
            background: #f5f5f5;
            text-align: left;
        }

        .section-title {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Reporte de Ticket</h1>

<table>
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
        <td>{{ $ticket->client_email }}</td>
    </tr>
    <tr>
        <th>Responsable</th>
        <td>{{ $ticket->owner_name }}</td>
    </tr>
    <tr>
        <th>Ubicación</th>
        <td>{{ $ticket->location }}</td>
    </tr>
    <tr>
        <th>Estado</th>
        <td>{{ ucfirst($ticket->status) }}</td>
    </tr>
</table>

<div class="section-title">Descripción del problema</div>
<p>{{ $ticket->problem_description }}</p>

<div class="section-title">Solución aplicada</div>
<p>{{ $ticket->solution_applied }}</p>

<div class="section-title">Observaciones</div>
<p>{{ $ticket->observations }}</p>

<div class="section-title">Personal de soporte</div>
<ul>
    @foreach ($ticket->supportStaff as $staff)
        <li>{{ $staff->name }}</li>
    @endforeach
</ul>

</body>
</html>
