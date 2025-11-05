<?php
include 'header.php';
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
    .registrarse {
        width: 300px;
        margin: 100px auto;
        padding: 40px;
        background-color: black;
        border-radius: 5px;
        border: 1px solid black;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        max-height: 300px;
    }
    .registrarse form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .registrarse .form-group {
        display: flex;
        align-items: center;
        width: 100%;
    }
    .registrarse input {
        display: inline-block;
        width: 150px;
        border: 1px solid #ccc;
        border-radius: 20px;
        padding: 3px;
        background-color: black;
        color: white;
    }
    .registrarse label {
        display: inline-block;
        width: 120px;
        margin-right: 10px;
        text-align: right;
    }

</style>
<body>
    <div class="registrarse">
        <h2>Registrarse</h2>
        <form action="procesar_login.php" method="POST">
            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group" style="justify-content: center; margin-top: 20px;">
                <input type="submit" value="Iniciar Sesion"></input>
            </div>
        </form>
    </div>
    <?php include 'footer.html'; ?>
</body>
</html>