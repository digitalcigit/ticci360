<?php
require __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    // Fallback if Dotenv not found or fails
}

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$db   = $_ENV['DB_DATABASE'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];
$port = $_ENV['DB_PORT'] ?? 3306;

echo "Connecting to $db on $host...\n";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $stmt = $pdo->query("DESCRIBE ec_product_categories");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Columns in ec_product_categories: " . implode(", ", $columns) . "\n";
    
    if (!in_array('slug', $columns)) {
        echo "ALERT: 'slug' column is MISSING!\n";
    } else {
        echo "OK: 'slug' column exists.\n";
    }

} catch (\PDOException $e) {
    echo "DB Error: " . $e->getMessage() . "\n";
}
