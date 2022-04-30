(() => {
  const form = document.querySelector('#add-post-form')
  const clearBtn = document.querySelector('.clear-btn');
  const previewBtn = document.querySelector("#preview-btn");

  const titleInput = form.querySelector('#title');
  const contentInput = form.querySelector('#content');

  const titleError = titleInput.parentElement.querySelector('.error');
  const contentError = contentInput.parentElement.querySelector('.error');

  clearBtn.addEventListener('click', e => {
    e.preventDefault();
    if (confirm("Are you sure you want to clear your entire post?\n" +
                "This cannot be undone.")) {
      form.reset();
    }
  });

  previewBtn.addEventListener('click', () => {
    form.setAttribute('action', '/view-blog.php');
    if (validateForm({ preventDefault() {} })) {
      form.submit();
    }
  })

  form.setAttribute('novalidate', 'novalidate')
  form.addEventListener('submit', validateForm);

  function validateNonEmpty(formControl, controlError) {
    if (formControl.value.length === 0) {
      controlError.textContent = 'Please fill in this field'
      controlError.classList.add('visible');
      return false;
    }

    controlError.textContent = '';
    controlError.classList.remove('visible')
    return true;
  }

  function validateForm(e) {
    if (!validateNonEmpty(titleInput, titleError)
      | !validateNonEmpty(contentInput, contentError)) {
      e.preventDefault()
      return false;
    }
    return true;
  }
})()
