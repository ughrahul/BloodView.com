 <?php
/**
 * Supabase PostgreSQL Database Connection for BloodView
 * Optimized for Vercel serverless deployment
 */

// Database configuration using environment variables (Vercel/Supabase)
$host = $_ENV['DB_HOST'] ?? $_ENV['DATABASE_URL'] ?? 'localhost';
$port = $_ENV['DB_PORT'] ?? '5432';
$database = $_ENV['DB_NAME'] ?? $_ENV['POSTGRES_DB'] ?? 'postgres';
$username = $_ENV['DB_USERNAME'] ?? $_ENV['POSTGRES_USER'] ?? 'postgres';
$password = $_ENV['DB_PASSWORD'] ?? $_ENV['POSTGRES_PASSWORD'] ?? '';

// Parse DATABASE_URL if provided (common in Supabase)
if (isset($_ENV['DATABASE_URL'])) {
    $url = parse_url($_ENV['DATABASE_URL']);
    $host = $url['host'] ?? $host;
    $port = $url['port'] ?? $port;
    $database = ltrim($url['path'] ?? '', '/') ?: $database;
    $username = $url['user'] ?? $username;
    $password = $url['pass'] ?? $password;
}

// PostgreSQL connection
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=require";
    $con = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false // Important for serverless
    ]);
    
    // Set timezone
    $con->exec("SET timezone = 'UTC'");
    
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

// Helper functions for MySQL to PostgreSQL compatibility
if (!function_exists('mysqli_query')) {
    function mysqli_query($con, $query) {
        try {
            return $con->query($query);
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage() . " Query: " . $query);
            return false;
        }
    }
}

if (!function_exists('mysqli_num_rows')) {
    function mysqli_num_rows($result) {
        return $result ? $result->rowCount() : 0;
    }
}

if (!function_exists('mysqli_fetch_assoc')) {
    function mysqli_fetch_assoc($result) {
        return $result ? $result->fetch() : false;
    }
}

if (!function_exists('mysqli_real_escape_string')) {
    function mysqli_real_escape_string($con, $string) {
        return $con->quote($string);
    }
}

if (!function_exists('mysqli_error')) {
    function mysqli_error($con) {
        $error = $con->errorInfo();
        return $error[2] ?? 'Unknown error';
    }
}

if (!function_exists('mysqli_connect_error')) {
    function mysqli_connect_error() {
        return 'Connection failed';
    }
}

if (!function_exists('mysqli_set_charset')) {
    function mysqli_set_charset($con, $charset) {
        // PostgreSQL uses UTF8 by default
        return true;
    }
}

if (!function_exists('mysqli_close')) {
    function mysqli_close($con) {
        $con = null;
        return true;
    }
}
?>
