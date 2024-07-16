<?php
$filename = 'uploads/test.txt';
$content = 'Esto es una prueba de escritura.';

if (file_put_contents($filename, $content) !== false) {
    echo 'El archivo fue creado exitosamente.';
} else {
    echo 'Hubo un error al crear el archivo.';
}
?>
