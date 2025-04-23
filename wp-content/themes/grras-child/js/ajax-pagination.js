jQuery(document).ready(function($) {
    var page = 1;

    $('#load-more-course').on('click', function(e) {
        e.preventDefault();
        var button = $(this);

            $.ajax({
                url: ajaxpagination.ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_courses',
                    page: page
                },
                beforeSend: function() {
                    button.text('Loading...');
                },
                success: function(data) {
                    if (data !== '<p>No more posts found</p>') {
                        page++;
                        $('#course-container').append(data);
                        button.text('Load More');
                    } else {
                        button.text('Show Less').attr('id', 'load-less-course');
                    }
                }
            });

    });

    // Function to show only the first 4 posts when "Show Less" is clicked
    function showLessPosts() {
        $('#course-container').children().slice(4).remove();
        $('#load-more-course').text('Load More').prop('disabled', false);
        page = 2; // Reset page number if needed
    }

    // Attach click event to "Show Less" button
    $(document).on('click', '#load-less-course', function() {
        var button = $(this);
        button.text('Show More').attr('id', 'load-more-course');
        showLessPosts();
    });
});

jQuery(document).ready(function($) {
    var offset = 6; // Initial offset for already loaded posts
    var postsPerPage = 6; // Number of posts to load on each click
    var loadedPosts = []; // Array to track loaded post IDs

    $('.readmore').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: ajaxpagination.ajaxurl,
            type: 'GET',
            data: {
                action: 'load_more_placements',
                offset: offset,
                posts_per_page: postsPerPage,
                loaded_posts: loadedPosts
            },
            success: function(response) {
                if (response == 'No more success stories found.') {
                    $('.readmore').text('Show Less').attr('id', 'load-less');
                }
                var $items = $(response);
                $('#placement_items .row').append($items);
                $('.grid').isotope('appended', $items).isotope('reloadItems'); // Update Isotope layout

                // Update the loadedPosts array with new post IDs
                $items.each(function() {
                    loadedPosts.push($(this).data('post-id'));
                });

                // Update the offset
                offset += postsPerPage;

                
            }
        });
    });
      

    // Attach click event to "Show Less" button
    $(document).on('click', '#load-less', function() {
        window.location.reload(true);
    });
});



