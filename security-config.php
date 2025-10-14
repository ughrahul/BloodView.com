<?php
/**
 * Security Configuration for BloodView
 * Optimized for Vercel + Supabase + Cloudflare deployment
 */

// Start secure session with serverless optimizations
if (session_status() == PHP_SESSION_NONE) {
    // Secure session configuration for serverless
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.gc_maxlifetime', 3600); // 1 hour
    ini_set('session.cookie_lifetime', 3600); // 1 hour
    
    // Use database sessions for serverless (optional)
    if (isset($_ENV['USE_DB_SESSIONS']) && $_ENV['USE_DB_SESSIONS'] === 'true') {
        session_set_save_handler(
            'db_session_open',
            'db_session_close', 
            'db_session_read',
            'db_session_write',
            'db_session_destroy',
            'db_session_gc'
        );
    }
    
    session_start();
}

// CSRF Protection Class
class CSRFProtection {
    private static $token_name = 'csrf_token';
    
    public static function generateToken() {
        if (!isset($_SESSION[self::$token_name])) {
            $_SESSION[self::$token_name] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::$token_name];
    }
    
    public static function validateToken($token) {
        return isset($_SESSION[self::$token_name]) && hash_equals($_SESSION[self::$token_name], $token);
    }
    
    public static function getTokenField() {
        return '<input type="hidden" name="csrf_token" value="' . self::generateToken() . '">';
    }
}

// Rate Limiting Class
class RateLimiter {
    private static $attempts = [];
    private static $max_attempts = 5;
    private static $time_window = 300; // 5 minutes
    
    public static function checkRateLimit($identifier) {
        $current_time = time();
        $key = md5($identifier);
        
        // Clean old attempts
        if (isset(self::$attempts[$key])) {
            self::$attempts[$key] = array_filter(self::$attempts[$key], function($timestamp) use ($current_time) {
                return ($current_time - $timestamp) < self::$time_window;
            });
        } else {
            self::$attempts[$key] = [];
        }
        
        // Check if limit exceeded
        if (count(self::$attempts[$key]) >= self::$max_attempts) {
            return false;
        }
        
        // Record attempt
        self::$attempts[$key][] = $current_time;
        return true;
    }
}

// Input Sanitization Functions
class InputSanitizer {
    public static function sanitizeString($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    public static function sanitizeEmail($email) {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }
    
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public static function sanitizePhone($phone) {
        return preg_replace('/[^0-9+\-\s()]/', '', $phone);
    }
    
    public static function sanitizeBloodType($blood_type) {
        $allowed_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        return in_array($blood_type, $allowed_types) ? $blood_type : '';
    }
}

// Security Headers optimized for Cloudflare + Vercel
function setSecurityHeaders() {
    // Prevent XSS attacks
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    
    // Cloudflare handles HTTPS enforcement, but add HSTS for extra security
    if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
    
    // Content Security Policy for enhanced security
    $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self'";
    header("Content-Security-Policy: $csp");
}

// Database session handlers for serverless architecture
function db_session_open($save_path, $session_name) {
    global $con;
    return $con !== null;
}

function db_session_close() {
    return true;
}

function db_session_read($session_id) {
    global $con;
    try {
        $stmt = $con->prepare("SELECT data FROM sessions WHERE id = ? AND expires_at > NOW()");
        $stmt->execute([$session_id]);
        $result = $stmt->fetch();
        return $result ? $result['data'] : '';
    } catch (Exception $e) {
        return '';
    }
}

function db_session_write($session_id, $session_data) {
    global $con;
    try {
        $stmt = $con->prepare("INSERT INTO sessions (id, data, expires_at) VALUES (?, ?, NOW() + INTERVAL '1 hour') ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data, expires_at = EXCLUDED.expires_at");
        return $stmt->execute([$session_id, $session_data]);
    } catch (Exception $e) {
        return false;
    }
}

function db_session_destroy($session_id) {
    global $con;
    try {
        $stmt = $con->prepare("DELETE FROM sessions WHERE id = ?");
        return $stmt->execute([$session_id]);
    } catch (Exception $e) {
        return false;
    }
}

function db_session_gc($maxlifetime) {
    global $con;
    try {
        $stmt = $con->prepare("DELETE FROM sessions WHERE expires_at < NOW()");
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

// Authentication Helper Functions
function isLoggedIn() {
    return isset($_SESSION['username']) && !empty($_SESSION['username']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: loginexample.php');
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'super_admin']);
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: homepage.php');
        exit();
    }
}

// Database Security Functions
function secureQuery($con, $query, $params = []) {
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($con));
        return false;
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_double($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        mysqli_stmt_bind_param($stmt, $types, ...$values);
    }
    
    return $stmt;
}

// Logging Function
function logSecurityEvent($event, $details = '') {
    $log_entry = date('Y-m-d H:i:s') . " - " . $event;
    if (!empty($details)) {
        $log_entry .= " - " . $details;
    }
    $log_entry .= " - IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $log_entry .= " - User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown');
    $log_entry .= "\n";
    
    error_log($log_entry, 3, __DIR__ . '/logs/security.log');
}

// Initialize security
setSecurityHeaders();

// Create logs directory if it doesn't exist
if (!file_exists(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}
?>
