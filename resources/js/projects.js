document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addIssueForm');
    const issuesList = document.getElementById('issuesList');

    if (!form || !issuesList) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(form);

        document.getElementById('error-title').textContent = '';
        document.getElementById('error-description').textContent = '';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.errors) {
                if (data.errors.title) {
                    document.getElementById('error-title').textContent = data.errors.title[0];
                }
                if (data.errors.description) {
                    document.getElementById('error-description').textContent = data.errors.description[0];
                }
            } else if (data.issue) {
                let tagsHtml = '';
                if (data.issue.tags && data.issue.tags.length) {
                    tagsHtml = '<div class="flex gap-2 mt-1">';
                    data.issue.tags.forEach(tag => {
                        tagsHtml += `<span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">${tag.name}</span>`;
                    });
                    tagsHtml += '</div>';
                }

                const li = document.createElement('li');
                li.className = "bg-gray-50 p-4 rounded shadow flex justify-between items-center";
                li.setAttribute('data-id', data.issue.id);
                li.innerHTML = `
                    <div>
                        <p class="font-semibold text-gray-800">${data.issue.title}</p>
                        <p class="text-gray-500 text-sm">Status: ${data.issue.status}</p>
                        ${tagsHtml}
                    </div>
                    <a href="/issues/${data.issue.id}" class="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded shadow">View</a>
                `;
                issuesList.prepend(li);
                form.reset();
            }
        })
        .catch(err => console.error(err));
    });
});
