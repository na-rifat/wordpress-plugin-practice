<?php
/**
 * Insert a new address
 *
 * @param array $args
 * @return object|WP_Error
 */
function wd_ac_insert_address( $args = array() ) {
    global $wpdb;

    if ( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a name', 'wedevs-academy' ) );
    }

    $defaults = array(
        'name'       => '',
        'address'    => '',
        'phone'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    );
    $data = wp_parse_args( $args, $defaults );

    if ( isset( $data['id'] ) ) {
        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            "{$wpdb->prefix}wc_addresses",
            $data,
            ['id' => $id],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ],
        );
        return $updated;
    } else {
        $inserted = $wpdb->insert( "{$wpdb->prefix}wc_addresses",
            $data,
            array(
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            )
        );
        if ( !$inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'wedevs-academy' ) );
        }
        return $wpdb->insert_id;
    }
}

/**
 * Fetchc addresses
 *
 * @param array $args
 * @return void
 */
function wd_ac_get_addresses( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC',
    );

    $args = wp_parse_args( $args, $defaults );

    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}wc_addresses
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
        )
    );
    return $items;
}

/**
 * Count addresses
 *
 * @return int
 */
function wd_ac_get_address_count() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wc_addresses" );
}

/**
 * Fetch a single contact from the DB
 *
 * @param [type] $id
 * @return void
 */
function wd_ac_get_address( $id ) {
    global $wpdb;
    

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wc_addresses WHERE id = %d", $id )
    );
}

/**
 * Delete a row
 *
 * @param int $id
 * @return int|boolean
 */
function wd_ac_delete_address( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'wc_addresses',
        array( 'id' => $id ),
        array( '%d' )
    );
}
/**
 * Convert a real path(actully replaces black slashes with slash)
 *
 * @param [string] $string
 * @return string
 */
function wd_convert_slash($string){
    return str_replace("\\", "/", $string);
}