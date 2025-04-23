<?php
if ( ! class_exists( 'Settings_Renderer' ) ) {

    class Settings_Renderer {
        private $fields;
        private $capability;
        private $initial_values;
        private $save_callback;
        private $after_fields;

        public function __construct( $args ) {
            $this->fields         = isset( $args['fields'] ) ? $args['fields'] : [];
            $this->capability     = isset( $args['capability'] ) ? $args['capability'] : 'manage_options';
            $this->initial_values = isset( $args['initial_values'] ) ? $args['initial_values'] : [];
            $this->save_callback  = isset( $args['save_callback'] ) ? $args['save_callback'] : '';
            $this->after_fields   = isset( $args['after_fields'] ) ? $args['after_fields'] : '';
        }

        public function render() {
            ?>
            <form method="post" action="">
                <?php
                // Render fields
                foreach ( $this->fields as $field ) {
                    $this->render_field( $field );
                }

                // Render save button
                submit_button( __( 'Save Settings', 'gravityforms' ) );

                // Call after fields callback if available
                if ( ! empty( $this->after_fields ) ) {
                    call_user_func( $this->after_fields );
                }
                ?>
            </form>
            <?php
        }

        private function render_field( $field ) {
            ?>
            <p>
                <label for="<?php echo esc_attr( $field['name'] ); ?>">
                    <?php echo esc_html( $field['label'] ); ?>
                </label><br>
                <input type="text" name="<?php echo esc_attr( $field['name'] ); ?>" value="<?php echo esc_attr( $this->initial_values[ $field['name'] ] ?? '' ); ?>" class="regular-text" />
            </p>
            <?php
        }
    }
}
