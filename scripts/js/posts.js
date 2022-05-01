(() => {
  function bindDeleteListeners() {
    const deleteForms = document.querySelectorAll('.delete-post');
    deleteForms.forEach(form => form.addEventListener('click', deletePrompt));
  }

  function deletePrompt(e) {
    if(!confirm('Delete this post?')) {
      e.preventDefault();
    }
  }

  const monthDropdown = document.querySelector("#month-dropdown");
  const postsContainer = document.querySelector('.posts');

  if (location.search === '') {
    history.replaceState({month: 'any'}, '', '/blog')
  }

  bindDeleteListeners();

  monthDropdown.addEventListener('change', e => fetchPosts(e.target.value, true));
  addEventListener('popstate', e => {
    if (e.state) {
      fetchPosts(e.state.month, false);
      monthDropdown.value = e.state.month;
    }
  });

  function fetchPosts(month, pushToHistory) {
    const xhr = new XMLHttpRequest();
    const params = `month=${month}`;
    xhr.open('GET', `/scripts/fetch-posts.php?${params}`, true);

    xhr.onload = function() {
      postsContainer.innerHTML = this.responseText;
      bindDeleteListeners();

      if (pushToHistory) {
        history.pushState({ month }, '', `/blog.php?${params}`)
      }
    }

    xhr.send();
  }
})()
