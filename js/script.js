$(document).ready(function() {
    $('#userTable').DataTable();
});
/**
 * General function to handle form submission using AJAX.
 * @param {string} formId - The ID of the form to submit
 * @param {string} url - The URL to submit the form data to
 * @param {function} callback - A callback to handle the response
 */

/**
 * Handles the submission of the sign-up form.
 * @param {Event} event - The form submission event
 */


// This function handles the form submission asynchronously
function handleSignUpFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission
    
    // Get the form data and send it using the helper function
    handleFormSubmission('signupForm', 'sign_up.php', function (response) {
        // Show SweetAlert based on the server response
        Swal.fire({
            title: response.status === 'success' ? 'Success!' : 'Error',
            text: response.message,
            icon: response.status,
            confirmButtonText: response.status === 'error' ? 'Try Again' : 'Okay' 
        }).then(() => {
            if (response.redirect) {
                // Redirect if success
                window.location.href = response.redirect;
            } else {
                // Reset form if there was an error (e.g., username taken)
                document.getElementById('signupForm').reset();
            }
        });
    });
}

// Helper function to handle form submission asynchronously
function handleFormSubmission(formId, actionUrl, callback) {
    const form = document.getElementById(formId);
    const formData = new FormData(form); // Collect form data
    
    fetch(actionUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => callback(data)) // Call callback with response
    .catch(error => console.error('Error:', error)); // Handle any errors
}

// Attach the submit event listener to the form
document.getElementById('signupForm').addEventListener('submit', handleSignUpFormSubmission);


