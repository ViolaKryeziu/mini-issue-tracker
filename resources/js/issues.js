document.addEventListener('DOMContentLoaded', function() {
    const addIssueForm = document.getElementById('addIssueForm');
    const issuesList = document.getElementById('issuesList');

    if(addIssueForm && issuesList) {
        addIssueForm.addEventListener('submit', function(e){
            e.preventDefault();
            let formData = new FormData(addIssueForm);

            fetch(addIssueForm.action || '/issues', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.errors){
                    if(data.errors.title) document.getElementById('error-title').textContent = data.errors.title[0];
                    if(data.errors.description) document.getElementById('error-description').textContent = data.errors.description[0];
                } else if(data.issue){
                    const li = document.createElement('li');
                    li.className = "bg-gray-50 p-4 rounded shadow flex justify-between items-center";
                    let tagsHtml = '';
                    if(data.issue.tags && data.issue.tags.length > 0){
                        tagsHtml = '<div class="flex gap-2 mt-1">';
                        data.issue.tags.forEach(tag => {
                            tagsHtml += `<span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">${tag.name}</span>`;
                        });
                        tagsHtml += '</div>';
                    }
                    li.innerHTML = `
                        <div>
                            <p class="font-semibold text-gray-800">${data.issue.title}</p>
                            <p class="text-gray-500 text-sm">Status: ${data.issue.status}</p>
                            ${tagsHtml}
                        </div>
                        <a href="/issues/${data.issue.id}" class="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded shadow">View</a>
                    `;
                    issuesList.prepend(li);
                    addIssueForm.reset();
                }
            })
            .catch(err => console.error(err));
        });
    }

    // -------- Live Search + Filters --------
    const searchInput = document.getElementById('searchInput');
    const filtersForm = document.getElementById('filters');

    if(searchInput && issuesList && filtersForm){
        let debounceTimeout;

        function fetchIssues() {
            const formData = new FormData(filtersForm);
            const queryString = new URLSearchParams(formData).toString();

            fetch(`/issues?${queryString}`, {
                headers:{ 'Accept':'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                issuesList.innerHTML = '';
                data.issues.forEach(issue => {
                    let tagsHtml = '';
                    if(issue.tags && issue.tags.length > 0){
                        tagsHtml = '<div class="flex gap-2 mt-1">';
                        issue.tags.forEach(tag => {
                            tagsHtml += `<span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">${tag.name}</span>`;
                        });
                        tagsHtml += '</div>';
                    }
                    const li = document.createElement('li');
                    li.className = "p-3 bg-white rounded shadow mb-2";
                    li.innerHTML = `
                        <a href="/issues/${issue.id}" class="font-semibold hover:underline">${issue.title}</a>
                        <div class="text-sm text-gray-600">${issue.project_name || ''}</div>
                        <div class="text-sm">Status: ${issue.status} | Priority: ${issue.priority}</div>
                        ${tagsHtml}
                    `;
                    issuesList.appendChild(li);
                });
            })
            .catch(err => console.error(err));
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(fetchIssues, 350);
        });

        filtersForm.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', fetchIssues);
        });
    }

});
