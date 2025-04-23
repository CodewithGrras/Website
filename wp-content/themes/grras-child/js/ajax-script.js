jQuery(document).ready(function($) {
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows' // Or any other layout mode you prefer
    });

    var page = 2; // Initial page for loading more posts
    var postsPerPage = 8; // Number of posts to load on each click

    $('#load-more-btn').on('click', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_courses_ak',
                page: page,
                term: '', // You can pass the term if you need to filter by taxonomy
                nonce: 'load_more_againa_nonce'
            },
            success: function(response) {
                var $items = $(response);
                $grid.append($items).isotope('appended', $items).isotope('reloadItems'); // Update Isotope layout

                // Increment page number
                page += 1;

                if (response.trim() == '') {
                    $('.load-more-button').hide();
                }
            }
        });
    });
});
