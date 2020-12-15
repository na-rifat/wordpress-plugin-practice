<?php
    namespace WeDevs\Academy;

    /**
     * User handler class
     */
    class User {

        /**
         * Builds the user handler function
         */
        function __construct() {
            add_action( 'show_user_profile', [$this, 'badge_field'] );
            add_action( 'edit_user_profile', [$this, 'badge_field'] );

            add_action( 'personal_options_update', [$this, 'add_badge'] );
            add_action( 'edit_user_profile_update', [$this, 'add_badge'] );
        }

        /**
         * Adds a badge field to users profile
         *
         * @return void
         */
        public function badge_field() {
            ob_start();
        ?>
    <table class="form-table">
    <tr>
    <th>
        <label for="trusted_badge">Trusted badge:</label></th>
    <td>
        <input type="checkbox" name="trusted_badge" id="trusted_badge">
    </td>
    </tr>
    </table>
    <?php
        echo ob_get_clean();
            }

            /**
             * Adds badge to the database
             *
             * @return void
             */
            public function add_badge( $user_id ) {
                if ( !current_user_can( 'edit_user' ) ) {
                    return;
                }

                $trusted_badge = isset( $_POST['trusted_badge'] ) ? true : false;

                update_user_meta( $user_id, 'trusted_badge', $trusted_badge );
        }
    }