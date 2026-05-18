<?php
require 'conexion.php';
$mensaje = "";
$tipo_alerta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validar si el correo o cédula ya existen
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ? OR cedula = ?");
    $stmt->execute([$correo, $cedula]);
    
    if ($stmt->fetch()) {
        $mensaje = "Error: El correo o la cédula ya están registrados.";
        $tipo_alerta = "danger";
    } else {
        $sql = "INSERT INTO usuarios (cedula, nombre, correo, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$cedula, $nombre, $correo, $password])) {
            $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
            $tipo_alerta = "success";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        .btn-primary { background: #4e73df; border: none; padding: 12px; border-radius: 8px; font-weight: 600; }
        .form-control { padding: 12px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">Crear Cuenta</h3>
                <p class="text-muted">Únete a nuestra plataforma hoy</p>
            </div>

            <?php if($mensaje): ?>
                <div class="alert alert-<?php echo $tipo_alerta; ?> alert-dismissible fade show">
                    <?php echo $mensaje; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Cédula</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-id-card text-muted"></i></span>
                        <input type="text" name="cedula" class="form-control" placeholder="Ej: 12345678" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nombre Completo</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" name="nombre" class="form-control" placeholder="Juan Pérez" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Registrarse</button>
            </form>

            <div class="text-center mt-4">
                <p class="small">¿Ya tienes cuenta? <a href="logueo.php" class="text-decoration-none fw-bold">Inicia sesión</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>