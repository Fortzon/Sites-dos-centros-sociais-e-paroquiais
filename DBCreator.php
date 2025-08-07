<?php
$host = 'localhost';
$user = 'cspgiest_presidente';
$password = 'PresidenteAdmin'; 
$dbname = 'cspgiest_giesteiralogin_db';

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $sql = "
    CREATE TABLE IF NOT EXISTS admin_level (
        id INT AUTO_INCREMENT PRIMARY KEY,
        level VARCHAR(50) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS giesteiraadmin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(100),
        level INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (level) REFERENCES admin_level(id)
    );

    CREATE TABLE IF NOT EXISTS news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        new TEXT NOT NULL,
        status ENUM('draft', 'published', 'deleted') DEFAULT 'draft',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
    ";

    $pdo->exec($sql);

    $pdo->exec("
        INSERT INTO admin_level (level) VALUES
        ('super_admin'),
        ('admin')
        ON DUPLICATE KEY UPDATE level = level;
    ");

    $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO giesteiraadmin (email, password, name, level) 
        VALUES (:email, :password, :name, :level)
    ");

    $stmt->execute([
        ':email' => 'presidentecentrosocial@gmail.com',
        ':password' => $hashedPassword,
        ':name' => 'Bernardino Melgão',
        ':level' => 1
    ]);

    echo "Base de dados criada com sucesso.";
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>
