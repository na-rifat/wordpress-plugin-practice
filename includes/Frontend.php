<?php
namespace WeDevs\Academy;

/**
 * Frontend class
 */
class Frontend {
    /**
     * Initilizes frontend class
     */
    function __construct() {
        new Frontend\Shortcode();
        new Frontend\Enquiry();
    }
}