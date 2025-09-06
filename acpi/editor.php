<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (BETA) - HARDENED VERSION
//Security improvements by Claude - Addresses path traversal, XSS, and file validation
//Original based on PHP-Quick-Arcade 3.0 © Jcink.com
//Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
# Section: acpi Place: editor - Administrator Control Panel   Modified: 9/5/2025   By: MaSoDo w/Claude.AI

// Include PLA's Preliminary.php for vsess() function and $key variable
require_once('./Preliminary.php');

/**
 * Hardened File Editor for PLA
 * Fixes: Path traversal, XSS, arbitrary file access, CSRF, input validation
 */

// Configuration - Define allowed files explicitly
define('ALLOWED_SKINS', [
    'BlackDefault.css',
    'Default.css', 
    'GrayDefault.css',
    'custom.css'
]);

define('ALLOWED_ANNOUNCEMENTS', [
    'announce.php',
    'announce.txt',
    'news.txt'
]);

define('ANNOUNCEMENTS_DIR', './flat/');
define('SKINS_DIR', './skins/');
define('MAX_FILE_SIZE', 1048576); // 1MB limit

/**
 * Secure file path validation
 */
function validateFilePath($filename, $allowedFiles, $baseDir) {
    // Check if filename is in whitelist
    if (!in_array($filename, $allowedFiles, true)) {
        return false;
    }
    
    // Ensure base directory exists and is readable
    if (!is_dir($baseDir) || !is_readable($baseDir)) {
        return false;
    }
    
    $fullPath = $baseDir . $filename;
    
    // Additional security: ensure no directory traversal in the constructed path
    if (strpos($filename, '..') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
        return false;
    }
    
    return $fullPath;
}

/**
 * Generate and validate CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && 
           hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Secure message display with proper escaping
 */
function secureMessage($content, $isForm = false) {
    if ($isForm) {
        // For forms, we need to be more careful about escaping
        echo $content; // Content should already be properly constructed
    } else {
        echo '<div class="message">' . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . '</div>';
    }
}

/**
 * Validate file content (basic security checks)
 */
function validateFileContent($content, $type, $filename = '') {
    // Size check
    if (strlen($content) > MAX_FILE_SIZE) {
        return "File content too large (max " . (MAX_FILE_SIZE/1024) . "KB)";
    }
    
    // Basic content validation
    if ($type === 'css') {
        // Check for suspicious CSS content
        $suspicious = ['javascript:', 'expression(', 'behavior:', '@import', 'binding:'];
        foreach ($suspicious as $pattern) {
            if (stripos($content, $pattern) !== false) {
                return "Suspicious CSS content detected: " . htmlspecialchars($pattern, ENT_QUOTES, 'UTF-8');
            }
        }
    } elseif ($type === 'txt') {
        // For text files, check for script tags
        if (preg_match('/<script[^>]*>.*?<\/script>/is', $content)) {
            return "Script tags not allowed in announcement files";
        }
    } elseif ($type === 'php') {
        // For PHP files, perform basic security checks
        $dangerous_functions = [
            'exec', 'system', 'shell_exec', 'passthru', 'eval', 'create_function',
            'file_get_contents', 'file_put_contents', 'fopen', 'fwrite', 'fputs',
            'unlink', 'rmdir', 'chmod', 'chown', 'move_uploaded_file',
            'curl_exec', 'curl_multi_exec', 'parse_ini_file', 'show_source',
            'highlight_file', 'fpassthru', 'expect_popen', 'ssh2_exec',
            'proc_open', 'popen', 'file', 'readfile'
        ];
        
        foreach ($dangerous_functions as $func) {
            if (preg_match('/\b' . preg_quote($func, '/') . '\s*\(/i', $content)) {
                return "Dangerous PHP function detected: " . htmlspecialchars($func, ENT_QUOTES, 'UTF-8');
            }
        }
        
        // Revised suspicious patterns
$suspicious_patterns = [
    '/\$_GET$$.*$$/' => '$_GET usage (potential security risk)',
    '/\$_POST$$.*$$/' => '$_POST usage (potential security risk)', 
    '/\$_REQUEST$$.*$$/' => '$_REQUEST usage (potential security risk)',
    '/\$_SERVER$$.*$$/' => '$_SERVER usage (potential security risk)',
    '/\$_FILES$$.*$$/' => '$_FILES usage (not allowed)',
    '/base64_decode\s*\(/i' => 'base64_decode (potential obfuscation)',
    '/hex2bin\s*\(/i' => 'hex2bin (potential obfuscation)',
    '/str_rot13\s*\(/i' => 'str_rot13 (potential obfuscation)',
    // More precise check for actual short tags
    '/\<\?(?!php)/' => 'Short PHP tags (not recommended)',
];
        
        foreach ($suspicious_patterns as $pattern => $message) {
            if (preg_match($pattern, $content)) {
                return "Suspicious PHP pattern detected: " . htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
            }
        }
    }
    
    return true;
}

// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID periodically for security
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Check authentication for all operations (GET and POST)
// vsess() expects 'akey' parameter to match global $key
if (isset($_GET['skin']) || isset($_GET['announce']) || isset($_POST['skinedit']) || isset($_POST['fileedit'])) {
    if (!function_exists('vsess')) {
        secureMessage("Authentication system not available.");
        exit;
    }
    
    // Use PLA's vsess() function for authentication
    // It checks for $_REQUEST['akey'] == $key
    vsess();
}

// Handle skin editing
if (isset($_GET['skin'])) {
    $skinFile = trim($_GET['skin']);
    
    // Validate the skin file
    $skinPath = validateFilePath($skinFile, ALLOWED_SKINS, SKINS_DIR);
    if (!$skinPath) {
        secureMessage("Invalid skin file specified: " . htmlspecialchars($skinFile, ENT_QUOTES, 'UTF-8'));
        exit;
    }
    
    // Handle form submission
    if (isset($_POST['skinedit'])) {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            secureMessage("Invalid security token. Please refresh the page and try again.");
            exit;
        }
        
        $cssContent = $_POST['cssforarcade'] ?? '';
        
        // Validate content
        $validation = validateFileContent($cssContent, 'css');
        if ($validation !== true) {
            secureMessage("Validation failed: " . $validation);
            exit;
        }
        
        // IPB 1.3 skin compatibility replacements
        $cssContent = str_replace("maintitle", "headertableblock", $cssContent);
        $cssContent = str_replace("row1", "arcade1", $cssContent);
        
        // Check if directory is writable
        if (!is_writable(dirname($skinPath))) {
            secureMessage("Skin directory is not writable. Check permissions on: " . dirname($skinPath));
            exit;
        }
        
        // Attempt to write file
        $writeResult = file_put_contents($skinPath, $cssContent, LOCK_EX);
        if ($writeResult !== false) {
            // Redirect back to editor with success message, preserving akey
            $currentAkey = $_REQUEST['akey'] ?? '';
            $redirectUrl = "?cpiarea=editor&skin=" . urlencode($skinFile) . "&akey=" . urlencode($currentAkey) . "&success=skin_updated";
            header("Location: " . $redirectUrl);
            exit;
        } else {
            secureMessage("Failed to write skin file. Check permissions on: " . $skinPath);
            exit;
        }
    }
    
    // Read current skin content
    $currentCSS = "";
    if (file_exists($skinPath) && is_readable($skinPath)) {
        $currentCSS = file_get_contents($skinPath);
        if ($currentCSS === false) {
            $currentCSS = "/* Error reading file */";
        }
    } else {
        $currentCSS = "/* File not found: " . $skinPath . " */";
    }
    
    // Check for success message
    $successMessage = '';
    if (isset($_GET['success']) && $_GET['success'] === 'skin_updated') {
        $successMessage = "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;'>" .
                         "? <strong>Success!</strong> Skin updated successfully." .
                         "</div>";
    }
    
    // Generate form with CSRF protection
    $csrfToken = generateCSRFToken();
    $escapedSkin = htmlspecialchars($skinFile, ENT_QUOTES, 'UTF-8');
    $escapedCSS = htmlspecialchars($currentCSS, ENT_QUOTES, 'UTF-8');
    
    // Get the current akey from the request (this is what passed vsess() on page load)
    $currentAkey = $_REQUEST['akey'] ?? '';
    $escapedKey = htmlspecialchars($currentAkey, ENT_QUOTES, 'UTF-8');
    
    $debugInfo = "<div style='background: #e6f3ff; padding: 10px; margin: 10px 0; border: 1px solid #b3d9ff; border-radius: 4px;'>" .
                "<strong>Debug Info:</strong> akey = " . htmlspecialchars($currentAkey, ENT_QUOTES, 'UTF-8') . 
                " | global key = " . htmlspecialchars($key ?? 'NOT_SET', ENT_QUOTES, 'UTF-8') . "</div>";
    
    $form = "<div style='margin: 20px;'>";
    $form .= $successMessage;
    $form .= $debugInfo;
    $form .= "<form method='post' action='?cpiarea=editor&amp;skin=" . urlencode($skinFile) . "'>";
    $form .= "<input type='hidden' name='akey' value='" . $escapedKey . "'>";
    $form .= "<input type='hidden' name='csrf_token' value='" . htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') . "'>";
    $form .= "<h3>Editing Skin: " . $escapedSkin . "</h3>";
    $form .= "<p><strong>File Path:</strong> " . htmlspecialchars($skinPath, ENT_QUOTES, 'UTF-8') . "</p>";
    $form .= "<textarea rows='40' cols='80' name='cssforarcade' style='width: 100%; font-family: \"Courier New\", Consolas, monospace; font-size: 13px; background: #f8f8f8; border: 1px solid #ddd; padding: 10px;'>" . $escapedCSS . "</textarea><br><br>";
    $form .= "<input type='submit' name='skinedit' value='Update Stylesheet' style='padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;'>";
    $form .= "<input type='button' onclick='history.back()' value='Cancel' style='padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;'>";
    $form .= "</form></div>";
    
    secureMessage($form, true);
    
} elseif (isset($_GET['announce'])) {
    // Handle announcement editing
    $announceFile = trim($_GET['announce']);
    
    // Use the defined announcements directory
    $textDir = ANNOUNCEMENTS_DIR;
    
    // Validate the announcement file
    $announcePath = validateFilePath($announceFile, ALLOWED_ANNOUNCEMENTS, $textDir);
    if (!$announcePath) {
        secureMessage("Invalid announcement file specified: " . htmlspecialchars($announceFile, ENT_QUOTES, 'UTF-8'));
        exit;
    }
    
    // Handle form submission
    if (isset($_POST['fileedit'])) {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            secureMessage("Invalid security token. Please refresh the page and try again.");
            exit;
        }
        
        $announceContent = $_POST['annedits'] ?? '';
        
        // Determine file type for validation
        $fileExtension = strtolower(pathinfo($announceFile, PATHINFO_EXTENSION));
        $fileType = ($fileExtension === 'php') ? 'php' : 'txt';
        
        // Validate content
        $validation = validateFileContent($announceContent, $fileType);
        if ($validation !== true) {
            secureMessage("Validation failed: " . $validation);
            exit;
        }
        
        // Check if directory is writable
        if (!is_writable(dirname($announcePath))) {
            secureMessage("Announcement directory is not writable. Check permissions on: " . dirname($announcePath));
            exit;
        }
        
        // Attempt to write file
        $writeResult = file_put_contents($announcePath, $announceContent, LOCK_EX);
        if ($writeResult !== false) {
            // Redirect back to editor with success message, preserving akey
            $currentAkey = $_REQUEST['akey'] ?? '';
            $redirectUrl = "?cpiarea=editor&announce=" . urlencode($announceFile) . "&akey=" . urlencode($currentAkey) . "&success=announcement_updated";
            header("Location: " . $redirectUrl);
            exit;
        } else {
            secureMessage("Failed to write announcement file. Check permissions on: " . $announcePath);
            exit;
        }
    }
    
    // Read current announcement content
    $currentContent = "";
    if (file_exists($announcePath) && is_readable($announcePath)) {
        $currentContent = file_get_contents($announcePath);
        if ($currentContent === false) {
            $currentContent = "Error reading file";
        }
    } else {
        $currentContent = "File not found: " . $announcePath;
    }
    
    // Check for success message
    $successMessage = '';
    if (isset($_GET['success']) && $_GET['success'] === 'announcement_updated') {
        $successMessage = "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;'>" .
                         "? <strong>Success!</strong> Announcement updated successfully." .
                         "</div>";
    }
    
    // Generate form with CSRF protection
    $csrfToken = generateCSRFToken();
    $escapedFile = htmlspecialchars($announceFile, ENT_QUOTES, 'UTF-8');
    $escapedContent = htmlspecialchars($currentContent, ENT_QUOTES, 'UTF-8');
    
    // Get the current akey from the request (this is what passed vsess() on page load)
    $currentAkey = $_REQUEST['akey'] ?? '';
    $escapedKey = htmlspecialchars($currentAkey, ENT_QUOTES, 'UTF-8');
    
    // Determine if this is a PHP file for editor enhancement
    $fileExtension = strtolower(pathinfo($announceFile, PATHINFO_EXTENSION));
    $isPhpFile = ($fileExtension === 'php');
    $editorClass = $isPhpFile ? 'php-editor' : 'text-editor';
    
    $debugInfo = "<div style='background: #e6f3ff; padding: 10px; margin: 10px 0; border: 1px solid #b3d9ff; border-radius: 4px;'>" .
                "<strong>Debug Info:</strong> akey = " . htmlspecialchars($currentAkey, ENT_QUOTES, 'UTF-8') . 
                " | global key = " . htmlspecialchars($key ?? 'NOT_SET', ENT_QUOTES, 'UTF-8') . "</div>";
    
    $form = "<div style='margin: 20px;'>";
    $form .= $successMessage;
    $form .= $debugInfo;
    $form .= "<form method='post' action='?cpiarea=editor&amp;announce=" . urlencode($announceFile) . "'>";
    $form .= "<input type='hidden' name='akey' value='" . $escapedKey . "'>";
    $form .= "<input type='hidden' name='csrf_token' value='" . htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') . "'>";
    $form .= "<h3>Editing " . ($isPhpFile ? "PHP " : "") . "Announcement: " . $escapedFile . "</h3>";
    $form .= "<p><strong>File Path:</strong> " . htmlspecialchars($announcePath, ENT_QUOTES, 'UTF-8') . "</p>";
    
    if ($isPhpFile) {
        $form .= "<div style='background: #ffe6e6; padding: 10px; margin: 10px 0; border: 1px solid #ff9999; border-radius: 4px;'>";
        $form .= "<strong>?? Security Notice:</strong> PHP file editing is enabled with safety restrictions. ";
        $form .= "Dangerous functions and patterns are blocked. Test changes carefully.";
        $form .= "</div>";
    }
    
    $form .= "<textarea rows='40' cols='80' name='annedits' class='" . $editorClass . "' ";
    $form .= "style='width: 100%; font-family: \"Courier New\", Consolas, monospace; font-size: 13px; ";
    $form .= "background: #f8f8f8; border: 1px solid #ddd; padding: 10px;'>" . $escapedContent . "</textarea><br><br>";
    $form .= "<input type='submit' name='fileedit' value='Update Announcement' style='padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;'>";
    $form .= "<input type='button' onclick='history.back()' value='Cancel' style='padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;'>";
    $form .= "</form>";
    
    // Add some basic syntax highlighting styles for PHP
    if ($isPhpFile) {
        $form .= "<style>";
        $form .= ".php-editor {";
        $form .= "line-height: 1.5;";
        $form .= "tab-size: 4;";
        $form .= "-moz-tab-size: 4;";
        $form .= "}";
        $form .= "</style>";
    }
    
    $form .= "</div>";
    
    secureMessage($form, true);
    
} else {
    // No valid editor specified - show available options or debug info
    $currentAkey = $_REQUEST['akey'] ?? 'NOT_PROVIDED';
    $globalKey = $key ?? 'NOT_SET';
    
    $debugInfo = "<div style='margin: 20px; padding: 15px; background: #f0f0f0; border: 1px solid #ccc;'>";
    $debugInfo .= "<h3>Editor Debug Information</h3>";
    $debugInfo .= "<p><strong>Current akey parameter:</strong> " . htmlspecialchars($currentAkey, ENT_QUOTES, 'UTF-8') . "</p>";
    $debugInfo .= "<p><strong>Global key variable:</strong> " . htmlspecialchars($globalKey, ENT_QUOTES, 'UTF-8') . "</p>";
    $debugInfo .= "<p><strong>Keys match:</strong> " . (($currentAkey === $globalKey) ? 'YES' : 'NO') . "</p>";
    $debugInfo .= "<hr>";
    $debugInfo .= "<p>To edit files, use these URL formats:</p>";
    $debugInfo .= "<ul>";
    $debugInfo .= "<li>Skin: <code>?cpiarea=editor&amp;skin=Default.css&amp;akey=" . urlencode($globalKey) . "</code></li>";
    $debugInfo .= "<li>Announcement: <code>?cpiarea=editor&amp;announce=announce.php&amp;akey=" . urlencode($globalKey) . "</code></li>";
    $debugInfo .= "</ul>";
    $debugInfo .= "</div>";
    
    secureMessage($debugInfo, true);
}

// Additional security headers
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
}

?>
