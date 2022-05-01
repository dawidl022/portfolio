function setFlash(style, contentElement, closable = true) {
  function closeFlash(e) {
    e.target.parentElement.remove();
  }

  const topBar = document.querySelector('.top-bar');

  const flash = document.createElement('aside');
  flash.className = `flash ${style}`

  const message = document.createElement('strong');
  message.className = 'message';
  message.appendChild(contentElement);
  flash.appendChild(message)

  if (closable) {
    const closeBtn = document.createElement('button');
    closeBtn.textContent = 'X';
    closeBtn.setAttribute('type', 'button');
    closeBtn.setAttribute('aria-label', 'close message');
    closeBtn.className = 'close-btn';

    closeBtn.addEventListener('click', closeFlash)

    flash.appendChild(closeBtn);
  }

  const oldFlash = document.querySelector('.flash');

  if (oldFlash) {
    oldFlash.remove();
  }

  topBar.appendChild(flash);
}
