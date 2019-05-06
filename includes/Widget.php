<?php
/**
 * Calendar of Events - Widget
 *
 * @package Calendar of Events
 * @since   1.0
 */

class COE_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'COE_Widget',
            __( 'Calendar of Events', 'coe_trans_domain' ),
            array( 'description' => __( 'Calendar of Events Widget', 'coe_trans_domain' ), )
        );

        add_action( 'widgets_init', array( $this, 'coe_register_widget' ) );
    }

    function widget( $args, $instance ) {
        echo $args[ 'before_widget' ]; ?>
        <div id='coe'></div>
        <?php echo $args[ 'after_widget' ];
    }

    function coe_register_widget() {
        register_widget( 'COE_Widget' );
    }

    /**
     * Create instance.
     *
     * @return COE_Widget instance.
     */
    public static function get_instance() {
        static $instance;

        if ( ! isset( $instance ) ) {
            $instance = new COE_Widget;
        }

        return $instance;
    }
}