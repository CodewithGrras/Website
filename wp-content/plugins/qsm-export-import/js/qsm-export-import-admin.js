/**
 * Opens retrieved export file
 */
function qsmDownloadExport( exportFile ) {
    var a = document.createElement('a');
    var url = exportFile.filename;
    a.href = url;
    a.download = exportFile.file_name;
    document.body.append(a);
    a.click();
    a.remove();
    window.URL.revokeObjectURL(url);
    //window.open( exportFile.filename );
}

/*** OLD Export quizes : New may include responses too
jQuery( document ).on( 'click', '.qsm-export-quiz', function( e ) {
    jQuery(this).text(qsm_export_import_obj.qsm_exporting_txt);
    let exportID = jQuery('.qsm-export-select').val();
    let nonce = jQuery('#qsm_export_quiz_nonce').val();
    var data = {
        action: 'qsm_export_quiz',
        nonce: nonce,
        export: exportID,
    };

    jQuery.post(ajaxurl, data, function (response) {
        if (true == response.success) {
            qsmDownloadExport( response.data );
        } else {
            alert( response.data );
        }
        jQuery('.qsm-export-quiz').text(qsm_export_import_obj.qsm_export_quiz_btn_txt);
    });
});
**/

jQuery( document ).on( 'click', '.qsm-export-questions', function( e ) {
    jQuery(this).text(qsm_export_import_obj.qsm_exporting_txt);
    let exportID = jQuery('.qsm-export-question-select').val();
    let nonce = jQuery('#qsm_export_questions_nonce').val();
    let exportType = jQuery('.qsm-export-type:checked').val();
    var data = {
        action: 'qsm_export_question',
        nonce: nonce,
        export: exportID,
        export_type: exportType
    };

    jQuery.post(ajaxurl, data, function (response) {
        if (true == response.success) {
            qsmDownloadExport( response.data );
        } else {
            alert( response.data );
        }
        jQuery('.qsm-export-questions').text(qsm_export_import_obj.qsm_export_quiz_btn_txt);
    });
});

jQuery( document ).on( 'click', '.qsm-export-settings', function( e ) {
    jQuery(this).text(qsm_export_import_obj.qsm_exporting_txt);
    let quizId = jQuery('.qsm-export-option-select').val();
    let nonce = jQuery('#qsm_export_settings_nonce').val();
    var checkboxValues = [];
    jQuery('input[name="qsm-export-options[]"]:checked').map(function() {
        checkboxValues.push(jQuery(this).val());
    });
    var data = {
        action: 'qsm_export_settings',
        nonce: nonce,
        checkboxValues: checkboxValues,
        export: quizId,
    };

    jQuery.post( ajaxurl, data, function( response ) {
        if (true == response.success) {
            qsmDownloadExport( response.data );
        } else {
            alert( response.data );
        }
        jQuery('.qsm-export-settings').text(qsm_export_import_obj.qsm_export_quiz_btn_txt);
    });
});

jQuery(document).on( 'click', '.flashcard-export-submit', function( e ) {
    jQuery(this).text(qsm_export_import_obj.qsm_exporting_txt);
    var exportType = jQuery('.flashcard-export-type:checked').val();
    var export_flashcard_nonce = jQuery('#export_flashcard_nonce').val();
    var data = {
        action: 'qsm_flashcards_export',
        export_flashcard_nonce: export_flashcard_nonce,
        export_type: exportType,
    };

    jQuery.post(ajaxurl, data, function (response) {
        if (true == response.success) {
            qsmDownloadExport( response.data );
        } else {
            alert( response.data );
        }
        jQuery('.flashcard-export-submit').text(qsm_export_import_obj.qsm_export_quiz_btn_txt);
    });
});

jQuery(document).on('change', '.qsm-import-files', function (e) {
    var fileName = e.target.files[0].name;
    jQuery('.qsm-file-import-name').remove();
    jQuery(this).before("<p class='qsm-file-import-name'>"+fileName+"</p>");
});

