<?php
/**
 * Template Name: Gallary
 */
get_header();
$banner = get_field("banner");
?>
<!-- solution -->
<div class="solution">
    <div class="container">
        <h2><?php echo $banner["title"] ?></h2>
        <p><?php echo $banner["sub_title"] ?></p>
        <p><?php echo $banner["description"] ?></p>
    </div>
</div>

<!-- Social Presence -->
<div class="presence">
    <div class="container">
        <h2>Our Social Presence</h2>

        <div class="filters filter-button-group">
            <ul class="isolist">
                <li data-filter="*" class="active">All</li>
                <?php if (have_rows('social_presence')): ?>
                    <?php
                    // Initialize an empty array to track displayed categories
                    $displayed_categories = array();

                    while (have_rows('social_presence')): the_row();
                        $category = get_sub_field('category'); // Get the category

                        // Check if the category has already been displayed
                        if (!in_array($category, $displayed_categories)) {
                            // If not, display it and add to the array
                    ?>
                            <li data-filter=".<?php echo esc_attr($category); ?>">
                                <?php category_listing(); // Assuming this function displays the category's content ?>
                            </li>
                    <?php
                            // Add the category to the array to prevent further duplicates
                            $displayed_categories[] = $category;
                        }
                    endwhile;
                    ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="isocontent grid" id="gallery-container">
            <!-- Images will be loaded via JavaScript -->
        </div>

        <div class="text-center mt-5">
            <button id="load-more-btn" class="btn btn-secondary">Load More</button>
        </div>
    </div>
</div>

<!-- Image Popup Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <img src="" id="modalImage" class="img-fluid w-100" alt="">
            </div>
        </div>
    </div>
</div>

<?php
// Pre-fetch all social presence items and embed them directly in the page
$all_images = array();
$categories = array();

if (have_rows('social_presence')):
    while (have_rows('social_presence')): the_row();
        $category = get_sub_field('category');
        $images = get_sub_field('image');
        
        foreach($images as $img):
            $all_images[] = array(
                'url' => $img,
                'category' => $category
            );
        endforeach;
        
        // Add category to list if not already there
        if (!in_array($category, $categories)) {
            $categories[] = $category;
        }
    endwhile;
endif;
?>

