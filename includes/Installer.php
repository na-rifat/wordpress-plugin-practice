<?php

namespace WeDevs\Academy;

/**
 * Installer handler class
 */
class Installer {
    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }
    /**
     * Stores the current version
     *
     * @return void
     */
    public function add_version() {
        $installed = get_option( 'wd_academy_installed' );
        if ( $installed ) {
            update_option( 'wd_academy_installed', time() );
        }
        update_option( 'wd_academy_version', WD_ACADEMY_VERSION );
    }
    /**
     * Create necessery database tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $schema          = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}wc_addresses` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
            `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_by` bigint(20) unsigned NOT NULL,
            `created_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) $charset_collate";
        if ( !function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . '/wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }

}