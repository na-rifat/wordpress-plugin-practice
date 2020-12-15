<?php
namespace WeDevs\Academy;

/**
 * Ajax handler class
 */
class Ajax {
    function __construct() {
        add_action( 'wp_ajax_wd_academy_enquiry', [$this, 'submit_enquiry'] );
        add_action( 'wp_ajax_wd-academy-delete-contact', [$this, 'delete_contact'] );
    }

    public function submit_enquiry() {
        if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-ac-enquiry-form' ) ) {
            wp_send_json_error( [
                'message' => 'Nonce verification failed!',
            ] );
        }

        wp_send_json_error( [
            'message' => 'Something went wrong!',
        ] );
        exit;
    }
    public function delete_contact(){
        wd_ac_delete_address(isset($_POST['id'])?$_POST['id']:0);
        wp_send_json_success();
    }
}