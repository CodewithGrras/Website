<?php
/**
 * Import functions
 *
 * @link       #
 * @since      2.0.0
 *
 * @package    wpx-pp-import-export
 * @subpackage wpx-pp-import-export/classes
 */

if (!class_exists('PP_IMPORT_WPSPIN') && defined('ABSPATH')) {
    /**
     * PP_IMPORT_WPSPIN
     *
     * @since      1.0.0
     */
    class PP_IMPORT_WPSPIN
    {

        /**
         * Constructor
         *
         * @since    1.0.0
         */
        public function __construct()
        {
            add_filter('upload_mimes', array($this, 'cc_mime_types'));

            add_action('post_edit_form_tag', array($this, 'pp_wpspin_update_edit_form'));
            add_action('save_post', array($this, 'pp_wpspin_save_json_import'));
            add_action('wp_ajax_pp_wpspin_import_json', array($this, '_pp_wpspin_import'));
            add_action('wp_ajax_nopriv_pp_wpspin_import_json', array($this, '_pp_wpspin_import'));
    
        }
        public function _pp_wpspin_import() {
            require_once PP_IMPORT_EXPORT_WPSPIN_PATH . 'inc/classes/class-pp-import-wpspin.php';
            //pp_wpspin_import_title
            $nonce = $_POST['pp_wpspin_import_nonce'];
            if (!wp_verify_nonce($nonce, 'pp_wpspin_import')) {
                wp_send_json_error('Invalid Nonce');
            }
            $title = $_POST['pp_wpspin_import_title'];
            $file = $_FILES['pp_wpspin_json_file'];
            if (empty($file)) {
                wp_send_json_error('No file uploaded');
            }
            $json = file_get_contents($file['tmp_name']);
            $result = json_decode($json, true);
            $post_id = wp_insert_post(array(
                'post_title' => $title,
                'post_type' => $result['post_type'],
                'post_status' => 'publish',
            ));
            if ($post_id) {
                if (!empty($result['post_data']) && is_array($result['post_data'])) {
                    try {
                        $this->update_post_data($post_id, $result['post_data']);
                    } catch (Exception $e) {
                        wp_send_json_error('Failed to import post data');
                    }
                }
                if (!empty($result['post_meta']) && is_array($result['post_meta'])) {
                    try {
                        $this->update_post_meta($post_id, $result['post_meta']);
                    } catch (Exception $e) {
                        wp_send_json_error('Failed to import post meta');
                    }
                }
                if (!empty($result['acf_fields']) && is_array($result['acf_fields']) && class_exists('ACF')) {
                    try {
                        $this->update_acf_fields($post_id, $result);
                    } catch (Exception $e) {
                        wp_send_json_error('Failed to import ACF fields');
                    }
                }
                if (!empty($result['taxonomies']) && is_array($result['taxonomies'])) {
                    try {
                        $this->update_taxonomies($post_id, $result['taxonomies']);
                    } catch (Exception $e) {
                        wp_send_json_error('Failed to import taxonomies');
                    }
                }
                if (!empty($result['feature_img']) && is_array($result['feature_img'])) {
                    try {
                        $this->update_featured_image($post_id, $result['feature_img']);
                    } catch (Exception $e) {
                        wp_send_json_error('Failed to import featured image');
                    }
                }
                wp_send_json_success('Post imported successfully');
            } else {
                wp_send_json_error('Failed to import post');
            }
            
        }
        /**
         * Add this for input type file
         *
         * @since    1.0.0
         */
        public function pp_wpspin_update_edit_form()
        {
            echo ' enctype="multipart/form-data"';
        }

        /**
         * Json file import
         *
         * @since    2.0.0
         * @param  mixed $post_id post ID.
         */
        public function pp_wpspin_save_json_import($post_id)
        {
            global $post;

            $is_autosave = wp_is_post_autosave($post_id);
            $is_revision = wp_is_post_revision($post_id);
            $is_valid_nonce = (isset($_POST['ppwpspinjson_nonce']) && wp_verify_nonce(sanitize_key($_POST['ppwpspinjson_nonce']), basename(__FILE__))) ? 'true' : 'false';
            $is_user_logged_in = is_user_logged_in(); // check login.

            // Exits script depending on save status.
            if ($is_autosave || $is_revision || !$is_valid_nonce || !$is_user_logged_in) {
                return;
            }

            // Verify if this is an auto save routine. If it is our form has not been submitted, so we don't want.
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }

            // Fetch and decode JSON data
            if (!empty($_FILES['pp_wpspin_json_file']['tmp_name'])) {
                $json = file_get_contents($_FILES['pp_wpspin_json_file']['tmp_name']);
                $result = json_decode($json, true);

                // Check if post data is available
                if (!empty($result['post_data']) && is_array($result['post_data'])) {
                    $this->update_post_data($post_id, $result['post_data']);
                }

                // Update post meta
                if (!empty($result['post_meta']) && is_array($result['post_meta'])) {
                    $this->update_post_meta($post_id, $result['post_meta']);
                }

                // Update ACF fields
                if (!empty($result['acf_fields']) && is_array($result['acf_fields']) && class_exists('ACF')) {
                    $this->update_acf_fields($post_id, $result);
                }

                // Update taxonomies
                if (!empty($result['taxonomies']) && is_array($result['taxonomies'])) {
                    $this->update_taxonomies($post_id, $result['taxonomies']);
                }

                // Update featured image
                if (!empty($result['feature_img']) && is_array($result['feature_img'])) {
                    $this->update_featured_image($post_id, $result['feature_img']);
                }
            }
        }
// Update post data
        private function update_post_data($post_id, $post_data)
        {
            if (!empty($post_data) && is_array($post_data)) {
                /**
                 * extract images and upload to the new path
                 */
                $extract_content = $this->upload_content_image_and_change_path($post_id, $post_data['post_content'], home_url());
                $post_data = array(
                    'ID' => $post_id,
                    'post_content' => $extract_content,
                    'post_excerpt' => $post_data['post_excerpt'],
                );
                /**
                 * Get rid of infinite import/update
                 */
                remove_action('save_post', array($this, 'pp_wpspin_save_json_import'));
                wp_update_post($post_data);
                add_action('save_post', array($this, 'pp_wpspin_save_json_import'));
            }
        }
// Update post meta
        private function update_post_meta($post_id, $post_meta)
        {
            if (is_array($post_meta) && !empty($post_meta)) {
                foreach ($post_meta as $meta_key => $meta_value) {
                    // Sanitize and validate your meta values as needed
                    $meta_value = sanitize_text_field($meta_value);

                    // Update post meta
                    update_post_meta($post_id, $meta_key, $meta_value);
                }
            }
        }
// Update ACF fields
        private function update_acf_fields($post_id, $result)
        {
            if (!empty($result['acf_fields']) && is_array($result['acf_fields']) && class_exists('ACF')) {
                $imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "webp");
                foreach ($result['acf_fields'] as $meta_key => $meta_value) { // Page header.
                    if (isset($meta_value['type']) && 'image' == $meta_value['type']) {
                        $image_url = $meta_value['url'];
                        $attach_id = $this->upload_image($image_url, $post_id);
                        $result['acf_fields'][$meta_key] = $attach_id;
                    } else {
                        if (is_array($meta_value)) {
                            foreach ($meta_value as $mk => $mv) {
                                if (is_array($mv)) {
                                    foreach ($mv as $mkk => $mvv) {
                                        $urlExt = pathinfo($mvv, PATHINFO_EXTENSION);
                                        if (in_array($urlExt, $imgExts)) {
                                            if (strpos($mvv, $home_url) !== false) {
                                                $attach_id = $this->upload_image($mvv, $post_id);
                                                $result['acf_fields'][$meta_key][$mk][$mkk] = $attach_id;
                                            }
                                        }
                                    }
                                } else {
                                    $urlExt = pathinfo($mv, PATHINFO_EXTENSION);
                                    if (in_array($urlExt, $imgExts)) {
                                        if (strpos($mv, $home_url) !== false) {
                                            $attach_id = $this->upload_image($mv, $post_id);
                                            $result['acf_fields'][$meta_key][$mk] = $attach_id;
                                        }
                                    }
                                }
                            }
                        } else {
                            $urlExt = pathinfo($meta_value, PATHINFO_EXTENSION);
                            if (in_array($urlExt, $imgExts)) {
                                if (strpos($meta_value, $home_url) !== false) {
                                    $attach_id = $this->upload_image($meta_value, $post_id);
                                    $result['acf_fields'][$meta_key] = $attach_id;
                                }
                            }
                        }
                    }
                    if (is_array($meta_value)) {
                        foreach ($meta_value as $field_key => $field_val) {
                            if (isset($field_val['type']) && 'image' == $field_val['type']) {
                                $image_url = $field_val['url'];
                                $attach_id = $this->upload_image($image_url, $post_id);
                                $result['acf_fields'][$meta_key][$field_key] = $attach_id;
                            }
                            if (is_array($field_val)) {
                                foreach ($field_val as $sub_field_key => $sub_field_val) { // image.
                                    if (isset($sub_field_val['type']) && 'image' == $sub_field_val['type']) {
                                        $image_url = $sub_field_val['url'];
                                        $attach_id = $this->upload_image($image_url, $post_id);
                                        $result['acf_fields'][$meta_key][$field_key][$sub_field_key] = $attach_id;
                                    }
                                    if (is_array($sub_field_val)) {
                                        foreach ($sub_field_val as $sub_sub_field_key => $sub_sub_field_val) {
                                            if (isset($sub_sub_field_val['type']) && 'image' == $sub_sub_field_val['type']) {
                                                $image_url = $sub_sub_field_val['url'];
                                                $attach_id = $this->upload_image($image_url, $post_id);
                                                $result['acf_fields'][$meta_key][$field_key][$sub_field_key][$sub_sub_field_key] = $attach_id;
                                            }
                                            if (is_array($sub_sub_field_val)) {
                                                foreach ($sub_sub_field_val as $sub_sub_sub_field_key => $sub_sub_sub_field_val) {
                                                    if (isset($sub_sub_sub_field_val['type']) && 'image' == $sub_sub_sub_field_val['type']) {
                                                        $image_url = $sub_sub_sub_field_val['url'];
                                                        $attach_id = $this->upload_image($image_url, $post_id);
                                                        $result['acf_fields'][$meta_key][$field_key][$sub_field_key][$sub_sub_field_key][$sub_sub_sub_field_key] = $attach_id;
                                                    }
                                                    if (is_array($sub_sub_sub_field_val)) {
                                                        foreach ($sub_sub_sub_field_val as $sub_sub_sub_sub_field_key => $sub_sub_sub_sub_field_val) {
                                                            if (isset($sub_sub_sub_sub_field_val['type']) && 'image' == $sub_sub_sub_sub_field_val['type']) {
                                                                $image_url = $sub_sub_sub_sub_field_val['url'];
                                                                $attach_id = $this->upload_image($image_url, $post_id);
                                                                $result['acf_fields'][$meta_key][$field_key][$sub_field_key][$sub_sub_field_key][$sub_sub_sub_field_key][$sub_sub_sub_sub_field_key] = $attach_id;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (!empty($result['acf_fields']) && is_array($result['acf_fields']) && class_exists('ACF')) {
                foreach ($result['acf_fields'] as $meta_key => $meta_value) { // Page header.
                    $extract_content = $this->upload_content_image_and_change_path($post_id, $meta_value, home_url());
                    update_field($meta_key, $extract_content, $post_id);
                }
            }
        }
// Update taxonomies
        private function update_taxonomies($post_id, $taxonomies)
        {
            if (is_array($taxonomies) && !empty($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $term = get_term_by('slug', $taxonomy['slug'], $taxonomy['taxonomy']);

                    if ($term) {
                        // If term exists, update it
                        $update = wp_update_term(
                            $term->term_id,
                            $taxonomy['taxonomy'],
                            array(
                                'name' => $taxonomy['name'],
                                'slug' => $taxonomy['slug'],
                            )
                        );

                        $cat_ids = array($term->term_id);
                        wp_set_object_terms($post_id, $cat_ids, $taxonomy['taxonomy'], true);
                    } else {
                        // If term doesn't exist, create a new one
                        $new_term = wp_insert_term(
                            $taxonomy['name'],
                            $taxonomy['taxonomy'],
                            array(
                                'slug' => $taxonomy['slug'],
                            )
                        );

                        $cat_ids = array($new_term['term_id']);
                        wp_set_object_terms($post_id, $cat_ids, $taxonomy['taxonomy'], true);
                    }
                }
            }
        }
// Update featured image
        private function update_featured_image($post_id, $feature_img)
        {
            if (is_array($feature_img) && !empty($feature_img)) {
                $image_url = $feature_img[0];

                // Upload the image and get the attachment ID
                $attach_id = $this->upload_image($image_url, $post_id);

                // Set the uploaded image as the post's featured image
                set_post_thumbnail($post_id, $attach_id);
            }
        }

        /**
         * Cc_mime_types
         *
         * @since    1.0.0
         * @param  mixed $mimes mimes.
         */
        public function cc_mime_types($mimes)
        {
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        }

        /**
         * upload_content_image_and_change_path
         *
         * @since    2.0.0
         * @param  mixed $post_content post content.
         * @param  mixed $post_id post id.
         * @param  mixed $home_url home url to replace the link.
         */
        public function upload_content_image_and_change_path($post_id, $post_content, $home_url)
        {
            if (empty($post_content) || is_array($post_content)) {
                return $post_content;
            }

            $imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "webp");
            $urlExt = pathinfo($post_content, PATHINFO_EXTENSION);

            if (in_array($urlExt, $imgExts) && strpos($post_content, $home_url) !== false) {
                // If the post content is a direct image URL, upload and replace it
                $attach_id = $this->upload_image($post_content, $post_id);
                $newlink = wp_get_attachment_url($attach_id);
                return $newlink;
            } else {
                if ( function_exists( 'mb_convert_encoding' ) ) {
                    // If the post content contains HTML, handle images in the HTML
                    $post_content = mb_convert_encoding($post_content, 'HTML-ENTITIES', 'UTF-8');
                } else{
                    $post_content = utf8_encode($post_content);
                }

                if ($post_content == strip_tags($post_content)) {
                    return $post_content;
                }
                if ( class_exists( 'DOMDocument' ) ) {
                    $doc = new DOMDocument();
                } else {
                    return $post_content;
                }
                $doc->loadHTML($post_content);
                $tags = $doc->getElementsByTagName('img');

                if ($tags->length > 0) {
                    foreach ($tags as $tag) {
                        $oldsrc = $tag->getAttribute('src');
                        if (strpos($oldsrc, $home_url) !== false) {
                            $attach_id = $this->upload_image($oldsrc, $post_id);
                            $newlink = wp_get_attachment_url($attach_id);
                            $tag->setAttribute('src', $newlink);
                        }
                    }

                    // Save the modified HTML content
                    $extractcontent = utf8_encode($doc->saveHTML());
                    return $extractcontent;
                } else {
                    return $post_content;
                }
            }
        }
        /**
         * This function uploads image
         *
         * @since    2.0.0
         * @param  mixed $image_url image url.
         * @param  mixed $post_id post id.
         */
        public function upload_image($image_url, $post_id = null)
        {
            $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
			$file_extension = strtolower(pathinfo($image_url, PATHINFO_EXTENSION));
			if (!in_array($file_extension, $allowed_file_types)) {
				return false;
			}
            $image_name = basename($image_url);
            $upload_dir = wp_upload_dir(); // Set upload folder.
            $image_data = $this->download_image($image_url); // Download image data.

            if (!$image_data) {
                // Download failed, return or handle accordingly.
                return false;
            }

            $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name); // Generate unique name.
            $filename = basename($unique_file_name); // Create image file name.

            // Check folder permission and define file location.
            if (wp_mkdir_p($upload_dir['path'])) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }

            // Create the image file on the server.
            file_put_contents($file, $image_data);

            // Check image file type.
            $wp_filetype = wp_check_filetype($filename, null);

            // Set attachment data.
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit',
            );

            // Create the attachment.
            if (null == $post_id) {
                $attach_id = wp_insert_attachment($attachment, $file);
            } else {
                $attach_id = wp_insert_attachment($attachment, $file, $post_id);
            }

            require_once ABSPATH . 'wp-admin/includes/image.php';

            // Define attachment metadata.
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);

            // Assign metadata to attachment.
            wp_update_attachment_metadata($attach_id, $attach_data);

            return $attach_id;
        }

        /**
         * Download image data from a URL.
         *
         * @param string $image_url Image URL.
         * @return string|false Image data on success, false on failure.
         */
        private function download_image($image_url)
        {
            $response = wp_remote_get($image_url);

            if (is_array($response) && !is_wp_error($response) && isset($response['body'])) {
                return $response['body'];
            }

            return false;
        }

    } //end class

    new PP_IMPORT_WPSPIN();
} // class_exists
