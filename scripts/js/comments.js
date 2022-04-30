(() => {
  const deleteForms = document.querySelectorAll(".delete-comment");
  const commentList = document.querySelector("#comment-list");

  deleteForms.forEach(form => form.addEventListener('submit', deleteComment));

  function deleteComment(e) {
    e.preventDefault();

    if (!confirm('Delete this comment?')) {
      return;
    }

    const commentId = e.target['comment-id'].value;
    const params = `comment-id=${commentId}&async=true`;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/scripts/delete-comment.php', true)
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

    xhr.onload = function() {
      if (this.status === 204) {
        e.target.parentElement.parentElement.remove();

        if (commentList.children.length === 0) {
          const parent = commentList.parentElement
          commentList.remove();
          parent.innerHTML += '<em>No comments to display</em>';
        }
      } else {
        // TODO flash message with error
      }
    }

    xhr.send(params);
  }
})()