jQuery('.qsm-toggleButton').on("click", function( event ) {
    event.preventDefault();
    if ( parseInt(jQuery(this).attr('data-toggle')) === 0 ) {
        jQuery(document).find('#qsm-license_entry').show();
        jQuery(document).find('.qsm-license-content .qsm-license-info').hide();
    } else {
        jQuery(document).find('.qsm-license-content .qsm-license-info').show();
        jQuery(document).find('#qsm-license_entry').hide();
    }
});
jQuery( '.qsm-license-container' ).on( 'click', '#qsm-validate_btn', function ( event ) {
    event.preventDefault();
    var license_message = jQuery('#qsm-license_entry .qsm-validate-msg');
    license_message.html(qsm_export_import_obj.please_wait).fadeIn();
    if( jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').val() !== "") {
        var data = {
            action: 'qsm_export_i_validate_license',
            input: jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').val(),
            update_status: 'yes',
        };
        jQuery.post( ajaxurl, data, function ( response ) {
            console.log(response);
            response = jQuery.parseJSON(response);
            if(response.validate == 1 || response.validate == 2) {
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                license_message.html(qsm_export_import_obj.invalid).fadeIn();
            }
        });
    } else {
        license_message.html(qsm_export_import_obj.license_msg);
        jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').focus();
    }
});

jQuery( '.qsm_export_i_validate_parent' ).on( 'click', '.qsm_export_i_validate_button', function ( event ) {
    event.preventDefault();
    var license_message = jQuery('.qsm_export_i_validate_message');
    jQuery("#qsm-license_message").show();
    if( jQuery('.qsm_export_i_validate_input').val() != "") {
      license_message.html(qsm_export_import_obj.please_wait);
      var data = {
        action: 'qsm_export_i_validate_license',
        input: jQuery('.qsm_export_i_validate_input').val(),
      };
      jQuery.post( ajaxurl, data, function ( response ) {
        response = jQuery.parseJSON(response);
        license_message.html(response.message);
        if(response.validate == 1 || response.validate == 2) {
          response.validate == 1 ? jQuery("#qsm-license_message").css({'color': '#00a32a'}) : "";
          setTimeout(function() {
            location.reload();
          }, 2000);
        }else{
			license_message.html(qsm_export_import_obj.invalid);
		}
      });
    }else{
      license_message.html(qsm_export_import_obj.license_msg);
      jQuery('.qsm_export_i_validate_input').focus();
    }
});

jQuery(document).ready(function () {
    jQuery(document).on( 'click', '.addon-settings-form .qsm-display-license-input', function( event ) {
        event.preventDefault();
        if(jQuery(this).hasClass('qsm-show-input')){
            jQuery('.addon-settings-form').submit();
        } else {
            jQuery("#new_license_key").show();
            jQuery(this).addClass('qsm-show-input');
            jQuery(this).removeClass('qsm-hide-input');
            jQuery(this).html(qsm_export_import_obj.save_license);
        }
    });
});


/**
 * Export | import quizes and result in chunks
 */
