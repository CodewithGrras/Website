<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('GFQC_Feature_Image_Setting')) {

    class GFQC_Feature_Image_Setting {

        public function __construct() {
            // Hook to display the custom setting
            add_action('gform_form_settings_page_settings', [$this, 'add_feature_image_field'] );

            // Hook to save the custom setting
            add_filter('gform_pre_form_settings_save', [$this, 'save_feature_image_field']);
        }

        /**
         * Adds the Feature Image field to the form settings UI.
         *
         * @param array $settings
         * @param array $form
         * @return array
         */
        public function add_feature_image_field($settings, $form) {
            // Only display the setting for quiz forms
            if ('quiz' !== $form['form_type']) {
                return $settings;
            }

            $value = isset($form['feature_image']) ? esc_url($form['feature_image']) : '';
            $nonce = wp_nonce_field('gfqc_save_feature_image', 'gfqc_feature_image_nonce', true, false);

            $field_html = '
                <tr>
                    <th>
                        <label for="feature_image">' . esc_html__('Feature Image URL', 'gf-quiz-customizer') . '</label>
                    </th>
                    <td>
                        <input type="url" id="feature_image" name="feature_image" value="' . $value . '" class="regular-text" placeholder="https://example.com/image.jpg" />
                        <p class="description">' . esc_html__('Add a custom feature image URL for this form.', 'gf-quiz-customizer') . '</p>
                        ' . $nonce . '
                    </td>
                </tr>
            ';

            // Add to the "Custom Quiz Settings" section
            if (!isset($settings['Custom Quiz Settings'])) {
                $settings['Custom Quiz Settings'] = array();
            }

            $settings['Custom Quiz Settings']['feature_image'] = $field_html;

            return $settings;
        }

        /**
         * Saves the Feature Image value to the form meta with security checks.
         *
         * @param array $form
         * @return array
         */
        public function save_feature_image_field($form) {
            // Verify the nonce
            if (isset($_POST['gfqc_feature_image_nonce']) && !wp_verify_nonce($_POST['gfqc_feature_image_nonce'], 'gfqc_save_feature_image')) {
                return $form; // Invalid nonce, do not proceed
            }

            // Sanitize and validate the URL
            if (isset($_POST['feature_image'])) {
                $feature_image = sanitize_text_field($_POST['feature_image']);
                if (!filter_var($feature_image, FILTER_VALIDATE_URL)) {
                    // If URL is invalid, do not save it
                    $feature_image = '';
                }
                $form['feature_image'] = esc_url_raw($feature_image);
            }

            return $form;
        }
    }
}
