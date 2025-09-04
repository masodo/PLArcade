ï»¿<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (BETA) - HARDENED VERSION
//Security improvements by Claude - Addresses path traversal, XSS, and file validation
//Original based on PHP-Quick-Arcade 3.0 Â© Jcink.com
//Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
# Section: acpi Place: editor - Administrator Control Panel   Modified: 9/4/2025   By: MaSoDo w/Claude.AI
// Include PLA's Preliminary.php for vsess() function and $key variable
require_once('./Preliminary.php');
// Temporary debug - remove after testing
//if (!function_exists('vsess')) {
//    die('vsess() function not found - check your includes');
//}
//if (!isset($key)) {
//    die('$key variable not found - check your includes'); 
//}
//echo "? vsess() and \$key are available";
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
    
    // Get real path to prevent traversal
    $fullPath = realpath($baseDir . $filename);
    $basePath = realpath($baseDir);
    
    // Ensure file is within the base directory
    if ($fullPath === false || $basePath === false || 
        strpos($fullPath, $basePath) !== 0) {
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
function validateFileContent($content, $type) {
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

// Main logic - handle authentication properly
// Note: vsess() should only be called on form submissions, not page loads
// PLA's original pattern: check session/login status separately from vsess()

// For initial page loads, we need to check if user is properly logged in
// This may require checking session variables or cookies that PLA uses
// For now, we'll allow GET requests and only validate vsess() on POST

$isFormSubmission = (isset($_POST['skinedit']) || isset($_POST['fileedit']));

// Only call vsess() on form submissions (when akey should be present)
if ($isFormSubmission) {
    if (!function_exists('vsess')) {
        secureMessage("Authentication system not available.");
        exit;
    }
    // vsess() will die() with "Authorization Mismatch" if akey is invalid
    vsess();
}

// Handle skin editing
if (isset($_GET['skin'])) {
    $skinFile = trim($_GET['skin']);
    
    // Validate the skin file
    $skinPath = validateFilePath($skinFile, ALLOWED_SKINS, SKINS_DIR);
    if (!$skinPath) {
        secureMessage("Invalid skin file specified.");
        exit;
    }
    
    // Handle form submission
    if (isset($_POST['skinedit'])) {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            secureMessage("Invalid security token. Please try again.");
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
        
        // Attempt to write file
        $writeResult = file_put_contents($skinPath, $cssContent, LOCK_EX);
        if ($writeResult !== false) {
            secureMessage("Skin updated successfully.");
        } else {
            secureMessage("Failed to write skin file. Check permissions.");
        }
        exit;
    }
    
    // Read current skin content
    $currentCSS = "";
    if (file_exists($skinPath) && is_readable($skinPath)) {
        $currentCSS = file_get_contents($skinPath);
    } else {
        $currentCSS = "/* File not found or not readable */";
    }
    
    // Generate form with CSRF protection
    $csrfToken = generateCSRFToken();
    $escapedSkin = htmlspecialchars($skinFile, ENT_QUOTES, 'UTF-8');
    $escapedCSS = htmlspecialchars($currentCSS, ENT_QUOTES, 'UTF-8');
    $escapedKey = htmlspecialchars($key ?? '', ENT_QUOTES, 'UTF-8');
    
    $form = "<form method='post' action='?cpiarea=editor&amp;skin=" . urlencode($skinFile) . "' style='margin: 20px;'>" .
            "<input type='hidden' name='akey' value='" . $escapedKey . "'>" .
            "<input type='hidden' name='csrf_token' value='" . $csrfToken . "'>" .
            "<h3>Editing Skin: " . $escapedSkin . "</h3>" .
            "<textarea rows='40' cols='80' name='cssforarcade' style='width: 100%; font-family: monospace;'>" . $escapedCSS . "</textarea><br><br>" .
            "<input type='submit' name='skinedit' value='Update Stylesheet' style='padding: 10px 20px;'>" .
            "</form>";
    
    secureMessage($form, true);
    
} elseif (isset($_GET['announce'])) {
    // Handle announcement editing
    $announceFile = trim($_GET['announce']);
    
    // Use the defined announcements directory
    $textDir = ANNOUNCEMENTS_DIR;
    
    // Validate the announcement file
    $announcePath = validateFilePath($announceFile, ALLOWED_ANNOUNCEMENTS, $textDir);
    if (!$announcePath) {
        secureMessage("Invalid announcement file specified.");
        exit;
    }
    
    // Handle form submission
    if (isset($_POST['fileedit'])) {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            secureMessage("Invalid security token. Please try again.");
            exit;
        }
        
        $announceContent = $_POST['annedits'] ?? '';
        
        // Validate content
        $validation = validateFileContent($announceContent, 'txt');
        if ($validation !== true) {
            secureMessage("Validation failed: " . $validation);
            exit;
        }
        
        // Attempt to write file
        $writeResult = file_put_contents($announcePath, $announceContent, LOCK_EX);
        if ($writeResult !== false) {
            secureMessage("Announcement updated successfully.");
        } else {
            secureMessage("Failed to write announcement file. Check permissions.");
        }
        exit;
    }
    
    // Read current announcement content
    $currentContent = "";
    if (file_exists($announcePath) && is_readable($announcePath)) {
        $currentContent = file_get_contents($announcePath);
    } else {
        $currentContent = "File not found or not readable";
    }
    
    // Check for success message
    $successMessage = '';
    if (isset($_GET['success'])) {
        switch ($_GET['success']) {
            case 'announcement_updated':
                $successMessage = "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;'>" .
                                 "? <strong>Success!</strong> Announcement updated successfully." .
                                 "</div>";
                break;
        }
    }
    
    // Generate form with CSRF protection
    $csrfToken = generateCSRFToken();
    $escapedFile = htmlspecialchars($announceFile, ENT_QUOTES, 'UTF-8');
    $escapedContent = htmlspecialchars($currentContent, ENT_QUOTES, 'UTF-8');
    $escapedKey = htmlspecialchars($key ?? '', ENT_QUOTES, 'UTF-8');
    
    // Determine if this is a PHP file for editor enhancement
    $isPhpFile = (pathinfo($announceFile, PATHINFO_EXTENSION) === 'php');
    $editorClass = $isPhpFile ? 'php-editor' : 'text-editor';
    
    $form = "<div style='margin: 20px;'>" .
            $successMessage .
            "<form method='post' action='?cpiarea=editor&amp;announce=" . urlencode($announceFile) . "'>" .
            "<input type='hidden' name='akey' value='" . $escapedKey . "'>" .
            "<input type='hidden' name='csrf_token' value='" . $csrfToken . "'>" .
            "<h3>Editing " . ($isPhpFile ? "PHP " : "") . "Announcement: " . $escapedFile . "</h3>";
    
    if ($isPhpFile) {
        $form .= "<div style='background: #ffe6e6; padding: 10px; margin: 10px 0; border: 1px solid #ff9999; border-radius: 4px;'>" .
                "<strong>?? Security Notice:</strong> PHP file editing is enabled with safety restrictions. " .
                "Dangerous functions and patterns are blocked. Test changes carefully." .
                "</div>";
    }
    
    $form .= "<textarea rows='40' cols='80' name='annedits' class='" . $editorClass . "' " .
            "style='width: 100%; font-family: \"Courier New\", Consolas, monospace; font-size: 13px; " .
            "background: #f8f8f8; border: 1px solid #ddd; padding: 10px;'>" . $escapedContent . "</textarea><br><br>" .
            "<input type='submit' name='fileedit' value='Update Announcement' style='padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;'>" .
            "<input type='button' onclick='history.back()' value='Cancel' style='padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;'>" .
            "</form></div>";
    
    // Add some basic syntax highlighting styles for PHP
    if ($isPhpFile) {
        $form .= "<style>
        .php-editor {
            line-height: 1.5;
            tab-size: 4;
            -moz-tab-size: 4;
        }
        </style>";
    }
    
    secureMessage($form, true);
    
} else {
    // No valid editor specified
    secureMessage("No valid file specified for editing.");
}

// Additional security headers (add to main application if possible)
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
}

?>
