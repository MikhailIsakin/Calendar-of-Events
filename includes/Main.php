<?php
/**
 * Calendar of Events - Main
 *
 * @package Calendar of Events
 * @since   1.0
 */

// Include the COE_Event class.
if ( ! class_exists( 'COE_Event' ) ) {
    include_once dirname( __FILE__ ) . '/Event.php';
}

// Include the COE_Widget class.
if ( ! class_exists( 'COE_Widget' ) ) {
    include_once dirname( __FILE__ ) . '/Widget.php';
}

class COE_Main {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'coe_admin_enqueue_assets' ) );
        add_action( 'wp_enqueue_scripts',  array( $this, 'coe_front_enqueue_assets' ) );

        add_action( 'wp_ajax_get_events', array( $this, 'events_of_the_month' ) );
        add_action( 'wp_ajax_nopriv_get_events', array( $this, 'events_of_the_month' ) );
    }

    function coe_admin_enqueue_assets() {
        wp_enqueue_style( 'wp-coe-css', plugin_dir_url( __FILE__ ) . '../assets/css/wp-coe.css' );
    }

    function coe_front_enqueue_assets() {
        wp_enqueue_style( 'fc-core-css', plugin_dir_url( __FILE__ ) . '../assets/lib/fc/core/main.css' );
        wp_enqueue_style( 'fc-daygrid-css', plugin_dir_url( __FILE__ ) . '../assets/lib/fc/daygrid/main.css' );
        wp_enqueue_script( 'fc-core', plugin_dir_url( __FILE__ ) . '../assets/lib/fc/core/main.js' );
        wp_enqueue_script( 'fc-daygrid', plugin_dir_url( __FILE__ ) . '../assets/lib/fc/daygrid/main.js' );
        wp_enqueue_script( 'wp-coe', plugin_dir_url( __FILE__ ) . '../assets/js/wp-coe.js', array( 'jquery' ) );
    }

    function events_of_the_month() {
        $args = array(
            'numberposts' => -1,
            'post_type' => 'calendar-event',
            'meta_key' => 'year_month',
            'meta_value' => $_POST[ 'date' ],
        );
        $events = get_posts( $args );

        $events_data = array();
        foreach( $events as $event ){
            setup_postdata( $event );
            array_push( $events_data, array( $event->day, $event->post_title, $event->post_content ) );
        }
        wp_reset_postdata();

        echo json_encode( $events_data );
        die;
    }

    /**
     * Create instance.
     *
     * @return COE_Main instance.
     */
    public static function get_instance() {
        static $instance;

        if ( ! isset( $instance ) ) {
            $instance = new COE_Main;
        }

        return $instance;
    }
}

/**
 * Event instance.
 *
 * Returns the Event instance of plugin to prevent the need to use globals.
 *
 * @return COE_Event
 */
if( ! function_exists( 'wp_coe_event' ) ) {
    function wp_coe_event() {
        return COE_Event::get_instance();
    }

    wp_coe_event();
}

/**
 * Widget instance.
 *
 * Returns the Widget instance of plugin to prevent the need to use globals.
 *
 * @return COE_Widget
 */
if( ! function_exists( 'wp_coe_widget' ) ) {
    function wp_coe_widget() {
        return COE_Widget::get_instance();
    }

    wp_coe_widget();
}