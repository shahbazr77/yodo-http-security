<?php /**
 * Plugin Name: Yodo Http Security
 * Plugin URI: https://yodohttpssecurity/
 * Description: This plugin is essential for configure the HTTP Security Headers.
 * Version: 0.01
 * Requires at least:  5.2
 * Requires PHP: 7.2
 * Author: Yodo Developers
 * Author URI: https://yodohttpssecurity/
 * Text Domain: yodo-security
 */

if (in_array('yodo-http-security/yodo-http-security.php', apply_filters('active_plugins', get_option('active_plugins')))) {
// Add custom rules to .htaccess file after permalink update
    function yodo_htaccess_rules_after_permalink_update()
    {
        $security_headers = "\n<IfModule mod_headers.c>\nHeader set Strict-Transport-Security \"max-age=31536000; env=HTTPS\"
Header set X-XSS-Protection \"1; mode=block\"
Header set X-Content-Type-Options \"nosniff\"
Header set X-Frame-Options \"SAMEORIGIN\"
Header set Referrer-Policy: \"strict-origin-when-cross-origin\"
Header set Permissions-Policy \"accelerometer=(), camera=(), fullscreen=(self), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(), usb=(), xr-spatial-tracking=()\"
Header set Access-Control-Allow-Origin: true
Header set Content-Security-Policy: \"upgrade-insecure-requests\"
</IfModule>\n";
        $htaccess_file = ABSPATH . '.htaccess';

        // Read the current .htaccess file content
        $current_content = file_get_contents($htaccess_file);
        // Check if security headers already exist in the .htaccess file
        if (strpos($current_content, 'mod_headers.c') === false) {
            // Append security headers to the .htaccess file
            file_put_contents($htaccess_file, $security_headers, FILE_APPEND | LOCK_EX);
        }
    }

// Flush rewrite rules after permalink update
    function yodo_flush_rewrite_rules_after_permalink_update()
    {
        add_action('init', 'flush_rewrite_rules');
    }

    add_action('after_switch_theme', 'yodo_flush_rewrite_rules_after_permalink_update');
    add_action('updated_option', 'yodo_flush_rewrite_rules_after_permalink_update');
    add_action('init', 'yodo_htaccess_rules_after_permalink_update');
    
    if(!function_exists('add_security_menu')) {
        function add_security_menu()
        {
            $page_title = "Security";
            $menu_title = "Yodo Security";
            $capability = "manage_options";
            $menu_slug = "security.php";
            $icon_url = "dashicons-superhero";
            $position = "12";
            add_menu_page($page_title,$menu_title,$capability, $menu_slug, 'security_show_menu', $icon_url, $position);
        }
    }
    add_action("admin_menu","add_security_menu");
    if(!function_exists('security_show_menu')){
        function security_show_menu(){
            echo '<h1>Check Your HTTTP Security</h1>';
            function generateRandomString($length = 10) {
                return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
            }
            $site_url=get_site_url()."/?".generateRandomString();
            //$site_url="https://yodo.club";
            $security_header = "https://securityheaders.com/?q=";
            $redirect_url=$security_header.$site_url;

            echo '<a style=" font:14px Arial;text-decoration: none;background-color: #2271b1;color: #fff;padding: 8px 10px 8px 10px;margin-top:15px;display:inline-block;" class="btn btn-success" href="'.$redirect_url.'" target="_blank">Check HTTP Security</a>';

        }
    }
}

register_activation_hook(__FILE__,'yodo_http_security_activate');
if(!function_exists('yodo_http_security_activate')){
    function yodo_http_security_activate(){

        function yodo_htaccess_rules_after_permalink_update_plugin()
        {
            $security_headers = "\n<IfModule mod_headers.c>\nHeader set Strict-Transport-Security \"max-age=31536000; env=HTTPS\"
Header set X-XSS-Protection \"1; mode=block\"
Header set X-Content-Type-Options \"nosniff\"
Header set X-Frame-Options \"SAMEORIGIN\"
Header set Referrer-Policy: \"strict-origin-when-cross-origin\"
Header set Permissions-Policy \"accelerometer=(), camera=(), fullscreen=(self), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(), usb=(), xr-spatial-tracking=()\"
Header set Access-Control-Allow-Origin: true
Header set Content-Security-Policy: \"upgrade-insecure-requests\"
</IfModule>\n";
            $htaccess_file = ABSPATH . '.htaccess';

            // Read the current .htaccess file content
            $current_content = file_get_contents($htaccess_file);
            // Check if security headers already exist in the .htaccess file
            if (strpos($current_content, 'mod_headers.c') === false) {
                // Append security headers to the .htaccess file
                file_put_contents($htaccess_file, $security_headers, FILE_APPEND | LOCK_EX);
            }
        }

// Flush rewrite rules after permalink update
        function yodo_flush_rewrite_rules_after_permalink_update_plugin()
        {
            add_action('init', 'flush_rewrite_rules');
        }

        add_action('after_switch_theme', 'yodo_flush_rewrite_rules_after_permalink_update_plugin');
        add_action('updated_option', 'yodo_flush_rewrite_rules_after_permalink_update_plugin');
        add_action('init', 'yodo_htaccess_rules_after_permalink_update_plugin');

    }
}

//incase of deactivate the plugin
register_deactivation_hook(__FILE__,'yodo_http_security_deactivate');
if(!function_exists('yodo_http_security_deactivate')){
    function yodo_http_security_deactivate(){
       // flush_rewrite_rules();

        $htaccess_file = ABSPATH . '.htaccess';
        // Read the current .htaccess file content
        $current_content = file_get_contents($htaccess_file);

        $htaccessFile = ABSPATH . '.htaccess';
        $header_rules = "
                <IfModule mod_headers.c>
                Header set Strict-Transport-Security \"max-age=31536000; env=HTTPS\"
                Header set X-XSS-Protection \"1; mode=block\"
                Header set X-Content-Type-Options \"nosniff\"
                Header set X-Frame-Options \"SAMEORIGIN\"
                Header set Referrer-Policy: \"strict-origin-when-cross-origin\"
                Header set Permissions-Policy \"accelerometer=(), camera=(), fullscreen=(self), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(), usb=(), xr-spatial-tracking=()\"
                Header set Access-Control-Allow-Origin: true
                Header set Content-Security-Policy: \"upgrade-insecure-requests\"
                </IfModule>";

        $htaccessContent = file_get_contents($htaccessFile);
        $updated_rules=chop($htaccessContent,$header_rules);
        file_put_contents($htaccessFile, $updated_rules);

    }
}
