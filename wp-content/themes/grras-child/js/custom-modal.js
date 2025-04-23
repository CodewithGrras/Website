// In custom-modal.js
document.addEventListener('DOMContentLoaded', function () {
    console.log("DOMContentLoaded event fired");

    // Define the showModal function on the window object
    window.showModal = function() {
        console.log("showModal function called");
        var exampleModal3sd = document.getElementById('exampleModal3sd');
        console.log("exampleModal3sd element:", exampleModal3sd);
        if (exampleModal3sd) {
            exampleModal3sd.classList.add('show');
            exampleModal3sd.style.display = 'block';

            var closeBtn = document.getElementById('close-btnsh');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    exampleModal3sd.classList.remove('show');
                    exampleModal3sd.style.display = 'none';
                });
            }

            exampleModal3sd.addEventListener('click', function(event) {
                if (event.target.id === 'exampleModal3sd') {
                    exampleModal3sd.classList.remove('show');
                    exampleModal3sd.style.display = 'none';
                }
            });
        } else {
            console.log("Modal element not found");
        }
    }

    console.log("Event listener added for showModalEvent");
});
