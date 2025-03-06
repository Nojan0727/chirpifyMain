function acceptCookies() {
    console.log("Accept button clicked!");
    document.cookie = "cookie_consent=accepted; path=/; max-age=" + (60 * 60 * 24 * 30);


    if (document.cookie.includes("cookie_consent=accepted")) {
        console.log("Cookie was set successfully!");
    } else {
        console.log("Failed to set cookie.");
    }

    document.getElementById("cookieBox").style.display = "none";
    location.reload();
}

function rejectCookies() {
    console.log("Reject button clicked!");
    window.location.href = "https://www.google.com";
}

document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");
});
function toggleTerms() {
    let termsBox = document.getElementById("termsBox");
    if (termsBox.style.display === "none" || termsBox.style.display === "") {
        termsBox.style.display = "block";
    } else {
        termsBox.style.display = "none";
    }
}
// Like Post Function - Now updates the button text
function likePost(index) {
    let button = document.querySelector(`button[data-like="${index}"]`);
    let count = parseInt(button.dataset.count) + 1;
    button.dataset.count = count;
    button.innerText = `Like (${count})`;
}

// Repost Function - Now updates the button text
function repost(index) {
    let button = document.querySelector(`button[data-repost="${index}"]`);
    let count = parseInt(button.dataset.count) + 1;
    button.dataset.count = count;
    button.innerText = `Repost (${count})`;
}

// Search Trigger on 'Enter' Press
document.querySelector('input[name="query"]').addEventListener('keypress', function(event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent form from actually submitting
        let searchQuery = this.value.trim();
        if (searchQuery !== "") {
            window.location.href = "?query=" + encodeURIComponent(searchQuery); // Redirect with query
        }
    }
});
function toggleForm(formType) {
    document.getElementById('formTitle').innerText = formType === 'register' ? 'Register' : 'Login';
    document.getElementById('loginForm').style.display = formType === 'register' ? 'none' : 'block';
    document.getElementById('registerForm').style.display = formType === 'register' ? 'block' : 'none';
}
window.location.href = "post.php";