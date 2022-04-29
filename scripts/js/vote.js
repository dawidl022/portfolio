(() => {
  const voteForm = document.querySelector('#vote-form');
  const voteBtn = voteForm.querySelector('button[type="submit"]');
  const postId = voteForm.querySelector('[name="post-id"]');
  const counter = voteForm.querySelector('.counter')

  if (isPostAlreadyLiked()) {
    voteBtn.classList.add('liked')
  } else {
    voteBtn.removeAttribute('disabled')
    voteForm.addEventListener('submit', likePost);
  }

  function likePost(e) {
    e.preventDefault();

    voteBtn.setAttribute('disabled', 'disabled');
    voteBtn.classList.add('liked');

    if (isPostAlreadyLiked()) {
      return;
    }

    counter.textContent = parseInt(counter.textContent) + 1;
    requestUpvote()
  }

  function requestUpvote() {

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/scripts/vote-up.php', true);
    xhr.setRequestHeader('Content-type', 'x-www-form-urlencoded');

    const param = `id=${postId.textContent}`

    xhr.onload = function() {
      if (this.status === 204) {
        let likedPosts = JSON.parse(localStorage.getItem('voted-posts'));
        if (!likedPosts) {
          likedPosts = []
        }

        likedPosts.push(postId)
        localStorage.setItem('voted-posts', likedPosts)
      }
    }

    xhr.send(param)
  }

  function isPostAlreadyLiked() {
    const votedPosts = localStorage.getItem('voted-posts');
    return votedPosts && JSON.parse(votedPosts).includes(postId);
  }
})()
