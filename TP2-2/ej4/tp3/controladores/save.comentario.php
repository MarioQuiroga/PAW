<?php
require __DIR__ . '/../modelo/Comentario.php';

$comentario=$_POST['comentario'];
$id_art=$_GET['id_articulo'];

Comentario::insertarComentario($comentario,$id_art);

header('Location: /laravel/PAW/tp3/vista/index.php');