<?php
/*
Plugin Name: Gravity Form Quiz Customizer
Description: Add custom settings to the Gravity Forms form settings page.
Version: 1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class GF_Quiz_Customizer {
    public function __construct() {
        // Initialize the plugin
        add_action( 'admin_init', array( $this, 'form_settings_init' ) );
        add_filter( 'gform_form_settings_menu', array( $this, 'add_form_settings_menu' ), 10, 2 );
    }

    // Add custom settings menu
    public function add_form_settings_menu( $menu_items, $form_id ) {
        $menu_items[] = array(
            'name'  => 'quiz_customizer',
            'label' => __( 'Quiz Customizer', 'gravityforms' ),
            'href'  => add_query_arg( 'subview', 'quiz_customizer', admin_url( 'admin.php?page=gf_edit_forms&view=settings&subview=quiz_customizer' ) )
        );
        return $menu_items;
    }

    // Initialize the settings page
    public function form_settings_init() {
        $subview = rgget( 'subview' );

        // If the settings page is for our custom settings page
        if ( GFForms::get_page_query_arg() == 'gf_edit_forms' && rgget( 'view' ) == 'settings' && $subview == 'quiz_customizer' ) {
            add_action( 'gform_form_settings_page_quiz_customizer', array( $this, 'form_settings_page' ) );
        }
    }

    // Render the settings page
    public function form_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Quiz Customizer Settings', 'gravityforms' ); ?></h1>

            <form method="post" action="">
                <?php
                // Add nonce for security
                wp_nonce_field( 'gf_quiz_customizer_save_settings', 'gf_quiz_customizer_nonce' );

                // Get the current settings values
                $feature_image = get_option( 'gf_quiz_customizer_feature_image' );
                $is_enabled = get_option( 'gf_quiz_customizer_is_enabled', '0' );

                // Display the settings fields
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e( 'Feature Image', 'gravityforms' ); ?></th>
                        <td>
                            <input type="text" name="gf_quiz_customizer_feature_image" value="<?php echo esc_url( $feature_image ); ?>" class="regular-text" />
                            <button type="button" class="button" onclick="openMediaUploader()">Select Image</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e( 'Enable Quiz Form', 'gravityforms' ); ?></th>
                        <td>
                            <input type="checkbox" name="gf_quiz_customizer_is_enabled" value="1" <?php checked( $is_enabled, '1' ); ?> />
                            <label for="gf_quiz_customizer_is_enabled"><?php _e( 'Check to enable the quiz form.', 'gravityforms' ); ?></label>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <input type="submit" name="gf_quiz_customizer_save" id="submit" class="button-primary" value="<?php _e( 'Save Settings', 'gravityforms' ); ?>" />
                </p>
            </form>
        </div>
        <script>
            function openMediaUploader() {
                var mediaUploader = wp.media({
                    title: 'Select Feature Image',
                    button: {
                        text: 'Select Image'
                    },
                    multiple: false
                }).open();

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    document.querySelector('input[name="gf_quiz_customizer_feature_image"]').value = attachment.url;
                });
            }
        </script>
        <?php
    }

    // Save settings after the form is submitted
    public function save_form_settings() {
        if ( isset( $_POST['gf_quiz_customizer_save'] ) && check_admin_referer( 'gf_quiz_customizer_save_settings', 'gf_quiz_customizer_nonce' ) ) {
            $feature_image = isset( $_POST['gf_quiz_customizer_feature_image'] ) ? esc_url_raw( $_POST['gf_quiz_customizer_feature_image'] ) : '';
            $is_enabled = isset( $_POST['gf_quiz_customizer_is_enabled'] ) ? '1' : '0';

            update_option( 'gf_quiz_customizer_feature_image', $feature_image );
            update_option( 'gf_quiz_customizer_is_enabled', $is_enabled );
        }
    }
}

// Instantiate the plugin class
new GF_Quiz_Customizer();
