
jQuery(function($) {
    let page = 2; // Start from page 2 because page 1 is already loaded
    
    $('#load-more').on('click', function() {
        var button = $(this);
        var data = {
            action: 'load_more_posts',
            page: page,
            nonce: load_more_params.nonce,
        };

        // Disable the button to prevent multiple clicks
        button.prop('disabled', true);

        $.ajax({
            url: load_more_params.ajax_url,
            data: data,
            type: 'POST',
            success: function(response) {
                if (response) {
                    // Append the new posts
                    $('#post-container').append(response);
                    page++; // Increment page number
                    button.prop('disabled', false); // Enable the button again
                } else {
                    button.text('No More Posts').prop('disabled', true); // Disable button if no more posts
                }
            }
        });
    });
});

jQuery(function($) {
    let term = '*'; // Default term (all)

    // Handle tab click
    $('.isolist li').on('click', function() {
        $('.isolist li').removeClass('active');
        $(this).addClass('active');
        term = $(this).data('term');
        loadPosts(term, 1, true);
    });

    // Handle "View More" button click
    $('#load-more-btn').on('click', function() {
        var button = $(this);
        var page = button.data('page');
        loadPosts(term, page, false);
        button.data('page', page + 1);
    });

    function loadPosts(term, page, reset) {
        var data = {
            action: 'load_more_courses_ak',
            page: page,
            nonce: load_more_againa_params.nonce,
            term: term
        };

        $.ajax({
            url: load_more_againa_params.ajax_url,
            data: data,
            type: 'POST',
            beforeSend: function() {
                if (reset) {
                    $('#post-container').html(''); // Reset content if new tab
                    $('#load-more-btn').data('page', 2); // Reset "View More" page count
                }
            },
            success: function(response) {
                if (response) {
                    $('#post-container').append(response);
                } else {
                    $('#load-more-btn').text('No More Courses').prop('disabled', true);
                }
            }
        });
    }
});
