<?php
// get_questions.php

// 1. Configuración de CORS
// Esto es crucial para que tu frontend (que puede estar en un dominio/puerto diferente)
// pueda hacer peticiones a este script PHP.
// Permite solicitudes desde cualquier origen (*) - AJUSTA ESTO PARA PRODUCCIÓN
// En producción, deberías especificar tu dominio, ej: 'Access-Control-Allow-Origin: https://tudominio.com'
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); // Indicamos que la respuesta es JSON

// 2. Configuración de la base de datos
require "secrets.php";
$secret = secrets();

// 3. Conexión a la base de datos
$conn = new mysqli($secret['mysql_server'], $secret['mysql_user'], $secret['mysql_password'], $secret['mysql_db']);
$conn->set_charset("utf8mb4");

// Verificar conexión
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $conn->connect_error]);
    exit();
}

// 4. Consulta SQL para obtener las preguntas
// Asume que tienes una tabla 'questions' con columnas 'id', 'enunciado', 'respuesta', 'tema_id', 'tipo'.
// Puedes ajustar el LIMIT para obtener un número específico de preguntas.
$sql = "SELECT * FROM q_and_a ORDER BY RAND() LIMIT 20"; // Ejemplo: 20 preguntas aleatorias

$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta SQL: " . $conn->error, "sql" => $sql]);
    $conn->close();
    exit();
}

$questions = [];

if ($result->num_rows > 0) {
    // Recorrer los resultados y almacenarlos en un array
    while($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

// 5. Cerrar conexión
$conn->close();

// 6. Devolver las preguntas en formato JSON
echo json_encode($questions);

?>