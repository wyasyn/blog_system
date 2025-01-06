<?php
require 'includes/db.php';

$migrationFiles = [
    'migrations/create_users_table.sql',
    'migrations/create_blogs_table.sql'
];

foreach ($migrationFiles as $file) {
    $sql = file_get_contents($file);
    try {
        $pdo->exec($sql);
        echo "Successfully ran $file\n";
    } catch (PDOException $e) {
        echo "Error running $file: " . $e->getMessage() . "\n";
    }
}
?>
