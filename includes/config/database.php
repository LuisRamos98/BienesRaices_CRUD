<?php

function conectarDB() : mysqli{
    $db = mysqli_connect("localhost","root","root","bienesraices_crud");

    if (!$db) {
        echo "Error de Conexion";
        exit;
    }

    return $db;
}