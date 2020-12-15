<?php
namespace WeDevs\Academy\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode{
    /**
     * Initilizes the shortcode class
     */
    function __construct()
    {
        add_shortcode('wedevs-academy', [$this, 'render_shortcode']);
    }
   /**
    * 
    * Renderes the shortcode
    * @param [array] $atts
    * @param string $content
    * @return void
    */
    public function render_shortcode($atts, $content = ''){
        wp_enqueue_script('academy-script');
        wp_enqueue_style('academy-style');
        echo wd_convert_slash( WD_ACADEMY_PATH . '/assets/js/admin.js' );
    }
}