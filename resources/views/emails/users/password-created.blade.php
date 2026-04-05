<p>Hola {{ $user->name }},</p>

<p>Se ha creado o actualizado tu acceso al sistema.</p>

<p><strong>Correo:</strong> {{ $user->email }}</p>
<p><strong>Contrasena temporal:</strong> {{ $plainPassword }}</p>

@if ($mustChangePassword)
<p>Debes cambiar esta contrasena en tu primer ingreso.</p>
@else
<p>Puedes ingresar con esta contrasena y cambiarla luego si lo deseas.</p>
@endif

<p>Accede desde: {{ url('/admin') }}</p>