jQuery(document).ready( function() {

    // Initialize Import
    function ajaxImportExport( data ) {
        return  new Promise(function(resolve, reject) {
            jQuery.post(
                    ajaxurl,
                    data
            ).done( function ( response ) {
                resolve( response );
            }).fail(function(xhr, status, error) {
                // This is called when the request fails
                console.error('Request failed:', status, error);
                reject( xhr.responseText );
            });
        });
    }

    /**
     * Chunk array ids
     * ex- [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] Output: [[1, 2, 3, 4, 5], [6, 7, 8, 9, 10], [11]]
     * @param { array } array array of ids
     * @param { int } chunkSize size of chunk
     * @returns { array } array of required chunk size
     */
    function chunkArrayIds( arr, chunkSize ) {
        const result = [];
        for (let i = 0; i < arr.length; i += chunkSize) {
            const chunk = arr.slice(i, i + chunkSize);
            result.push(chunk);
        }
        return result;
    }


     /**
     * Check if data is empty
     * @param {any} data data
     * @returns {boolean} true if empty
     */
    function qsmIsEmpty( data ) {
        return undefined === data || null === data || '' === data;
    }

    /**
     * Convert String To Kebab-case
     * Replace non-alphanumeric characters with hyphens and remove leading and trailing hyphens
     * @param {string} str data
     * @returns {string} Kebab-case string
     */
    function kebabCase(str) {
        return str.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    }

    // Initialize Export
    function initializeExport() {
        // On click export quiz button
        jQuery( document ).on( 'click', '.qsm-export-quiz', async function( e ) {
            var jsonData = {
                quiz_ids:[],
                quizzes:[],
                results:[]
            };

            // Error message Div
            var errorMessageDiv = jQuery('#qsm-export-quiz-result-message');

            let quiz_ids = jQuery('.qsm-export-select').val();

            if ( qsmIsEmpty( quiz_ids ) || 0 === quiz_ids.length  ) {
                errorMessageDiv.html( qsm_export_import_obj.qsm_select_quiz_txt );
                return false;
            }

            // change button text in progress mode
            jQuery(this).text( qsm_export_import_obj.qsm_exporting_txt );
            // Disable export button
            jQuery(this).prop( 'disabled', true );

            quiz_ids = Array.isArray( quiz_ids ) ? quiz_ids : [quiz_ids];

            // Prepare for import: get necessary data
            var data = {
                action: 'qsm_prepare_import_quiz',
                nonce: jQuery('#qsm_export_import_quiz_nonce').val(),
                quiz_ids : quiz_ids,
                get_chunk_size: 1,
            };

            var response = await ajaxImportExport( data );
            if ( true !== response.success ) {
                errorMessageDiv.html( response.data );
                return false;
            }
            var chunk_size = qsmIsEmpty( response.data.chunk_size ) ? 20 : response.data.chunk_size;
            jsonData.chunk_size = chunk_size;
            jsonData.site_url = response.data.site_url;
            jsonData.max_questions = response.data.max_questions;

            // export quiz
            data.action = 'qsm_export_quiz';
            jsonData.quiz_ids = quiz_ids;
            quiz_export_chunks = chunkArrayIds( quiz_ids, chunk_size );
            // List of quiz names
            var quizNames = [];
            // List of duplicate quizzes
            var duplicateQuizName = {};

            for (let quizIds of quiz_export_chunks) {
                data.quiz_ids = quizIds;
                // fetch results
                let response = await ajaxImportExport( data );
                if ( true == response.success ) {
                    // Check for duplicate quiz names. add a number at the end if duplicate.
                    response.data.quizzes.forEach( function( quiz, quiz_index ) {
                        let quiz_name = quiz.quiz_name;
                        // Quiz name already exist
                        if ( quizNames.includes( quiz_name ) ) {
                            // Add a number at the end of duplicate quiz name
                            quiz_name = quiz.quiz_name+''+quizNames.length;
                            duplicateQuizName[quiz.quiz_id] = quiz_name;
                            // Update quiz array
                            response.data.quizzes[quiz_index].quiz_name = quiz_name;
                        }
                        // Update quiz name list
                        quizNames.push( quiz_name );
                    });
                    // merge results
                    jsonData.quizzes = jsonData.quizzes.concat( response.data.quizzes );
                } else {
                    errorMessageDiv.html( response.data );
                }
            };

            // export results
            if ( jQuery( '#export_results_checkbox' ).is(":checked") ) {
                data.export_results = '1';
                // fetch results of one quiz at a time
                for (let quiz_id of quiz_ids) {
                    var newQuizName = qsmIsEmpty( duplicateQuizName[quiz_id] )?'': duplicateQuizName[quiz_id];
                    data.quiz_ids = [ quiz_id ];
                    // fetch results
                    let response = await ajaxImportExport( data );
                    if ( true == response.success ) {
                        // Duplicate quiz name
                        if ( 0 < newQuizName.length ) {
                            // Update quiz name
                            response.data.results.forEach( function( result, result_index ) {
                                // if same quiz_name and page_name
                                if ( result.page_name === result.quiz_name ) {
                                    result.page_name = newQuizName;
                                }

                                // if same quiz_name is used in url
                                if ( result.page_url.includes( "/qsm_quiz/" + kebabCase( result.quiz_name ) ) ) {
                                    // Parse the URL
                                    let urlObj = new URL(result.page_url);

                                    // Split the pathname into segments
                                    let segments = urlObj.pathname.split('/');

                                    // Check if the URL ends with a trailing slash
                                    let hasTrailingSlash = false;
                                    // Remove any empty segments caused by trailing slash
                                    if (segments[segments.length - 1] === '') {
                                        hasTrailingSlash = true;
                                        segments.pop();
                                    }

                                    // Replace the last meaningful segment
                                    segments[segments.length - 1] = kebabCase( newQuizName );

                                    // Rebuild the pathname
                                    urlObj.pathname = segments.join('/');

                                    // Ensure the trailing slash is maintained if it existed
                                    if ( hasTrailingSlash ) {
                                        urlObj.pathname += '/';
                                    }

                                    result.page_url = urlObj.toString();
                                }

                                // Update quiz name
                                result.quiz_name = newQuizName;
                                // Update result
                                response.data.results[result_index] = result;
                            });
                        }
                        // merge results
                        jsonData.results = jsonData.results.concat( response.data.results );
                    } else {
                        errorMessageDiv.html( response.data );
                    }
                };
            }

            // Convert the data to a JSON string
            jsonData = JSON.stringify(jsonData, null, 2);

            // Create a Blob object
            jsonData = new Blob([jsonData], { type: "application/json" });

            // Create a URL for the Blob
            jsonData = URL.createObjectURL(jsonData);

            // Create a download link and trigger the download
            let a = document.createElement('a');
            a.href = jsonData;
            a.download = 'qsm_quizzes_surveys.json';  // Name of the file to be downloaded
            document.body.appendChild(a);  // Append the link to the body (necessary for Firefox)
            a.click();  // Trigger the click to download
            document.body.removeChild(a);  // Remove the link after download

            // Clean up the URL object
            URL.revokeObjectURL(jsonData);

            // change button text as initail state
            jQuery('.qsm-export-quiz').text(qsm_export_import_obj.qsm_export_quiz_btn_txt);
            // Enable export button
            jQuery(this).prop( 'disabled', false );
        });
    }

    /**
     * Read json file and return json data
     * @param {file} file a json
     * @returns {object} json file data
     */
    function readFileAsJson( file ) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();

            reader.onload = function(event) {
                try {
                    const jsonData = JSON.parse(event.target.result);
                    resolve(jsonData);
                } catch (error) {
                    reject(error);
                }
            };

            reader.onerror = function(event) {
                reject(event.target.error);
            };

            reader.readAsText(file);
        });
    }

    /**
     * Merge Object recursively
     * @param {object} obj1
     * @param {object} obj2
     * @returns {object} obj1 merged object
     */
    function mergeObjectRecursive( obj1, obj2 ) {
        for (let key in obj2) {
            if ( obj2[key] && 'object' === typeof obj2[key] ) {
                if (Array.isArray(obj2[key])) {
                    obj1[key] = (obj1[key] || []).concat(obj2[key]);
                } else {
                    if ( ! obj1[key] || 'object' !== typeof obj1[key] ) {
                        obj1[key] = {};
                    }
                    mergeObjectRecursive( obj1[key], obj2[key] );
                }
            } else {
                obj1[key] = obj2[key];
            }
        }
        return obj1;
    }

    /**
     * find all matching key of a JSON object with a given value
     * @param {object} obj json object
     * @param {string} value value to serach
     * @returns {array} key array of matching keys
     */
    function findKeyByValue( obj, value ) {
        if ( Array.isArray( obj ) ) {
            return false;
        }
        let objKey = Object.keys( obj ).filter( function( key ) {
            return obj[key] === value;
        });

        return  ( 0 === objKey.length ) ? false: objKey;
    }

    function displayErrorEnableSubmit( error, errorEl, submitBtn, submit_btn_name ) {
        errorEl.html( error );
        submitBtn.prop( 'disabled', false );
        submitBtn.val( submit_btn_name );
    }

    // Initialize Import
    function initializeImport() {
        // On submit import form
        jQuery( document ).on( 'click', '#qsm-import-quiz-result-submit-btn', async function( e ) {
            e.preventDefault();
            var ajaxError = false;
            // Error message Div
            var errorMessageDiv = jQuery('#qsm-import-quiz-result-message');
            errorMessageDiv.html( '' );
            errorMessageDiv.removeClass('qsm-success-message');
            errorMessageDiv.addClass('qsm-error-message');
            var message = '';
            var UnableToProcessResult = qsm_export_import_obj.unable_to_import_result;
            // Get json file
            var fileInput = document.getElementById('qsm-import-quiz-result-file');
            let file = fileInput.files[0];
            // Reset input
            fileInput.value = "";
            if ( qsmIsEmpty( file ) ) {
                errorMessageDiv.html( qsm_export_import_obj.missing_file );
                return false;
            }

            var jsonData = '';
            if ( file.type === "application/json") {
                try {
                    jsonData = await readFileAsJson( file );
                } catch (error) {
                    errorMessageDiv.html('Error reading file:'+ error);
                }
            } else {
                console.log('file.type:', file.type);
                errorMessageDiv.html('Please upload a valid JSON file.');
            }

            if (qsmIsEmpty(jsonData)) {
                errorMessageDiv.html(qsm_export_import_obj.missing_file);
                return false;
            } else if (qsmIsEmpty(jsonData.site_url) && qsmIsEmpty(jsonData.quizzes) && !qsmIsEmpty(jsonData[0]) && !qsmIsEmpty(jsonData[0].quiz_id)) {
                jsonData = {
                    site_url: qsm_export_import_obj.site_url ,
                    results: [],
                    quiz_ids: [jsonData[0].quiz_id],
                    quizzes: [jsonData[0]],
                    old_data: true
                };
            } else if (qsmIsEmpty(jsonData.site_url) || qsmIsEmpty(jsonData.quizzes) || 0 === jsonData.quizzes.length) {
                errorMessageDiv.html(qsm_export_import_obj.missing_file);
                return false;
            }

            var submitBtn = jQuery(this);
            var submit_btn_name =  submitBtn.val();
            // change button text in progress mode
            submitBtn.val( qsm_export_import_obj.qsm_importing_txt );
            // Disable export button
            submitBtn.prop( 'disabled', true );

            let mediaUrls = [];
            var regexMediaUrl = new RegExp(`(${jsonData.site_url}[^"']+\\.(jpg|jpeg|png|gif|bmp|svg|webp|mp4|mov|avi|mkv))`, 'g');
            jsonData.quizzes.forEach(quiz => {
                const quizString = JSON.stringify(quiz);
                const matches = quizString.match(regexMediaUrl);
                if (matches) {
                    mediaUrls = mediaUrls.concat(matches);
                }
            });
            mediaUrls = [...new Set(mediaUrls)];

            let data =  {
                action: 'qsm_import_media',
                mediaUrls: mediaUrls,
                importMedia: jQuery(document).find('#qsm-import-media').prop('checked') ? 1 : 0,
                quizzes: jsonData.quizzes,
                siteUrl: jsonData.site_url,
                nonce: qsm_export_import_obj.nonce 
            } ;
            let mediaResponse = await ajaxImportExport(data);
            if ( true == mediaResponse.success ) {
                let mediaData = mediaResponse.data;
                if ( mediaResponse.data.media_import_results != null ) {
                    console.log(mediaResponse.data.media_import_results)
                }
                if (mediaResponse.data.isImportMedia) {
                    message = mediaData.uploads + ' out of ' + mediaUrls.length + ' uploaded.';
                }
                jsonData.quizzes = mediaData.quizzes;
            }

            // Get data to prepare for import
            var ajax_data = {
                action: 'qsm_prepare_import_quiz',
                nonce: jQuery('#qsm_export_import_quiz_nonce').val(),
            };
            let response = await ajaxImportExport( ajax_data );
            if ( true !== response.success ) {
                errorMessageDiv.html( response.data );
                return false;
            }

            /**************************************************
                        PREPARE QUIZ IMPORT
             **************************************************/
            var {
                has_logic_store,
                has_theme_settings_store,
                has_theme_store,
                quiz_id_name,
                result_unique_id_quiz_id,
                site_url,
                database_status,
            } = response.data;

            // Incorrect database structure
            if ( 1 < database_status.length ) {
                errorMessageDiv.html( database_status );
                return false;
            }

            var regexUrlToReplace = new RegExp(jsonData.site_url, 'g');

            // Track duplicate data
            let duplicate_data = {
                quiz_names:[],
                quiz_ids:[],
                db_file_quiz_id:{},
                result_ids:[]
            };

            var chunk_size = qsmIsEmpty( jsonData.chunk_size ) ? 20 : jsonData.chunk_size;
            // Search for duplicate quizzes
            jsonData.quizzes.forEach( function( quiz ) {
                //find all matching quiz id against quiz name
                let quiz_ids = findKeyByValue( quiz_id_name, quiz.quiz_name );
                if ( false !== quiz_ids ) {
                    // Duplicate quiz names.
                    if ( ! duplicate_data.quiz_names.includes( quiz.quiz_name ) ) {
                        duplicate_data.quiz_names.push( quiz.quiz_name );
                    }
                    // Map db quiz associated with file quiz id. new quiz id : old quiz id
                    quiz_ids.forEach( function( quiz_id ) {
                        duplicate_data.db_file_quiz_id[quiz_id] = quiz.quiz_id;
                    } );
                    // Duplicate quiz id.
                    duplicate_data.quiz_ids.push( quiz.quiz_id );
                }
            } );

            // Search for duplicate results
            jsonData.results.forEach( function( result, res_index ) {
                //find db quiz id against unique_id of result
                let db_quiz_id = result_unique_id_quiz_id[result.unique_id];
                // check if unique id is already present
                if ( ! qsmIsEmpty( db_quiz_id ) ) {
                    let file_quiz_id = duplicate_data.db_file_quiz_id[db_quiz_id];
                    // Duplicate result: in case file quiz id match with quiz id associated with result
                    if ( ! qsmIsEmpty( file_quiz_id ) && file_quiz_id == result.quiz_id ) {
                        duplicate_data.result_ids.push( result.result_id );
                    } else {
                        // since unique id already present in database, we have to create a new one.
                        jsonData.results[res_index]['unique_id'] = '';
                    }
                }
            } );

            //  Message for duplicate quizes and results
            if ( 0 < duplicate_data.quiz_ids.length ) {
                message = '';
                message = duplicate_data.quiz_ids.length + '/' + jsonData.quizzes.length + ' ' + qsm_export_import_obj.quiz_survey + ' ' + qsm_export_import_obj.already_present;
                if ( 0 < duplicate_data.result_ids.length ) {
                    message += '<br>' +duplicate_data.result_ids.length + '/' + jsonData.results.length + ' '  + qsm_export_import_obj.response + ' ' + qsm_export_import_obj.already_present;
                }
            }

            // Track import data
            var import_stats = {
                quiz:{
                    imported:[],
                    failed:[]
                },
                result:{
                    imported:[],
                    failed:[]
                }
            };


             /**************************************************
                                IMPORT QUIZZES
             **************************************************/
            // file conatin more quiz than duplicate
            if ( jsonData.quizzes.length > duplicate_data.quiz_ids.length ) {
                // filter quizzes to remove duplicate
                let quizzesToImport = jsonData.quizzes.filter( function( quiz ) {
                    return ! duplicate_data.quiz_ids.includes( quiz.quiz_id );
                } );
                quizzesToImport = chunkArrayIds( jsonData.quizzes, chunk_size );
                ajax_data.action = 'qsm_import_quizzes';
                ajax_data.has_logic_store = has_logic_store;
                ajax_data.has_theme_settings_store = has_theme_settings_store;
                ajax_data.has_theme_store = has_theme_store;
                for (let quizzesChunk of quizzesToImport) {
                    ajax_data.quizzes = quizzesChunk.map( quizData => {
                        let quizString = JSON.stringify( quizData );
                        return quizString;
                    });
                    // import quizzes
                    await ajaxImportExport(
                        ajax_data
                    ).then(function(response) {
                        if ( true == response.success ) {
                            // merge quiz import data
                            import_stats.quiz = mergeObjectRecursive( import_stats.quiz, response.data );
                        } else {
                            errorMessageDiv.html( response.data );
                            ajaxError = true;
                        }
                    }).catch(function(error) {
                        ajaxError = true;
                        displayErrorEnableSubmit( error, errorMessageDiv, submitBtn, submit_btn_name );
                    });

                    if ( ajaxError ) {
                        return false;
                    }
                };
            }

            /**************************************************
                        IMPORT RESPONSES | RESULTS
             **************************************************/
            // file conatin more results than duplicate
            if ( jsonData.results.length > duplicate_data.result_ids.length && ! qsmIsEmpty( import_stats.quiz.imported ) ) {
                ajax_data.quizzes = [];
                ajax_data.action = 'qsm_imported_quiz_data';
                let imported_data = {
                    quizzes:[],
                    results:[]
                };
                // fetch imported quiz data
                response = await ajaxImportExport( ajax_data );
                if ( true == response.success ) {
                    // merge results
                    imported_data = response.data;
                } else {
                    errorMessageDiv.html( response.data );
                    return false;
                }
                var imported_quiz_data = {};
                jsonData.quizzes.forEach( function( quiz ) {
                    imported_data.quizzes.forEach( function( imported_quizzes ) {
                        // match for imported match. quiz id and name should match
                        if ( ! qsmIsEmpty( imported_quizzes[quiz.quiz_id] ) && quiz.quiz_name === imported_quizzes[quiz.quiz_id].quiz_name ) {
                            // file quiz id : db quiz data i.e. db quiz_id, questions
                            imported_quiz_data[quiz.quiz_id] = imported_quizzes[quiz.quiz_id];
                        }
                    } );
                } );

                /**
                 * filter results to remove
                 * duplicate,
                 * failed quiz because we need new quiz id which is inserted in database
                 * empty questions
                 * empty result
                 */
                var resultsToImport = jsonData.results.filter( function( result ) {
                    if ( duplicate_data.result_ids.includes( result.result_id ) ) {
                        return false;
                    } else if ( qsmIsEmpty( imported_quiz_data[result.quiz_id] ) ) {
                        // associated quiz not found
                        if ( ! UnableToProcessResult.includes( qsm_export_import_obj.quiz_not_found ) ) {
                            UnableToProcessResult += '<br>'+qsm_export_import_obj.quiz_not_found;
                        }
                        return false;
                    } else if ( qsmIsEmpty( imported_quiz_data[result.quiz_id]['questions'] ) ) {
                        // quiz has no questions
                        if ( ! UnableToProcessResult.includes( qsm_export_import_obj.no_question_quiz ) ) {
                            UnableToProcessResult += '<br>'+qsm_export_import_obj.no_question_quiz;
                        }
                        return false;
                    } else if ( qsmIsEmpty( result.quiz_results ) || qsmIsEmpty( result.quiz_results['1'] ) ) {
                        // Response has no result data
                        if ( ! UnableToProcessResult.includes( qsm_export_import_obj.no_result_data ) ) {
                            UnableToProcessResult += '<br>'+qsm_export_import_obj.no_result_data;
                        }
                        return false;
                    }
                    return true;
                } );

                // Update Quiz ID and question ID
                resultsToImport.forEach( function( result, result_index ) {
                    let old_new_question_id = imported_quiz_data[result.quiz_id]['questions'];
                    // replace old quiz id with new quiz id
                    result.quiz_id = imported_quiz_data[result.quiz_id]['id'];

                    // Replace old question id with new question id
                    if ( 0 < result.quiz_results['1'].length ) {
                        result.quiz_results['1'].forEach( function( question, question_index ) {
                            result.quiz_results['1'][question_index]['id'] =  old_new_question_id[question.id];
                        });
                    }
                    // Create required format and update results array
                    resultsToImport[result_index] = JSON.stringify({
                        result_id:result.result_id,
                        quiz_id:result.quiz_id,
                        quiz_name:result.quiz_name,
                        qmn_array_for_variables:{
                            quiz_id:result.quiz_id,
                            quiz_name:result.quiz_name,
                            quiz_system:result.quiz_system,
                            total_points:result.point_score,
                            total_score:result.correct_score,
                            total_correct:result.correct,
                            total_questions:result.total,
                            user_name:result.name,
                            user_business:result.business,
                            user_email:result.email,
                            user_phone:result.phone,
                            user_id:result.user,
                            user_ip:result.user_ip,
                            time_taken:result.time_taken,
                        },
                        results_array:result.quiz_results,
                        deleted: parseInt( result.deleted ),
                        unique_id:result.unique_id,
                        form_type:result.form_type,
                        http_referer:result.page_url,
                        page_name: result.page_name
                    }).replace( regexUrlToReplace, site_url );
                } );

                // 100 results will be imported at a time
                resultsToImport = chunkArrayIds( resultsToImport, 100 );
                ajax_data.action = 'qsm_import_results';
                for (let resultsChunk of resultsToImport) {
                    ajax_data.results = resultsChunk;

                    // import result
                    await ajaxImportExport(
                        ajax_data
                    ).then(function(response) {
                        if ( true == response.success ) {
                            // merge results
                            import_stats.result = mergeObjectRecursive( import_stats.result, response.data );
                        } else {
                            errorMessageDiv.html( response.data );
                            ajaxError = true;
                        }
                    }).catch(function(error) {
                        ajaxError = true;
                        displayErrorEnableSubmit( error, errorMessageDiv, submitBtn, submit_btn_name );
                    });

                    if ( ajaxError ) {
                        return false;
                    }

                };
            }

            let summary = {
                import_stats: import_stats,
                duplicate_data:duplicate_data,
                imported_quiz_data:imported_quiz_data,
                resultsToImport:resultsToImport,
                results:jsonData.results,
                failed:jsonData.results.filter( function(result) {
                    return ! duplicate_data.result_ids.includes( result.result_id );
                })
            }
            console.log("summary",summary);

            // Quizzes successfully imported message
            if (  0 < import_stats.quiz.imported.length ) {
                message += '<br>' + import_stats.quiz.imported.length + ' ' + qsm_export_import_obj.quiz_survey + ' ' + qsm_export_import_obj.import_success;
            }
            // Results successfully imported message
            if ( 0 < import_stats.result.imported.length ) {
                message += '<br>' + import_stats.result.imported.length + ' ' + qsm_export_import_obj.response + ' ' + qsm_export_import_obj.import_success;
            }

            // Quizzes failed to import message
            if ( 0 < import_stats.quiz.failed.length ) {
                message += '<br>' + import_stats.quiz.failed.length + ' ' + qsm_export_import_obj.quiz_survey + ' ' + qsm_export_import_obj.import_failed;
            }
            // Results failed to import message
            if ( 0 < import_stats.result.failed.length ) {
                message += '<br>' + import_stats.result.failed.length + ' ' + qsm_export_import_obj.response + ' ' + qsm_export_import_obj.import_failed;
            }

            // Unable to import responses
            if ( jsonData.results.length != ( import_stats.result.imported.length + import_stats.result.failed.length ) ) {
                message += '<br>' + UnableToProcessResult;
            }
            // Check error logs message
            if ( 0 < import_stats.quiz.failed.length || 0 < import_stats.result.failed.length ) {
                message += '<br>' + qsm_export_import_obj.check_qsm_log;
            }

            // Check if there is a dependency message
            if (import_stats.quiz.dependency && import_stats.quiz.dependency.length > 0) {
                message += '<br>' + import_stats.quiz.dependency.join('<br>');
            }

            errorMessageDiv.removeClass('qsm-error-message');
            errorMessageDiv.addClass('qsm-success-message');
            errorMessageDiv.html( message );
            // change button text as initail state
            submitBtn.val( submit_btn_name );
            // Enable export button
            submitBtn.prop( 'disabled', false );

        });
    }

    // Initialize export quiz multiselect
    function quizMultiselect() {
        jQuery( '#qsm-multi-select-quiz' ).multiselect( {
            columns: 1,
            placeholder: 'Select Quiz/Survey',
            search: true,
            selectAll: true
        } );
    }

    // Initialize Import and Export
    function initializeImportExport() {
        // initialize multiselect
        quizMultiselect();
        // Initialize Import
        initializeImport();
        // Initialize Export
        initializeExport();
    };

    initializeImportExport();
});