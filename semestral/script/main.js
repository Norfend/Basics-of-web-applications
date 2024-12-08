function checkUsernameAvailability() {
    const username = document.getElementById('username');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'validate-username.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();

            if (response === 'AVAILABLE') {
                alert('Username is available!');
            } else if (response === 'UNAVAILABLE') {
                alert('Username is already taken. Please choose another one.');
            } else {
                alert('Invalid username.');
            }
        }
    };

    xhr.send('username=' + encodeURIComponent(username));
}

// Attach the function to button click event
document.getElementById('check-username-btn').addEventListener('click', checkUsernameAvailability);

// Prevent form submission until everything is valid
document.getElementById('signup-form').addEventListener('submit', function(e) {
    e.preventDefault();  // Prevent form submission

    alert('Form submitted successfully!');  // Replace with your actual form submission logic
});
