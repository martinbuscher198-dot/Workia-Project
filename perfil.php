<?php
include 'header.php';
include 'verMensajes.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workia</title>
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        background-color: #333;
    }
    .contenedor-perfil {
        width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: black;
        border-radius: 5px;
        border: 1px solid black;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 300px;
        min-width: 600px;
        margin-bottom: 100px;
    }
    .fotoPerfil {
        display: flex;
        align-items: flex-start;
        gap: 70px;
    }
    .datosPersonales {
        flex: 1; 
    }
</style>
<body>
    <div class="contenedor-perfil">
        <div class="fotoYCV" style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
            <div class="fotoPerfil" style="display: flex; align-items: flex-start; gap: 10px;">
                <img src="usuario.png" width="200px" height="200px" style="filter:invert(1); border-radius: 50%;">
                <div class="datosPersonales" style="flex: 1;">
                    <h2>Perfil de Usuario</h2>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
                    <p><strong>Apellido:</strong> <?php echo htmlspecialchars($_SESSION['apellido']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($_SESSION['telefono'] ?? "No registrado"); ?></p>
                </div>
            </div>
        <?php if (!empty($_SESSION['cv'])): ?>
            <p>CV actual: <a href="<?php echo htmlspecialchars($_SESSION['cv']); ?>" target="_blank">Ver archivo</a></p>
            <form action="subir_cv.php" method="POST" enctype="multipart/form-data"style="margin-top: -20px; margin-left:130px">
                <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
                <br><br>
                <input type="submit" value="Cambiar CV" style="padding:10px 20px; border-radius:5px; border:none; background-color:cadetblue; color:white; cursor:pointer;">
            </form>
        <?php else: ?>
            <form action="subir_cv.php" method="POST" enctype="multipart/form-data" style="margin-top: -20px; margin-left:130px">
                <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
                <br><br>
                <input type="submit" value="Adjuntar CV" style="padding:10px 20px; border-radius:5px; border:none; background-color:cadetblue; color:white; cursor:pointer;">
            </form>
        <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.html'; ?>
</body>
</html>