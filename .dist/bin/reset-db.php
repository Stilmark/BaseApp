<?php

// Calculate ROOT path relative to this script
define('ROOT', dirname(__DIR__, 2));
require_once ROOT.'/init-cli.php';

use Stilmark\Base\Env;

// Get database configuration
$dbHost = Env::get('DB_HOST');
$dbName = Env::get('DB_DATABASE');
$dbUser = Env::get('DB_USERNAME');
$dbPass = Env::get('DB_PASSWORD');

try {
    // Create PDO connection
    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    // Get all SQL files from the directory
    $sqlDir = ROOT . '/.dist/sql/tables/';
    $files = glob($sqlDir . '*.sql');
    
    if (empty($files)) {
        echo "No SQL files found in {$sqlDir}\n";
        exit(1);
    }

    // Sort files alphabetically
    sort($files);

    // Disable foreign key checks at the beginning
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');

    // Process each SQL file
    foreach ($files as $file) {
        echo "Processing " . basename($file) . "...\n";
        
        // Read the SQL file
        $sql = file_get_contents($file);
        
        // Remove comments and split into individual queries
        $sql = preg_replace(['/--.*$/m', '#/\*.*?\*/#s'], '', $sql);
        $queries = array_filter(
            array_map('trim', 
                preg_split(
                    "/;\s*(?=([^\'\"]*[\'\"][^\'\"]*[\'\"])*[^\'\"]*$)/m", 
                    $sql
                )
            ),
            function($query) {
                return !empty(trim($query));
            }
        );
        
        // Remove any empty lines that might be left after comment removal
        $queries = array_values(array_filter($queries));

        // Execute each query
        foreach ($queries as $query) {
            try {
                $pdo->exec($query);
            } catch (PDOException $e) {
                echo "Error executing query in " . basename($file) . ":\n";
                echo "Query: " . substr($query, 0, 200) . (strlen($query) > 200 ? '...' : '') . "\n";
                echo "Error: " . $e->getMessage() . "\n";
                // Re-enable foreign key checks before exiting
                $pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');
                exit(1);
            }
        }
        
        echo "✓ " . basename($file) . " executed successfully\n";
    }
    
    // Re-enable foreign key checks after all operations
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');

    echo "\nDatabase initialization completed successfully!\n";
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage() . "\n");
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}

// Usage
// php .dist/bin/reset-db.php
