<?php

namespace WeDevs\Academy\Admin;

/**
 * The menu handler class
 */
class Menu {
    public $addressbook;
    function __construct( $addressbook ) {
        $this->addressbook = $addressbook;
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
    /**
     * add a menu to the admin panel
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'wedevs-academy';
        $capability  = 'manage_options';
        $hook        = add_menu_page( __( 'WeDevs Academy', 'wedevs-academy' ), __( 'Academy', 'wedevs-academy' ), $capability, $parent_slug, [$this->addressbook, 'plugin_page'], 'dashicons-filter' );
        add_submenu_page( $parent_slug, __( 'Address Book', 'wedevs-academy' ), __( 'Address Book', 'wedevs-academy' ), $capability, $parent_slug, [$this->addressbook, 'plugin_page'] );
        add_submenu_page( $parent_slug, __( 'Settings', 'wedevs-academy' ), __( 'Setting', 'wedevs-academy' ), $capability, 'wedev-academy-setting', array( $this, 'settings' ) );

        add_action( "admin_head-$hook", [$this, 'enqueue_assets'] );        
    }
    /**
     * settings page
     *
     * @return void
     */
    public function settings() {
        echo "This is settings page";
    }

    public function enqueue_assets() {
        wp_enqueue_script( 'academy-admin-script' );
        wp_enqueue_style( 'academy-admin-style' );
    }
}