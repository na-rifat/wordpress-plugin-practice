<?php
namespace WeDevs\Academy\Traits;
/**
 * error handler trait
 */
trait Form_Error {
    /**
     * Hold the error
     *
     * @var array
     */
    public $errors = array();

    /**
     * Check if the form has error
     *
     * @param [type] $key
     * @return boolean
     */
    public function has_error( $key ) {
        return isset( $this->errors[$key] );
    }
    /**
     * Get the error by key
     *
     * @param [type] $key
     * @return void
     */
    public function get_error( $key ) {
        if ( isset( $this->errors[$key] ) ) {
            return $this->errors[$key];
        }
        return false;
    }
}