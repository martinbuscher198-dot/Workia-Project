<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workia</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background-color: #333;
        }
        .contenedor {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
        }

        .logoYCrearServicio,
        .iniciarYRegistrarse {
            display: flex;
            align-items: center;
            gap: 50px; /* 🔹 Espacio entre el logo y el nav */
            color: white;
        }
        .logoYCrearServicio ul li{
            border: 1px solid  cadetblue;
            padding: 20px 10px;
            border-radius: 5px;
            position: relative;
            background-color: cadetblue;
            top: 5px;
        }
        .iniciarYRegistrarse ul{
            gap: 50px; /* 🔹 Espacio entre los enlaces */
        }

        /* Quitamos estilos por defecto de la lista */
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex; /* 🔹 Esto las pone en línea */
            gap: 15px; /* 🔹 Espacio entre elementos */
        }
        a {
            text-decoration: none;
            font-weight: bold;
            color: white;
        }
        #inicioSesion, #registrarse {
            border: 1px solid cadetblue;
            padding: 20px 15px;
            border-radius: 5px;
            position: relative;
            background-color: cadetblue;
            top: 5px;
            right: 20px;
        }

        a:hover {
            color: #007bff;
        }

        .barraBusqueda input {
            padding: 10px;
            border-radius: 20px;
            border: none;
            width: 200px;
            background-color: black;
            border: 1px solid white;
            color: white;
        }
        .barraBusqueda{
            display: flex;
            align-items: center;
            justify-content: center;
            gap:10px;
            position: relative;
        }
        #resultados{
            postion: absolute;
            top: 40px;
        }
        .barraBusqueda ul li{
            border: 1px solid  cadetblue;
            padding: 10px 10px;
            border-radius: 5px;
            position: relative;
            background-color: cadetblue;
        }

        /* Estilos para el dropdown */
        .dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    color: white;
    padding: 15px 25px;
    border: none;
    border-radius: 100px;
    font-weight: bold;
    cursor: pointer;
}

/* Menú desplegable oculto */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: black;
    min-width: 160px;
    border: 1px solid cadetblue;
    border-radius: 5px;
    top: 100%;
    right: 0;
    z-index: 1;
}

/* Estilos de los enlaces del menú */
.dropdown-content a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-weight: bold;
}

.dropdown-content a:hover {
    background-color: cadetblue;
}

/* Mostrar el menú al pasar el mouse */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Cambia el color del botón cuando el menú está activo */
    </style>
</head>
<body>
    <div class="contenedor-principal">
        
    </div>
    <div class="contenedor">
        <div class="logoYCrearServicio">
            <li><a href="index.php"><h1>Logo</h1></a></li>
        </div>
    <div class="barraBusqueda">
        <input type="text" id="busqueda" placeholder="Buscar...">
        <div id="resultados" style="position:absolute; background:black; width:200px; max-height:300px; overflow-y:auto; border:1px solid cadetblue; display:none;"></div>
    </div>

<div class="iniciarYRegistrarse">
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <div class="dropdown">
            <button class="dropbtn" style="position:relative; right:20px; filter:invert(1);">
                <img src="usuario.png" width="50px" height="50px">
            </button>
            <div class="dropdown-content">
                <?php if ($_SESSION['tipo_usuario'] === 'proovedor'): ?>
                    <a href="crear_servicio.php">Crear Servicio</a>
                    <a href="mis_servicios.php">Ver mis servicios</a>
                    <a href="ver_reservas.php">Ver Reservas</a>
                <?php elseif ($_SESSION['tipo_usuario'] === 'cliente'): ?>
                    <a href="mis_reservas.php">Mis Reservas</a>
                <?php endif; ?>
                <a href="perfil.php">Ver Perfil</a>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    <?php else: ?>
        <nav>
            <ul>
                <li id="inicioSesion"><a href="login.php">Iniciar Sesión</a></li>
                <li id="registrarse"><a href="registrarse.php">Registrarse</a></li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

    </div>
</body>
</html>
<script>
    const input = document.getElementById('busqueda');
    const resultados = document.getElementById('resultados');

    input.addEventListener('input', function() {
        const query = this.value.trim();
        if (!query) {
            resultados.style.display = 'none';
            resultados.innerHTML = '';
            return;
        }

        fetch('buscar_ajax.php?q=' + encodeURIComponent(query))
            .then(response => response.text())
            .then(html => {
                resultados.innerHTML = html;
                resultados.style.display = html ? 'block' : 'none';
            });
    });
</script>