<?php
/**
 * PathInfoFix.php - Portable PATH_INFO Routing Fix
 * For Practical Lightning ARCADE (PLA) and PHP-Quick-Arcade installations
 * 
 * This file fixes the common PATH_INFO routing issue where URLs like:
 * /index.php/arcade/gamedata/GameName/index.php are incorrectly processed
 * 
 * Usage: Include this file at the very beginning of your main index.php:
 * require_once "./PathInfoFix.php";
 * 
 * @version 1.0
 * @author  Created for PLA Community
 * @license Free to use and modify
 */
// Modified: 9/4/2025   By: MaSoDo (Claude.AI's idea ;)
// Prevent direct access to this file
if (basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"])) {
    die("Direct access not permitted.");
}

/**
 * Fix PATH_INFO routing issues that cause styling problems and incorrect URLs
 */
function fix_pathinfo_routing() {
    // Check if PATH_INFO is set and not empty
    if (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) {
        redirect_to_clean_url('PATH_INFO detected');
        return;
    }
    
    // Check for malformed URLs with index.php/something pattern
    if (isset($_SERVER['REQUEST_URI']) && 
        preg_match('#/index\.php/(.+)#', $_SERVER['REQUEST_URI'], $matches)) {
        redirect_to_clean_url('Malformed URL detected');
        return;
    }
    
    // Additional check for common problematic patterns
    if (isset($_SERVER['REQUEST_URI']) && 
        strpos($_SERVER['REQUEST_URI'], '/gamedata/') !== false &&
        strpos($_SERVER['REQUEST_URI'], '/index.php/') !== false) {
        redirect_to_clean_url('Game data URL issue detected');
        return;
    }
}

/**
 * Redirect to the clean base URL of the arcade
 */
function redirect_to_clean_url($reason = '') {
    // Determine the base URL dynamically
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Get the directory path of the current script
    $script_dir = dirname($_SERVER['SCRIPT_NAME']);
    
    // Ensure trailing slash
    $base_url = $protocol . '://' . $host . rtrim($script_dir, '/') . '/';
    
    // Optional: Log the redirect for debugging (remove in production)
    if (defined('PLA_DEBUG') && PLA_DEBUG === true && !empty($reason)) {
        error_log("PathInfoFix: Redirecting due to: $reason - From: " . $_SERVER['REQUEST_URI'] . " To: $base_url");
    }
    
    // Perform the redirect
    header("Location: $base_url", true, 301);
    exit;
}

/**
 * Initialize the PATH_INFO fix
 * This function is called automatically when the file is included
 */
function init_pathinfo_fix() {
    // Only run the fix if we're dealing with a web request
    if (php_sapi_name() === 'cli') {
        return;
    }
    
    // Run the fix
    fix_pathinfo_routing();
}

// Auto-initialize when file is included
init_pathinfo_fix();

// Optional: Provide a way to manually check for issues (for debugging)
if (!function_exists('check_pathinfo_status')) {
    function check_pathinfo_status() {
        $status = array(
            'path_info' => isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : 'Not set',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Not set',
            'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'Not set',
            'has_pathinfo_issue' => (
                (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) ||
                (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/index.php/') !== false)
            )
        );
        return $status;
    }
}

?>
