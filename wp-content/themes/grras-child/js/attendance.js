jQuery(document).ready(function($) {
    // Punch In button
    $('#punch-in-btn').on('click', function() {
        var userId = $('#user_id').val();
        var punchIn = $('#punch_in').val();
        var notes = $('#notes').val();
        
        if (!userId || !punchIn) {
            alert('Please select a user and enter punch in time');
            return;
        }
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'punch_in',
                nonce: attendanceData.nonce,
                user_id: userId,
                punch_in: punchIn,
                notes: notes
            },
            success: function(response) {
                if (response.success) {
                    alert('Punch in recorded successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Punch Out button
    $('#punch-out-btn').on('click', function() {
        var userId = $('#user_id').val();
        var notes = $('#notes').val();
        
        // First check if there's an active session for this user
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'get_active_session',
                nonce: attendanceData.nonce,
                user_id: userId
            },
            success: function(response) {
                if (response.success && response.data.id) {
                    // We have an active session, ask for confirmation
                    if (confirm('Active session found. Do you want to punch out now?')) {
                        // Set current time as punch out
                        var now = new Date();
                        var punchOut = now.toISOString().slice(0, 16);
                        $('#punch_out').val(punchOut);
                        
                        // Submit punch out
                        $.ajax({
                            url: attendanceData.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'punch_out',
                                nonce: attendanceData.nonce,
                                record_id: response.data.id,
                                punch_out: punchOut,
                                notes: notes
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Punch out recorded successfully!');
                                    window.location.reload();
                                } else {
                                    alert('Error: ' + response.data);
                                }
                            },
                            error: function() {
                                alert('Server error. Please try again.');
                            }
                        });
                    }
                } else {
                    alert('No active session found for this user.');
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Save Complete Record button
    $('#save-record-btn').on('click', function() {
        var userId = $('#user_id').val();
        var punchIn = $('#punch_in').val();
        var punchOut = $('#punch_out').val();
        var notes = $('#notes').val();
        
        if (!userId || !punchIn) {
            alert('Please select a user and enter punch in time');
            return;
        }
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'save_complete_record',
                nonce: attendanceData.nonce,
                user_id: userId,
                punch_in: punchIn,
                punch_out: punchOut,
                notes: notes
            },
            success: function(response) {
                if (response.success) {
                    alert('Record saved successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Edit record
    $('.edit-record').on('click', function(e) {
        e.preventDefault();
        var recordId = $(this).data('id');
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'get_record',
                nonce: attendanceData.nonce,
                record_id: recordId
            },
            success: function(response) {
                if (response.success) {
                    var record = response.data;
                    
                    // Populate form
                    $('#user_id').val(record.user_id);
                    $('#punch_in').val(record.punch_in.slice(0, 16));
                    
                    if (record.punch_out) {
                        $('#punch_out').val(record.punch_out.slice(0, 16));
                    } else {
                        $('#punch_out').val('');
                    }
                    
                    $('#notes').val(record.notes);
                    
                    // Change save button text and add record ID as data attribute
                    $('#save-record-btn').text('Update Record').data('record-id', recordId);
                    
                    // Scroll to form
                    $('html, body').animate({
                        scrollTop: $('#add-attendance-form').offset().top - 50
                    }, 500);
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Delete record
    $('.delete-record').on('click', function(e) {
        e.preventDefault();
        var recordId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
            $.ajax({
                url: attendanceData.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_record',
                    nonce: attendanceData.nonce,
                    record_id: recordId
                },
                success: function(response) {
                    if (response.success) {
                        alert('Record deleted successfully!');
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.data);
                    }
                },
                error: function() {
                    alert('Server error. Please try again.');
                }
            });
        }
    });
    
    // Import CSV
    $('#import-csv-btn').on('click', function() {
        var formData = new FormData();
        var fileInput = $('#csv_file')[0];
        
        if (fileInput.files.length === 0) {
            alert('Please select a CSV file to import');
            return;
        }
        
        formData.append('action', 'process_csv_import');
        formData.append('nonce', attendanceData.nonce);
        formData.append('csv_file', fileInput.files[0]);
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    var resultsDiv = $('#import-results');
                    resultsDiv.removeClass('error');
                    
                    var content = '<h3>Import Results</h3>';
                    content += '<p>' + response.data.message + '</p>';
                    
                    if (response.data.error_count > 0 && response.data.errors.length > 0) {
                        content += '<h4>Errors:</h4>';
                        content += '<ul>';
                        $.each(response.data.errors, function(index, error) {
                            content += '<li>' + error + '</li>';
                        });
                        content += '</ul>';
                    }
                    
                    resultsDiv.html(content).show();
                } else {
                    var resultsDiv = $('#import-results');
                    resultsDiv.addClass('error');
                    resultsDiv.html('<h3>Import Error</h3><p>' + response.data + '</p>').show();
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
});