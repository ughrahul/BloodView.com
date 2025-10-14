<?php
/**
 * Test Supabase Database Connection
 * Run this file to verify your connection is working
 */

// Test database connection
$host = $_ENV['SUPABASE_HOST'] ?? 'db.your-project-ref.supabase.co';
$port = $_ENV['SUPABASE_PORT'] ?? '5432';
$database = $_ENV['SUPABASE_DB'] ?? 'postgres';
$username = $_ENV['SUPABASE_USER'] ?? 'postgres';
$password = $_ENV['SUPABASE_PASSWORD'] ?? 'your-database-password';

// Parse DATABASE_URL if provided
if (isset($_ENV['DATABASE_URL'])) {
    $url = parse_url($_ENV['DATABASE_URL']);
    $host = $url['host'] ?? $host;
    $port = $url['port'] ?? $port;
    $database = ltrim($url['path'] ?? '', '/') ?: $database;
    $username = $url['user'] ?? $username;
    $password = $url['pass'] ?? $password;
}

echo "<h2>🩸 BloodView - Supabase Connection Test</h2>";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=require";
    $con = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false
    ]);
    
    echo "<p style='color: green;'>✅ <strong>SUCCESS:</strong> Connected to Supabase database!</p>";
    
    // Test if tables exist
    $tables = ['users', 'blood_stock', 'withdrawal_records'];
    foreach ($tables as $table) {
        $stmt = $con->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "<p>📊 Table '$table': $count records</p>";
    }
    
    // Test blood availability view
    $stmt = $con->query("SELECT * FROM blood_availability LIMIT 5");
    $results = $stmt->fetchAll();
    echo "<h3>🩸 Blood Availability Sample:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Blood Type</th><th>Total Deposited</th><th>Total Withdrawn</th><th>Net Availability</th></tr>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['blood_type']) . "</td>";
        echo "<td>" . $row['total_deposited'] . "</td>";
        echo "<td>" . $row['total_withdrawn'] . "</td>";
        echo "<td>" . $row['net_availability'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p style='color: green;'>🎉 <strong>All tests passed!</strong> Your Supabase setup is working perfectly!</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>ERROR:</strong> " . $e->getMessage() . "</p>";
    echo "<h3>🔧 Troubleshooting Steps:</h3>";
    echo "<ol>";
    echo "<li>Check your Supabase credentials</li>";
    echo "<li>Make sure your project is not paused</li>";
    echo "<li>Verify the database password is correct</li>";
    echo "<li>Check if your IP is whitelisted (if using IP restrictions)</li>";
    echo "</ol>";
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>If connection works: Proceed to deployment</li>";
echo "<li>If connection fails: Check your credentials and try again</li>";
echo "</ol>";
?>
