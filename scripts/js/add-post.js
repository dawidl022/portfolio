(() => {
  const form = document.querySelector('#add-post-form')
  const clearBtn = document.querySelector('.clear-btn');

  clearBtn.addEventListener('click', e => {
    e.preventDefault();
    if (confirm("Are you sure you want to clear your entire post?\n" +
                "This cannot be undone.")) {
      form.reset();
    }
  })
})()
