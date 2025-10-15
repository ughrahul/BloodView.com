<?php
// Simple database connection test
echo "<h1>Database Connection Test</h1>";

try {
    include("connect.php");
    echo "<p style='color: green;'>✅ <strong>SUCCESS:</strong> Connected to Supabase database!</p>";
    echo "<p><strong>Database Host:</strong> " . $host . "</p>";
    echo "<p><strong>Database Name:</strong> " . $database . "</p>";
    echo "<p><strong>Username:</strong> " . $username . "</p>";
    
    // Test a simple query
    $testQuery = "SELECT version() as db_version";
    $result = $con->query($testQuery);
    if ($result) {
        $version = $result->fetch();
        echo "<p><strong>Database Version:</strong> " . $version['db_version'] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ <strong>ERROR:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Debug Info:</strong></p>";
    echo "<ul>";
    echo "<li>Host: " . ($host ?? 'Not set') . "</li>";
    echo "<li>Port: " . ($port ?? 'Not set') . "</li>";
    echo "<li>Database: " . ($database ?? 'Not set') . "</li>";
    echo "<li>Username: " . ($username ?? 'Not set') . "</li>";
    echo "<li>Password: " . (isset($password) ? 'Set' : 'Not set') . "</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='loginexample.php'>→ Go to Login Page</a></p>";
echo "<p><a href='index.php'>→ Go to Home Page</a></p>";
?>
