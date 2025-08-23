<?php

/**
 * Saves the logic rules from the quiz settings tab
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_logic_ajax() {
    global $wpdb;
    global $mlwQuizMasterNext;
    $quiz_id = ! empty( $_POST["quiz_id"] ) ? intval( $_POST["quiz_id"] ) : 0;
    $mlwQuizMasterNext->quizCreator->set_id( $quiz_id );
    $logic_ajax = qsm_update_logic_data($_POST["parameter"], $_POST["logic_rules"], $quiz_id );
    echo wp_json_encode( $logic_ajax );
    wp_die();
}

/**
*
* Saves the logic in mlw_logic table
*
* @since 2.0.0
* @return array number of rows saved / false incase query fails
*/
function qsm_update_logic_data( $parameter, $logic, $quiz_id ) {
    global $wpdb;
    global $mlwQuizMasterNext;
    $table_exists = get_option("logic_rules_quiz_$quiz_id");
    $logic_table = $wpdb->prefix.'mlw_logic';
    if ( empty($table_exists) ) {
        $wpdb->delete($logic_table, array( 'quiz_id' => $quiz_id ));
        $value_array = array();
        foreach ( $logic as $logic_data ) {
            $data = array(
                $quiz_id,
                maybe_serialize($logic_data),
            );
            $value_array[] = stripslashes($wpdb->prepare("(%d, %s)", $data));
        }
        $values = implode(',', $value_array);
        $query = "INSERT INTO $logic_table (quiz_id, logic) VALUES ";
        $query .= $values;
        $saved = $wpdb->query($query);
        if ( FALSE != $saved ) {
            update_option("logic_rules_quiz_$quiz_id", gmdate(time()));
            $mlwQuizMasterNext->pluginHelper->update_quiz_setting( "logic_rules", '' );
        } else {
            $mlwQuizMasterNext->log_manager->add(
                __('Error 0002: Failed to save bulk logic data', 'qsm-logic'),
                sprintf(
                    __('<b>Error:</b> %s<br><b>Query:</b> %s', 'qsm-logic'),
                    $wpdb->last_error,
                    $wpdb->last_query
                ),
                0,
                'error'
            );
        }
        return array( 'status' => $saved );
    } else {
        foreach ( $parameter as $key => $param ) {
            if ( 'updated' == $param['status'] ) {
                if ( ! empty($param['id']) ) {
                    $data = array(
                        'logic' => maybe_serialize($logic[ $key ]),
                    );
                    $where = array(
                        'id' => $param['id'],
                    );
                    $result = $wpdb->update($logic_table, $data, $where, array( '%s' ), array( '%d' ));
                    if ( $result ) {
                        return $response = array(
                            'status'           => true,
                            'logicRulesObject' => array(
                                'logicRules' => array( $logic[ $key ] ),
                                'ids'        => array( $param['id'] ),
                            ),
                        );
                    } else {
                        $mlwQuizMasterNext->log_manager->add(
                            __('Error 0003: Failed to update logic record', 'qsm-logic'),
                            sprintf(
                                __('<b>Error:</b> %s<br><b>Query:</b> %s<br><b>Record ID:</b> %d', 'qsm-logic'),
                                $wpdb->last_error,
                                $wpdb->last_query,
                                $param['id']
                            ),
                            0,
                            'error'
                        );
                        return $response = array( 'status' => false );
                    }
                } else {
                    $data = array(
                        'quiz_id' => $quiz_id,
                        'logic'   => maybe_serialize($logic[ $key ]),
                    );
                    $result = $wpdb->insert($logic_table, $data, array( '%d', '%s' ));
                    if ( $result ) {
                        return $response = array(
                            'status'           => true,
                            'logicRulesObject' => array(
                                'logicRules' => array( $logic[ $key ] ),
                                'ids'        => array( $wpdb->insert_id ),
                            ),
                        );
                    } else {
                        $mlwQuizMasterNext->log_manager->add(
                            __('Error 0004: Failed to insert logic record', 'qsm-logic'),
                            sprintf(
                                __('<b>Error:</b> %s<br><b>Query:</b> %s<br><b>Quiz ID:</b> %d', 'qsm-logic'),
                                $wpdb->last_error,
                                $wpdb->last_query,
                                $quiz_id
                            ),
                            0,
                            'error'
                        );
                        return $response = array( 'status' => false );
                    }
                }
            }
        }
    }
}

/**
*
* Deletes logic from mlw_logic table
* @since 2.0.0
*/
function qsm_addon_logic_ajax_delete(){
    global $wpdb;
    global $mlwQuizMasterNext;
    $table = $wpdb->prefix.'mlw_logic';
    $id = ! empty( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
    $result = $wpdb->delete($table, array( 'id' => $id ), '%d');
    if ( FALSE === $result ) {
        $mlwQuizMasterNext->log_manager->add(
            __('Error 0005: Failed to delete logic record', 'qsm-logic'),
            sprintf(
                __('<b>Error:</b> %s<br><b>Query:</b> %s<br><b>Record ID:</b> %d', 'qsm-logic'),
                $wpdb->last_error,
                $wpdb->last_query,
                $id
            ),
            0,
            'error'
        );
    }
    echo wp_json_encode(array( 'status' => $result ));
    wp_die();
}

/**
 *
 * Gets data from database to edit a record.
 *
 * @since 2.0.0
 * @return array
 */
function qsm_addon_logic_ajax_edit(){
    global $wpdb;
    global $mlwQuizMasterNext;
    $table = $wpdb->prefix.'mlw_logic';
    $id = ! empty( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
    $query = "SELECT logic from $table where id = %d";

    $result = $wpdb->get_row($wpdb->prepare($query, $id));
    if ( $result ) {
        $response = array(
            'status'     => true,
            'logicRules' => [ maybe_unserialize($result->logic) ],
            'ids'        => [ $id ],
        );
    } else {
        $mlwQuizMasterNext->log_manager->add(
            __('Error 0006: Failed to retrieve logic record', 'qsm-logic'),
            sprintf(
                __('<b>Error:</b> %s<br><b>Query:</b> %s<br><b>Record ID:</b> %d', 'qsm-logic'),
                $wpdb->last_error,
                $wpdb->last_query,
                $id
            ),
            0,
            'error'
        );
        $response = array(
            'status' => false,
        );
    }

    echo wp_json_encode($response);
    wp_die();
}

/**
 *
 * Deletes logic record from table in bulk
 *
 * @since 2.0.0
 */
function qsm_addon_logic_ajax_bulk_delete(){
    global $wpdb;
    global $mlwQuizMasterNext;
    $table = $wpdb->prefix.'mlw_logic';
    $ids = ! empty( $_POST['ids'] ) ? $_POST['ids'] : array();
    $id_string = implode(', ', $ids);
    $query = "DELETE from $table where id in (%1s)";

    $result = $wpdb->query($wpdb->prepare($query, $id_string));
    if ( $result ) {
        $response = array(
            'status' => true,
            'ids'    => $result,
        );
    } else {
        $mlwQuizMasterNext->log_manager->add(
            __('Error 0007: Failed to delete logic records', 'qsm-logic'),
            sprintf(
                __('<b>Error:</b> %s<br><b>Query:</b> %s<br><b>Record IDs:</b> %s', 'qsm-logic'),
                $wpdb->last_error,
                $wpdb->last_query,
                $id_string
            ),
            0,
            'error'
        );
        $response = array(
            'status' => false,
        );
    }

    echo wp_json_encode($response);
    wp_die();
}