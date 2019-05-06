<?php
/**
 * Calendar of Events - Event
 *
 * @package Calendar of Events
 * @since   1.0
 */

class COE_Event {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'coe_add_menu_page' ) );
    }

    function coe_add_menu_page() {
        add_menu_page( 'Calendar of Events', 'Calendar of Events', 'manage_options', 'calendarofevents', array( $this, 'coe_page' ) );
    }

    function coe_page() {
        if ( current_user_can( 'manage_options' ) ) {

            $safe_values = array( '0', '1' );
            $coe_hidden_field_name = 'coe_submit_hidden';
            $change_flag = '0';

            if ( ! empty( $_POST[ $coe_hidden_field_name ] ) ) {
                if ( in_array( $_POST[ $coe_hidden_field_name ], $safe_values, true ) ) {
                    $change_flag = $_POST[ $coe_hidden_field_name ];
                } else {
                    wp_die( 'Invalid data' );
                }
            }

            if ( ! empty( $_POST ) && check_admin_referer( 'add-event', 'add-event-nonce-field' ) ) {

                if ( $change_flag === '1' ) {

                    $tags = explode( ",", preg_replace( '/\s+/' , '' , $_POST[ 'coe_tags' ] ) );
                    $date = explode("-", $_POST[ 'coe_date' ] );

                    $event_data = array(
                        'post_type'     => 'calendar-event',
                        'post_status'   => 'publish',
                        'post_title'    => $_POST[ 'coe_title' ],
                        'post_content'  => $_POST[ 'coe_description' ],
                        'meta_input'     => array( 'year_month' => $date[0] . '-' . $date[1], 'day' => $date[2] ),
                        'tags_input'     => $tags,
                    );

                    wp_insert_post( wp_slash( $event_data ) );

                    ?>
                    <div class="updated">
                        <p>
                            <strong><?php _e( 'Event added.', 'coe_trans_domain' ); ?></strong>
                        </p>
                    </div>
                    <?php
                }
            }

            ?>
            <div class="wrap">

                <h2><?php _e( 'Add Event', 'ceo_trans_domain' ) ?></h2>

                <hr>

                <form name="coe-add-event-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER[ 'REQUEST_URI' ] ); ?>">
                    <?php wp_nonce_field( 'add-event', 'add-event-nonce-field' ); ?>

                    <input type="hidden" name="<?php echo $coe_hidden_field_name; ?>" value="1">

                    <div>
                        <h3 class="coe-input-title"><?php _e( 'Date', 'coe_trans_domain' ); ?></h3>
                        <input type="date" required class="coe-input" name="coe_date">
                    </div>

                    <div>
                        <h3 class="coe-input-title"><?php _e( 'Title', 'coe_trans_domain' ); ?></h3>
                        <input type="text" required class="coe-input" name="coe_title">
                    </div>

                    <div>
                        <h3 class="coe-input-title"><?php _e( 'Description', 'coe_trans_domain' ); ?></h3>
                        <textarea rows="5" required class="coe-textarea" name="coe_description"></textarea>
                    </div>

                    <div>
                        <h3 class="coe-input-title"><?php _e( 'Tags', 'coe_trans_domain' ); ?></h3>
                        <input type="text" class="coe-input" name="coe_tags">
                    </div>

                    <div class="submit">
                        <input type="submit" name="Submit" class="button button-primary" value="<?php _e( 'Save', 'coe_trans_domain' ) ?>" />
                    </div>

                </form>

            </div>
            <?php
        }
    }

    /**
     * Create instance.
     *
     * @return COE_Event instance.
     */
    public static function get_instance() {
        static $instance;

        if ( ! isset( $instance ) ) {
            $instance = new COE_Event;
        }

        return $instance;
    }
}