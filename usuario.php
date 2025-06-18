<?php

// Importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

// Crear un email y password
$email = "anto@gmail.com";
$password = 123456;
// Hashear la contraseña || 1NOTAS char(60) en la db, una contraseña hasheada siempre ocupara 60 caracteres 
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Query para crear el usuario
$query = "INSERT INTO usuarios(email, password) VALUES ('$email', '$passwordHash')";

// Agregarlo a la base de datos
mysqli_query($db, $query);