<?php

namespace WeDevs\Academy\Admin;

if ( !class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . '/wp-admin/includes/class-wp-list-table.php';
}

class Address_List extends \WP_List_Table {
    function __construct() {
        parent::__construct( array(
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => false,
        ) );
    }

    /**
     * Get columns
     *
     * @return void
     */
    function get_columns() {
        return array(
            'cb'         => '<input type="checkbox" />',
            'name'       => __( 'Name', 'wedevs-academy' ),
            'address'    => __( 'Address', 'wedevs-academy' ),
            'phone'      => __( 'Phone', 'wedevs-academy' ),
            'created_at' => __( 'Date', 'wedevs-academy' ),
        );
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'name'       => array( 'name', true ),
            'created_at' => array( 'created_at', true ),
        );
        return $sortable_columns;
    }

    /**
     * Formats and sends default comments
     *
     * @param [type] $item
     * @param [type] $column_name
     * @return void
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'value':

                break;
            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
                break;
        }
    }

    /**
     * Formats name column
     *
     * @param [type] $item
     * @return void
     */
    protected function column_name( $item ) {
        $actions = array();

        $actions['edit'] = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=wedevs-academy&action=edit&id=' . $item->id ),
            __( 'Edit', 'wedevs-academy' ), __( 'Edit', 'wedevs-academy' ) );

        $actions['delete'] = sprintf( '<a href="#" class="submitdelete" data-id="%s">%s</a>', $item->id,
            __( 'Delete', 'wedevs-academy' )            
        );
        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s',
            admin_url( 'admin.php?page=wedevs-academy&action=view&id=' . $item->id ),
            $item->name,
            $this->row_actions( $actions )
        );
    }

    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="book_id[]" value="%d" />', $item->id
        );
    }
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $column, $hidden, $sortable );

        $per_page     = 20;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = array(
            'number' => $per_page,
            'offset' => $offset,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'];
        }

        $this->items = wd_ac_get_addresses( $args );
        $this->set_pagination_args( array(
            'total_items' => wd_ac_get_address_count(),
            'per_page'    => $per_page,
        ) );
    }
}
