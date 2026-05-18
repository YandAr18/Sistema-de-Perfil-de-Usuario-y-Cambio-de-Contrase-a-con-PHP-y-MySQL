<?php
require 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: logueo.php");
    exit;
}

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user_id'];
    $pass_actual = $_POST['pass_actual'];
    $pass_nueva = $_POST['pass_nueva'];
    $pass_confirm = $_POST['pass_confirm'];

    $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (password_verify($pass_actual, $user['password'])) {
        if ($pass_nueva === $pass_confirm) {
            $nueva_hash = password_hash($pass_nueva, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $update->execute([$nueva_hash, $id]);
            $mensaje = "Contraseña actualizada correctamente.";
            $tipo_alerta = "success";
        } else {
            $mensaje = "Las nuevas contraseñas no coinciden.";
            $tipo_alerta = "danger";
        }
    } else {
        $mensaje = "La contraseña actual es incorrecta.";
        $tipo_alerta = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad - Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8f9fc; font-family: 'Poppins', sans-serif; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn-primary { background: #4e73df; border: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="perfil.php"><i class="fas fa-user-shield me-2"></i>MiSistema</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="perfil.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active" href="cambiar_password.php">Seguridad</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="mb-4">
                    <h4 class="fw-bold"><i class="fas fa-lock me-2 text-primary"></i>Actualizar Seguridad</h4>
                    <p class="text-muted small">Asegúrate de usar una contraseña difícil de adivinar.</p>
                </div>

                <?php if($mensaje): ?>
                    <div class="alert alert-<?php echo $tipo_alerta; ?> alert-dismissible fade show">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Contraseña Actual</label>
                        <input type="password" name="pass_actual" class="form-control" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nueva Contraseña</label>
                        <input type="password" name="pass_nueva" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Confirmar Nueva Contraseña</label>
                        <input type="password" name="pass_confirm" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Guardar Nueva Contraseña</button>
                        <a href="perfil.php" class="btn btn-light">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>