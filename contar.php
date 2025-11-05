<?php
function contarLineas($dir) {
    $total = 0;
    foreach (scandir($dir) as $archivo) {
        if ($archivo == '.' || $archivo == '..') continue;
        $ruta = "$dir/$archivo";
        if (is_dir($ruta)) {
            $total += contarLineas($ruta);
        } elseif (preg_match('/\.(php|html|css|js)$/', $archivo)) {
            $total += count(file($ruta));
        }
    }
    return $total;
}

echo "Total de líneas: " . contarLineas(__DIR__);