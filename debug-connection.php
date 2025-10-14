<?php
/**
 * Database Connection Debug Tool
 * This will help us see what's happening with the connection
 */

echo "<h2>🔍 Database Connection Debug</h2>";

// Show environment variables (for debugging)
echo "<h3>Environment Variables:</h3>";
echo "<pre>";
echo "DATABASE_URL: " . ($_ENV['DATABASE_URL'] ?? 'NOT SET') . "\n";
echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'NOT SET') . "\n";
echo "DB_PASSWORD: " . ($_ENV['DB_PASSWORD'] ?? 'NOT SET') . "\n";
echo "DB_USERNAME: " . ($_ENV['DB_USERNAME'] ?? 'NOT SET') . "\n";
echo "DB_NAME: " . ($_ENV['DB_NAME'] ?? 'NOT SET') . "\n";
echo "</pre>";

// Test connection
echo "<h3>Connection Test:</h3>";

try {
    // Parse DATABASE_URL if provided
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? '5432';
    $database = $_ENV['DB_NAME'] ?? 'postgres';
    $username = $_ENV['DB_USERNAME'] ?? 'postgres';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    
    // Parse DATABASE_URL if provided
    if (isset($_ENV['DATABASE_URL'])) {
        $url = parse_url($_ENV['DATABASE_URL']);
        $host = $url['host'] ?? $host;
        $port = $url['port'] ?? $port;
        $database = ltrim($url['path'] ?? '', '/') ?: $database;
        $username = $url['user'] ?? $username;
        $password = $url['pass'] ?? $password;
    }
    
    echo "<p>Attempting to connect to:</p>";
    echo "<ul>";
    echo "<li>Host: $host</li>";
    echo "<li>Port: $port</li>";
    echo "<li>Database: $database</li>";
    echo "<li>Username: $username</li>";
    echo "<li>Password: " . (empty($password) ? 'EMPTY' : 'SET') . "</li>";
    echo "</ul>";
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=require";
    $con = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false
    ]);
    
    echo "<p style='color: green;'>✅ <strong>SUCCESS:</strong> Connected to database!</p>";
    
    // Test a simple query
    $stmt = $con->query("SELECT version()");
    $version = $stmt->fetchColumn();
    echo "<p>Database version: $version</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>ERROR:</strong> " . $e->getMessage() . "</p>";
    echo "<h3>Common Solutions:</h3>";
    echo "<ul>";
    echo "<li>Check if environment variables are set in Vercel</li>";
    echo "<li>Verify Supabase database password is correct</li>";
    echo "<li>Make sure Supabase project is not paused</li>";
    echo "<li>Check if IP restrictions are blocking the connection</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>If connection works: Your app should work fine</li>";
echo "<li>If connection fails: Check environment variables in Vercel</li>";
echo "<li>Delete this file after testing for security</li>";
echo "</ol>";
?>
