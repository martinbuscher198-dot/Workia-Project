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
        <h2>Registrar Servicio</h2>
        <form action="procesar_servicio.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" accept=".jpg,.png">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" required>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <select name="departamento" id="departamento" required>
                    <option value="">Seleccione...</option>
                    <option value="Montevideo">Montevideo</option>
                    <option value="Canelones">Canelones</option>
                    <option value="Maldonado">Maldonado</option>
                    <!-- Agregá todos los departamentos que necesites -->
                </select>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <select name="ciudad" id="ciudad" required>
                    <option value="">Seleccione departamento primero</option>
                </select>
            </div>

            <script>
            const ciudadesPorDepartamento = {
                "Montevideo": ["Marconi","Piedras blancas", "lavalleja","cerro norte", "carrasco"],
                "Canelones": ["Las Piedras", "Pando", "Ciudad de la Costa"],
                "Maldonado": ["Punta del Este", "Maldonado", "San Carlos"]
                // agregá más según tus necesidades
            };

            const deptoSelect = document.getElementById('departamento');
            const ciudadSelect = document.getElementById('ciudad');

            deptoSelect.addEventListener('change', function() {
                const departamento = this.value;
                ciudadSelect.innerHTML = "<option value=''>Seleccione...</option>";

                if(ciudadesPorDepartamento[departamento]) {
                    ciudadesPorDepartamento[departamento].forEach(ciudad => {
                        const option = document.createElement('option');
                        option.value = ciudad;
                        option.textContent = ciudad;
                        ciudadSelect.appendChild(option);
                    });
                }
            });
            </script>

            <div class="form-group" style="justify-content: center;">
                <input type="submit" value="Registrarse" style="width: auto; padding: 8px 20px;">
            </div>
        </form>
    </div>
    <?php include 'footer.html'; ?>
</body>
</html>