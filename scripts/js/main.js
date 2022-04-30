(() => {
  const flashButton = document.querySelector('#close-flash');

  if (flashButton) {
    flashButton.addEventListener('click', () => {
      flashButton.parentElement.remove()
    })
  }
})()
