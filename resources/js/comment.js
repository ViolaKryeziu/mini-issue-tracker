document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('addCommentForm');
    const commentList = document.getElementById('comment-list');

    if(commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const url = commentForm.dataset.action;
            const formData = new FormData(commentForm);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(async res => {
                if(!res.ok) throw res;
                return res.json();
            })
            .then(comment => {
                const div = document.createElement('div');
                div.classList.add('comment', 'p-2', 'border', 'rounded');
                div.id = 'comment-' + comment.id;
                div.innerHTML = `<strong>${comment.author_name}</strong><p>${comment.body}</p>`;
                commentList.prepend(div);

                commentForm.reset();
                document.getElementById('error-author_name').textContent = '';
                document.getElementById('error-body').textContent = '';
            })
            .catch(async err => {
                if(err.status === 422){
                    const errors = await err.json();
                    document.getElementById('error-author_name').textContent = errors.errors.author_name ? errors.errors.author_name[0] : '';
                    document.getElementById('error-body').textContent = errors.errors.body ? errors.errors.body[0] : '';
                } else {
                    console.error(err);
                    alert('Something went wrong while submitting the comment.');
                }
            });
        });
    }
});
