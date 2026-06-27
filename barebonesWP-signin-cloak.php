<?php
/**
 * Plugin Name: BarebonesWP signin cloak
 */

defined( 'ABSPATH' ) || exit;

// IMPORTANT: Replace 'my-secret-entry-point' with your own unique, private slug.
define( 'SECRET_LOGIN_SLUG', 'my-secret-entry-point' );

add_action( 'init', function() {

    if ( is_user_logged_in() ) return;

    $request = $_SERVER['REQUEST_URI'] ?? '';
    $is_login = strpos( $request, 'wp-login.php' ) !== false;
    $is_admin = strpos( $request, '/wp-admin' ) !== false;

    if ( $is_login && $_SERVER['REQUEST_METHOD'] === 'POST' ) return;
    $action = isset( $_GET['action'] ) ? sanitize_key( $_GET['action'] ) : '';
    if ( $is_login && in_array( $action, ['rp','resetpass','lostpassword','logout'], true ) ) return;

// Secret URL — serve the real login page. 
// note, + 300 gives you five minutes (300 seconds) to enter your credentials. Adjust if you need more time

if ( trim( $_SERVER['REQUEST_URI'], '/' ) === SECRET_LOGIN_SLUG ) {
    setcookie( 'sys_id_token', 'allow', time() + 300, '/wp-login.php', '', true, true );
    require_once ABSPATH . 'wp-login.php';
    exit;
}

    // Block everything else
    if ( $is_login || $is_admin ) {
        status_header( 404 );
        exit;
    }
}, 1 );

// Rewrite rule so /portal loads without a 404 from WP's router
add_action( 'init', function() {
    add_rewrite_rule( '^' . SECRET_LOGIN_SLUG . '$', 'index.php?' . SECRET_LOGIN_SLUG . '=1', 'top' );
}, 1 );

add_filter( 'query_vars', function( $vars ) {
    $vars[] = SECRET_LOGIN_SLUG;
    return $vars;
});