function acceptCookies() {
    console.log("Accept button clicked!");
    document.cookie = "cookie_consent=accepted; path=/; max-age=" + (60 * 60 * 24 * 30);

    if (document.cookie.includes("cookie_consent=accepted")) {
        console.log("Cookie was set successfully!");
    } else {
        console.log("Failed to set cookie.");
    }

    document.getElementById("cookieBox").style.display = "none";
    // Avoid reloading the page
}

function rejectCookies() {
    console.log("Reject button clicked!");
    window.location.href = "https://www.google.com";
}

document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");

    // Toggle like color
    const likeIcons = document.querySelectorAll('.like-icon');
    likeIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            this.classList.toggle('liked');
            const index = this.dataset.index;
            const likeCount = document.getElementById('like-count-' + index);
            likeCount.innerText = parseInt(likeCount.innerText) + (this.classList.contains('liked') ? 1 : -1);
        });
    });

    // Toggle repost color
    const repostIcons = document.querySelectorAll('.repost-icon');
    repostIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            this.classList.toggle('reposted');
            const index = this.dataset.index;
            const repostCount = document.getElementById('repost-count-' + index);
            repostCount.innerText = parseInt(repostCount.innerText) + (this.classList.contains('reposted') ? 1 : -1);
        });
    });

    // Search Trigger on 'Enter' Press
    document.querySelector('input[name="query"]').addEventListener('keypress', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            let searchQuery = this.value.trim();
            if (searchQuery !== "") {
                window.location.href = "?query=" + encodeURIComponent(searchQuery);
            }
        }
    });
});
function toggleForm(formType) {
    document.getElementById('formTitle').innerText = formType === 'register' ? 'Register' : 'Login';
    document.getElementById('loginForm').style.display = formType === 'register' ? 'none' : 'block';
    document.getElementById('registerForm').style.display = formType === 'register' ? 'block' : 'none';
}
window.location.href = "post.php";