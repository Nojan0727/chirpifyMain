document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");

    // Like button event listeners
    document.querySelectorAll('.like-icon').forEach(icon => {
        icon.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            likePost(index, this);
        });
    });

    // Repost button event listeners
    document.querySelectorAll('.repost-icon').forEach(icon => {
        icon.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            repost(index, this);
        });
    });
});

// Like post function
function likePost(index, icon) {
    fetch('update_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            index: index,
            action: 'like'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const countElement = document.getElementById(`like-count-${index}`);
            countElement.textContent = data.count;
            icon.classList.toggle('liked');
        } else {
            console.error('Error liking post:', data.error);
            alert('Failed to like the post: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while liking the post.');
    });
}

// Repost function
function repost(index, icon) {
    fetch('update_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            index: index,
            action: 'repost'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const countElement = document.getElementById(`repost-count-${index}`);
            countElement.textContent = data.count;
            icon.classList.toggle('reposted');
        } else {
            console.error('Error reposting post:', data.error);
            alert('Failed to repost the post: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while reposting the post.');
    });
}

function INVcommentForm(event, index) {
    let commentForm = document.getElementById('commentform' + index.toString());
    let darkEffect = document.getElementById("darkEffect");
    let body = document.body;
    let html = document.documentElement;

    if (commentForm.style.display === "none" ) {
        commentForm.style.display = "block";
        darkEffect.style.display = "block";
        comment_text.style.display = "block";
        
  
    } else {
        commentForm.style.display = "none";
        darkEffect.style.display = "none";
        comment_text.style.display = "block";
    }
};


