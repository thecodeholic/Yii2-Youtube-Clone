$(function () {
  const $leaveComment = $('#leave-comment');
  const $cancelComment = $('#cancel-comment');
  const $createCommentForm = $('#create-comment-form');
  const $commentsWrapper = $('#comments-wrapper')
  const $commentCount = $('#comment-count')
  let $editComment = $('.comment-actions .item-edit-comment')
  let $deleteComment = $('.comment-actions .item-delete-comment')

  $leaveComment.click(function () {
    $leaveComment
        .attr('rows', '2')
        .closest('.create-comment')
        .addClass('focused');

  });
  $cancelComment.click(resetForm);

  $createCommentForm.submit(ev => {
    ev.preventDefault();

    $.ajax({
      method: $createCommentForm.attr('method'),
      url: $createCommentForm.attr('action'),
      data: $createCommentForm.serializeArray(),
      success: function (res) {
        if (res.success) {
          $commentsWrapper.prepend(res.comment);
          resetForm();
          $commentCount.text(parseInt($commentCount.text()) + 1);
          initComments();
        }
      }
    })
        .done(function () {
          console.log(arguments);
        })
  })

  initComments();

  function initComments(){
    let $deleteComment = $('.comment-actions .item-delete-comment')
    let $editComment = $('.comment-actions .item-edit-comment');
    let $cancelComment = $('.comment-item .btn-cancel');
    let $commentEditForm = $('.comment-item .comment-edit-section');
    $deleteComment.off('click').on('click', onDeleteClick);

    $editComment.off('click').on('click', ev => {
      ev.preventDefault();
      const $this = $(ev.target);
      const $item = $this.closest('.comment-item').addClass('edit')
      const $textWrapper = $item.find('.text-wrapper');
      const $input = $item.find('textarea');
      $input.val($textWrapper.text().trim());
    });

    $cancelComment.off('click').on('click', ev => {
      const $this = $(ev.target);
      $this.closest('.comment-item').removeClass('edit');
    });

    $commentEditForm.off('submit').on('submit', ev => {
      ev.preventDefault();
      const $this = $(ev.target);

      $.ajax({
        method: $this.attr('method'),
        url: $this.attr('action'),
        data: $this.serializeArray(),
        success: function(res) {
          if (res.success) {
            const $item = $this.closest('.comment-item').addClass('edit')
            const $textWrapper = $item.find('.text-wrapper');
            const $input = $item.find('textarea');
            $textWrapper.text($input.val())
            $this.closest('.comment-item').removeClass('edit');
            $item.replaceWith(res.comment);
            initComments();
          }
        }
      })
    })
  }

  function resetForm() {
    $leaveComment.val('').attr('rows', '1')
    $cancelComment
        .closest('.create-comment')
        .removeClass('focused')
  }

  function onDeleteClick(ev) {
    ev.preventDefault();
    const $delete = $(ev.target);

    if (confirm('Are you sure you want to delete that comment?')) {
      $.ajax({
        method: 'post',
        url: $delete.attr('href'),
        success: function (res) {
          if (res.success)
            $delete.closest('.comment-item').remove();
          $commentCount.text(parseInt($commentCount.text()) - 1);
        }
      })
    }
  }
});