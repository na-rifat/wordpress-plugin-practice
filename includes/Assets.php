<?php
namespace WeDevs\Academy;

class Assets {
    function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'enqueu_assets'] );
        add_action( 'admin_enqueue_scripts', [$this, 'enqueu_assets'] );
    }

    public function get_scripts() {
        return [
            'academy-script'         => [
                'src'     => WD_ACADEMY_JS . '/frontend.js',
                'version' => filemtime( wd_convert_slash( WD_ACADEMY_PATH . '/assets/js/frontend.js' ) ),
                'deps'    => ['jquery'],
            ],
            'academy-admin-script'   => [
                'src'     => WD_ACADEMY_JS . '/admin.js',
                'version' => filemtime( wd_convert_slash( WD_ACADEMY_PATH . '/assets/js/admin.js' ) ),
                'deps'    => ['jquery', 'wp-util'],
            ],
            'academy-enquiry-script' => [
                'src'     => WD_ACADEMY_JS . '/enquiry.js',
                'version' => filemtime( wd_convert_slash( WD_ACADEMY_PATH . '/assets/js/enquiry.js' ) ),
                'deps'    => ['jquery'],
            ],
        ];
    }

    public function get_styles() {
        return [
            'academy-style'         => [
                'src'     => WD_ACADEMY_CSS . '/frontend.css',
                'version' => filemtime( wd_convert_slash( WD_ACADEMY_PATH . '/assets/css/frontend.css' ) ),
            ],
            'academy-admin-style'   => [
                'src'     => WD_ACADEMY_CSS . '/admin.css',
                'version' => filemtime( wd_convert_slash( WD_ACADEMY_PATH . '/assets/css/admin.css' ) ),
            ],
            'academy-enquiry-style' => [
                'src'     => WD_ACADEMY_CSS . '/enquiry.css',
                'version' => filemtime( wd_convert_slash( WD_ACADEMY_PATH . '/assets/css/enquiry.css' ) ),
            ],
        ];
    }

    public function enqueu_assets() {
        $scripts = $this->get_scripts();
        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        $styles = $this->get_styles();

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'academy-enquiry-script', 'wedevsAcademy', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'error'   => __( 'Something went wrong', 'wedevs-academy' ),
        ] );
        wp_localize_script( 'academy-admin-script', 'wedevsAcademy', [
            'nonce'   => wp_create_nonce( 'wd-ac-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'wedevs-academy' ),
            'error'   => __( 'Something went wrong', 'wedevs-academy' ),
        ] );
    }
}
