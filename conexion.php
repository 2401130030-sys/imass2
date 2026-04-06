<?php
// conexion.php
// Lee las credenciales desde variables de entorno o desde .env

// Cargar .env si existe (para desarrollo local)
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}

// Leer credenciales
$servername = getenv('DB_HOST') ?: 'localhost';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '';
$dbname     = getenv('DB_NAME') ?: 'imass';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}

$conn->set_charset("utf8");
?>
