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

