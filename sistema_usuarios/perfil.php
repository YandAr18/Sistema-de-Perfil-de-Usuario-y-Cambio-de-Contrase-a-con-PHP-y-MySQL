<?php
require 'conexion.php';
if (!isset($_SESSION['user_id'])) { header("Location: logueo.php"); exit; }

$id = $_SESSION['user_id'];
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?");
    if ($stmt->execute([$nombre, $correo, $id])) {
        $_SESSION['nombre'] = $nombre;
        $mensaje = "¡Perfil actualizado con éxito!";
    }
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fc; font-family: 'Poppins', sans-serif; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .profile-card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .avatar-circle { width: 80px; height: 80px; background: #4e73df; color: white; display: flex; align-items: center; justify-content: center; font-size: 30px; border-radius: 50%; margin: 0 auto 15px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#"><i class="fas fa-user-shield me-2"></i>MiSistema</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="perfil.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="cambiar_password.php">Cambiar contraseña</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php" font-weight-bold">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card profile-card p-4">
                <div class="text-center">
                    <div class="avatar-circle">
                        <?php echo strtoupper(substr($user['nombre'], 0, 1)); ?>
                    </div>
                    <h4>Hola, <?php echo htmlspecialchars($user['nombre']); ?></h4>
                    <p class="text-muted small">Miembro desde: <?php echo date('d M, Y', strtotime($user['fecha_registro'])); ?></p>
                </div>

                <hr>

                <?php if($mensaje): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" class="mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Cédula</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $user['cedula']; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($user['correo']); ?>" required>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" name="actualizar" class="btn btn-primary px-4">Actualizar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>