(() => {
  const deleteForms = document.querySelectorAll('.delete-post');

  deleteForms.forEach(form => form.addEventListener('click', deletePrompt));

  function deletePrompt(e) {
    if(!confirm('Delete this post?')) {
      e.preventDefault();
    }
  }
})()
