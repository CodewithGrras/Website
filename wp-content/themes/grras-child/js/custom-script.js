jQuery(document).ready(function($) {
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();

        const fullname = $('#fullname').val();
        const email = $('#exampleInputEmail1').val();
        const review = $('#reviewText').val();
        const rating = $('#review-rating').val(); 
        
        $('#submitButton').prop('disabled', true).text('Waiting...');

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'submit_review',
                fullname: fullname,
                email: email,
                review: review,
                review_rating: rating 
            },
            success: function(response) {
                if (response.success) {
                    $('#responseMessage').text(response.data).css('color', 'green');
                    $('#reviewForm')[0].reset();
                    // $('#review-rating').val(0);
                } else {
                    $('#responseMessage').text(response.data).css('color', 'red');
                }
            },
            error: function() {
                $('#responseMessage').text('An error occurred. Please try again.').css('color', 'red');
            },
            complete: function() {
                $('#submitButton').prop('disabled', false).text('Submit Review');
            }
        });
    });
});
