document.addEventListener('DOMContentLoaded', function() {
    const attachBtn = document.getElementById('attachTagBtn');
    const tagsContainer = document.getElementById('tagsContainer');

    if(attachBtn) {
        attachBtn.addEventListener('click', function() {
            const url = this.dataset.url;
            const tagId = document.getElementById('availableTags').value;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ tag_id: tagId })
            })
            .then(res => res.json())
            .then(() => {
                const tagName = document.querySelector(`#availableTags option[value="${tagId}"]`).textContent;
                const span = document.createElement('span');
                span.className = 'px-2 py-1 bg-gray-200 rounded flex items-center gap-1';
                span.innerHTML = `${tagName} <button class="detach-tag text-red-500" data-tag-id="${tagId}">x</button>`;
                tagsContainer.appendChild(span);
            });
        });

        // Detach tag
        tagsContainer.addEventListener('click', function(e) {
            if(e.target.classList.contains('detach-tag')){
                const tagId = e.target.dataset.tagId;
                const issueId = tagsContainer.dataset.issueId;
                fetch(`/issues/${issueId}/tags/${tagId}/detach`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(() => e.target.parentElement.remove());
            }
        });
    }
});
