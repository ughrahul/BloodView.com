<?php
/**
 * Error Display and Debug Tool
 * This will show any PHP errors that might be causing the blank screen
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>🩸 BloodView Debug Page</h1>";
echo "<p>If you can see this, PHP is working!</p>";

// Test basic PHP functionality
echo "<h2>PHP Test:</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Test file includes
echo "<h2>File Include Test:</h2>";
try {
    echo "<p>Testing connect.php...</p>";
    include_once 'connect.php';
    echo "<p style='color: green;'>✅ connect.php loaded successfully!</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error loading connect.php: " . $e->getMessage() . "</p>";
}

// Test index.php
echo "<h2>Index.php Test:</h2>";
try {
    echo "<p>Testing index.php...</p>";
    $index_content = file_get_contents('index.php');
    echo "<p style='color: green;'>✅ index.php exists and readable!</p>";
    echo "<p>Content preview: " . htmlspecialchars(substr($index_content, 0, 100)) . "...</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error reading index.php: " . $e->getMessage() . "</p>";
}

// Test homepage.php
echo "<h2>Homepage.php Test:</h2>";
try {
    echo "<p>Testing homepage.php...</p>";
    $homepage_content = file_get_contents('homepage.php');
    echo "<p style='color: green;'>✅ homepage.php exists and readable!</p>";
    echo "<p>Content preview: " . htmlspecialchars(substr($homepage_content, 0, 100)) . "...</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error reading homepage.php: " . $e->getMessage() . "</p>";
}

// Test database connection
echo "<h2>Database Connection Test:</h2>";
try {
    if (isset($con)) {
        echo "<p style='color: green;'>✅ Database connection object exists!</p>";
        $stmt = $con->query("SELECT 1 as test");
        $result = $stmt->fetch();
        echo "<p style='color: green;'>✅ Database query successful!</p>";
    } else {
        echo "<p style='color: red;'>❌ Database connection object not found!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
}

// Show environment variables
echo "<h2>Environment Variables:</h2>";
echo "<pre>";
echo "DATABASE_URL: " . ($_ENV['DATABASE_URL'] ?? 'NOT SET') . "\n";
echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'NOT SET') . "\n";
echo "DB_PASSWORD: " . ($_ENV['DB_PASSWORD'] ?? 'NOT SET') . "\n";
echo "DB_USERNAME: " . ($_ENV['DB_USERNAME'] ?? 'NOT SET') . "\n";
echo "DB_NAME: " . ($_ENV['DB_NAME'] ?? 'NOT SET') . "\n";
echo "</pre>";

// Test session
echo "<h2>Session Test:</h2>";
try {
    session_start();
    echo "<p style='color: green;'>✅ Session started successfully!</p>";
    echo "<p>Session ID: " . session_id() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Session error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>🔗 Test Links:</h2>";
echo "<p><a href='index.php'>Test index.php</a></p>";
echo "<p><a href='loginexample.php'>Test login page</a></p>";
echo "<p><a href='homepage.php'>Test homepage</a></p>";
echo "<p><a href='debug-connection.php'>Test database connection</a></p>";

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Check what errors are shown above</li>";
echo "<li>Test the links to see which pages work</li>";
echo "<li>Delete this file after debugging for security</li>";
echo "</ol>";
?>
