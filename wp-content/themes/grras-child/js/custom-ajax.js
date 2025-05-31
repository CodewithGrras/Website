document.addEventListener('DOMContentLoaded', function () {
  const courseContainer = document.getElementById('course-container-mobile');
  const paginationContainer = document.getElementById('pagination-container');
function capitalize(str) {
       return str.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    }
  function loadCourses(category = '', page = 1) {
    const data = new FormData();
    data.append('action', 'load_courses');
    data.append('category', category);
    data.append('page', page);

    fetch(ajaxurl, {
      method: 'POST',
      body: data,
    })
      .then(response => response.json())
      .then(data => {
        // Inject the courses HTML into the container
        if(courseContainer) {
          courseContainer.innerHTML = data.courses;
        }
        

        // Inject the pagination HTML into the container
        if(paginationContainer) {
          paginationContainer.innerHTML = data.pagination;
        }
        
      })
      .catch(error => console.error('Error:', error));
  }

  // Handle category filter
  var categoryFilter = document.getElementById('category-filter');
  if (categoryFilter) {
    document.getElementById('category-filter').addEventListener('click', function (e) {
      if (e.target.classList.contains('dropdown-item')) {
        e.preventDefault();
        const categories = document.querySelectorAll('.dropdown-item');

        categories.forEach(category => {
            if (category.classList.contains('active')) {
                category.classList.remove('active');
            }
        });

        e.target.classList.add('active')
        const category = e.target.getAttribute('data-category');
        var buttons = document.querySelectorAll('.btn-light');

        // Iterate through each selected element and add the text
        buttons.forEach(function(button) {
            button.textContent =  category ? capitalize(category) : "All";
        });


          loadCourses(category);
      }
    });
  }

  // Handle pagination click
  if(paginationContainer) {
    paginationContainer.addEventListener('click', function (e) {
    if (e.target.classList.contains('page-link')) {
      e.preventDefault();
      const page = e.target.getAttribute('data-page');
      const category = document.querySelector('.dropdown-item.active')?.getAttribute('data-category') || '';
      loadCourses(category, page);
    }
  });
  }
  

  // Initial load
  loadCourses();
});
