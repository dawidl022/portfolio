(() => {
  const commentsContainer = document.querySelector('.comments');
  const deleteForms = document.querySelectorAll(".delete-comment");
  const addCommentForm = document.querySelector("#comment-form");
  const commentCount = document.querySelector('.comment-count .counter');
  let commentList = document.querySelector("#comment-list");

  addCommentForm.addEventListener('submit', addComment);
  deleteForms.forEach(form => form.addEventListener('submit', deleteComment));

  function deleteComment(e) {
    e.preventDefault();

    if (!confirm('Delete this comment?')) {
      return;
    }

    const commentId = e.target['comment-id'].value;
    const params = `comment-id=${commentId}&async=true`;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/scripts/delete-comment.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
      if (this.status === 204) {
        e.target.parentElement.parentElement.parentElement.remove();
        commentCount.textContent = parseInt(commentCount.textContent) - 1;

        if (commentList.children.length === 0) {
          commentList.remove();

          const noComments = document.createElement('em');
          noComments.textContent = 'No comments to display';
          noComments.setAttribute('id', 'no-comments');
          commentsContainer.appendChild(noComments);
        }
      } else {
        // TODO flash message with error
      }
    }

    xhr.send(params);
  }

  function addComment(e) {
    e.preventDefault();

    const postId = e.target['post-id'].value;
    const content = e.target['comment'].value;

    const params = `post-id=${postId}&comment=${encodeURI(content)}&async=true`;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/scripts/add-comment.php', true)
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
      if (this.status === 200) {
        const comment = document.createElement('li');
        comment.innerHTML = this.responseText;
        comment.querySelector('.delete-comment')
          .addEventListener('submit', deleteComment);

        if (!commentList || !commentList.parentElement) {
          commentList = document.createElement('ol');
          commentList.setAttribute('id', 'comment-list');
          commentsContainer.querySelector('#no-comments').remove();
          commentsContainer.appendChild(commentList);
        }

        commentList.appendChild(comment);
        commentCount.textContent = parseInt(commentCount.textContent) + 1;
        e.target.reset()
        // TODO display flash message
      } else {
        // TODO display flash message
      }
    }

    xhr.send(params);
  }
})()