<script>
jQuery(document).ready(function($) {
    // Store all images and their categories
    const allGalleryImages = <?php echo json_encode($all_images); ?>;
    const galleryCategories = <?php echo json_encode($categories); ?>;

    // Variables to control loading
    let imagesPerLoad = 8;
    let currentlyShown = 0;
    let currentFilter = '*';
    let $grid = $('.grid');
    let imageModal = null;
    
    // Initialize isotope
    $grid.isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    // Initialize modal once
    imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {
        backdrop: true,
        keyboard: true
    });
    
    // Handle modal hidden event to ensure backdrop is removed
    $('#imageModal').on('hidden.bs.modal', function () {
        // Force removal of any lingering backdrop
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
    });

    // Function to load images based on current filter
    function loadImages(filter = '*', reset = false) {
        // Reset if requested (when changing categories)
        if (reset) {
            $grid.isotope('remove', $grid.isotope('getItemElements'));
            currentlyShown = 0;
        }
        
        let filteredImages = allGalleryImages;
        
        // Apply filter if not showing all
        if (filter !== '*') {
            filteredImages = allGalleryImages.filter(img => img.category === filter);
        }
        
        // Calculate how many images to show
        let imagesToShow = Math.min(currentlyShown + imagesPerLoad, filteredImages.length);
        
        // Show or hide "Load More" button
        $('#load-more-btn').toggle(imagesToShow < filteredImages.length);
        
        // Add new images
        let $items = $();
        for (let i = currentlyShown; i < imagesToShow; i++) {
            const $div = $('<div>')
                .addClass(`single-content corporate grid-item ${filteredImages[i].category}`)
                .css('cursor', 'pointer')
                .attr('data-img-url', filteredImages[i].url); // Store the image URL as an attribute
            
            const $img = $('<img>')
                .attr('src', 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 3 2\'%3E%3C/svg%3E')
                .attr('data-src', filteredImages[i].url)
                .addClass('img-fluid lazy')
                .attr('alt', '');
            
            $div.append($img);
            $items = $items.add($div);
        }
        
        // Update the count of currently shown images
        currentlyShown = imagesToShow;
        
        // Add items to Isotope
        $grid.append($items)
             .isotope('appended', $items);
        
        // Initialize lazy loading for new images
        lazyLoadImages();
        
        // Attach click handler to open modal
        $items.on('click', function() {
            const imgUrl = $(this).attr('data-img-url');
            openImageModal(imgUrl);
        });
        
        // Force layout update after a small delay
        setTimeout(function() {
            $grid.isotope('layout');
        }, 100);
    }

    // Function to open image in modal
    function openImageModal(imgUrl) {
        // Set image src
        $('#modalImage').attr('src', imgUrl);
        
        // Make sure any existing backdrop is gone before showing new modal
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        
        // Show modal
        imageModal.show();
    }

    // Lazy loading function
    function lazyLoadImages() {
        const lazyImages = document.querySelectorAll('img.lazy');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const image = entry.target;
                        image.src = image.dataset.src;
                        image.classList.remove('lazy');
                        imageObserver.unobserve(image);
                        
                        // Handle image loaded event for Isotope
                        image.onload = function() {
                            $grid.isotope('layout');
                        };
                    }
                });
            });
            
            lazyImages.forEach(function(image) {
                imageObserver.observe(image);
            });
        } else {
            // Fallback for browsers that don't support IntersectionObserver
            lazyImages.forEach(function(image) {
                image.src = image.dataset.src;
                image.classList.remove('lazy');
                
                // Handle image loaded event for Isotope
                image.onload = function() {
                    $grid.isotope('layout');
                };
            });
        }
    }

    // Initial load
    loadImages('*', true);
    
    // Setup load more button
    $('#load-more-btn').on('click', function(e) {
        e.preventDefault();
        loadImages(currentFilter);
    });
    
    // Setup category filters
    $('.isolist li').on('click', function() {
        // Update active class
        $('.isolist li').removeClass('active');
        $(this).addClass('active');
        
        // Get the filter value
        const filterValue = $(this).attr('data-filter');
        currentFilter = filterValue === '*' ? '*' : filterValue.replace('.', '');
        
        // Reset and load images with new filter
        loadImages(currentFilter, true);
    });
    
    // Handle existing images that might be loaded directly from HTML
    $(document).on('click', '.grid-item', function() {
        const imgUrl = $(this).attr('data-img-url') || $(this).find('img').attr('src');
        if (imgUrl) {
            openImageModal(imgUrl);
        }
    });
    
    // Additional safeguard: clean up any modal backdrops when ESC key is pressed
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }
    });
});
</script>

<style>
/* Add a simple loading effect for lazy images */
img.lazy {
    opacity: 0;
    transition: opacity 0.3s;
}
img.lazy[src^="data:image"] {
    opacity: 0.2;
}
img:not(.lazy) {
    opacity: 1;
}

/* Add placeholder sizing to prevent layout shifts */
.single-content img {
    min-height: 200px;
    background-color: #f5f5f5;
}

/* Style for the gallery items to indicate they're clickable */
.grid-item {
    cursor: pointer;
    transition: transform 0.3s;
    overflow: hidden;
}

.grid-item:hover {
    transform: scale(1.02);
}

/* Modal styling */
#imageModal .modal-content {
    background-color: rgba(255, 255, 255, 0.95);
    border: none;
}

#imageModal .btn-close {
    position: absolute;
    right: 10px;
    top: 0px;
    z-index: 1050;
    background-color: white;
    border-radius: 50%;
    padding: 8px;
}

#imageModal .modal-body {
    padding: 10px;
}

/* Fix for stuck backdrop */
.modal-backdrop.show {
    z-index: 1040;
}
</style>

<?php
include "components/faq.php";
get_footer();
?>