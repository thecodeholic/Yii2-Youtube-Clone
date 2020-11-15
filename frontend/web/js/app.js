$(function () {
  const $createCommentForm = $('.create-comment-form');
  const $commentsWrapper = $('#comments-wrapper')
  const $commentCount = $('#comment-count')

  initCommentForm($createCommentForm, false, false,
      () => {
        resetForm();
      }, () => {
        $.ajax({
          method: $createCommentForm.attr('method'),
          url: $createCommentForm.attr('action'),
          data: $createCommentForm.serializeArray(),
          success: function (res) {
            if (res.success) {
              const $pinnedComment = $commentsWrapper.find('.pinned-comment');
              const $tmp = $(res.comment);
              if ($pinnedComment.length) {
                $tmp.insertAfter($pinnedComment);
              } else {
                $commentsWrapper.prepend($tmp);
              }

              resetForm();
              $commentCount.text(parseInt($commentCount.text()) + 1);
              initComment($tmp);
            }
          }
        })
      });
  initComments();

  function resetForm() {
    const $textarea = $createCommentForm.find('textarea')
    $textarea.val('').attr('rows', '1')
    $textarea
        .closest('.create-comment')
        .removeClass('focused')
  }

  function initCommentForm($form,
                           placeholder = false,
                           btnSaveText = false,
                           cancelCb = false,
                           submitCb = false) {
    const $cancel = $form.find('.btn-cancel')
    const $save = $form.find('.btn-save')
    const $textarea = $form.find('textarea')

    if (placeholder) {
      $textarea.attr('placeholder', placeholder);
    }
    if (btnSaveText) {
      $save.text(btnSaveText);
    }

    $textarea.click(function () {
      console.log("111");
      $textarea
          .attr('rows', '2')
          .closest('.create-comment')
          .addClass('focused');
    });
    $cancel.click(ev => {
      if (cancelCb && typeof cancelCb === 'function') {
        cancelCb();
      }
    });
    $form.submit(ev => {
      ev.preventDefault();
      if (submitCb && typeof submitCb === 'function') {
        submitCb();
      }
    })

  }

  function initComment($comment) {
    const $delete = $comment.find('.item-delete-comment')
    const $edit = $comment.find('.item-edit-comment');
    const $pin = $comment.find('.item-pin-comment');
    const $cancel = $comment.find('.btn-cancel');
    const $form = $comment.find('.comment-edit-section');
    const $textWrapper = $comment.find('.text-wrapper');
    const $input = $comment.find('textarea');
    const $reply = $comment.find('.btn-reply');
    const $replySection = $comment.find('.reply-section');
    const $subCommentsSection = $comment.find('.sub-comments');
    const $viewSubComments = $comment.find('.view-sub-comments');
    const $channelLink = $comment.find('.channel-link');
    let replyFormDisplayed = false;
    let commentsLoaded = false;
    let commentsCollapsed = true;
    let mentionUsername = null;

    $pin.on('click', onCommentPin)

    $delete.on('click', onDeleteClick);

    $edit.on('click', ev => {
      ev.preventDefault();
      $comment.addClass('edit');
      $input.val($textWrapper.text().trim());
    });

    $cancel.on('click', ev => {
      mentionUsername = null;
      $comment.removeClass('edit');
    });

    $form.on('submit', onEditFormSubmit)

    $reply.on('click', onReplyClick);

    $viewSubComments.on('click', loadSubComments)

    function onCommentPin(ev) {
      ev.preventDefault();

      const pinned = $pin.data('pinned');
      if (pinned) {
        if (!confirm("Are you sure you want to unpin this comment?")) {
          return;
        }
      } else {
        if (!confirm("You are about to pin the comment. Are you sure you want to unpin any other comments?")) {
          return;
        }
      }

      $.ajax({
        method: 'post',
        url: $pin.attr('href'),
        success: (res) => {
          if (res.success) {
            $comment.remove();
            $commentsWrapper.find('.pinned-text').remove();
            $commentsWrapper.prepend(res.comment);
            const $firstComment = $commentsWrapper.find('.comment-item').eq(0);
            initComment($firstComment);
          }
        }
      })
    }

    function onEditFormSubmit(ev) {
      ev.preventDefault();

      $.ajax({
        method: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serializeArray(),
        success: function (res) {
          if (res.success) {
            $comment.removeClass('edit')
            $textWrapper.text($input.val());
            const $div = $('<div>');
            $div.html(res.comment);
            const $newComment = $div.find('>div');
            $comment.replaceWith($newComment);
            initComment($newComment);
          }
        }
      })
    }

    function onReplyClick(ev) {
      const isParentComment = !$comment.data('parent-id');

      if (replyFormDisplayed) {
        return;
      }
      const $newForm = $createCommentForm.clone();
      $replySection.append($newForm);
      const $textarea = $newForm.find('textarea');
      replyFormDisplayed = true;

      if (!isParentComment) {
        mentionUsername = $channelLink.text()
        $textarea.val('@' + mentionUsername + ' ');
        $textarea[0].focus();
      }

      $textarea.click(ev => {
        ev.stopImmediatePropagation();
      })

      initCommentForm(
          $newForm,
          'Add a public reply...',
          'Reply',
          () => {
            $newForm.remove();
            replyFormDisplayed = false;
          },
          () => {
            const value = $textarea.val();
            if (value.indexOf('@'+mentionUsername) !== 0) {
              mentionUsername = null;
            }
            $.ajax({
              method: 'post',
              url: $reply.data('action'),
              data: {
                comment: value,
                mention: mentionUsername,
                parent_id: $reply.closest('.comment-item').data('id')
              },
              success: (res) => {
                console.log(res);
                if (res.success) {
                  $newForm.remove();
                  replyFormDisplayed = false;

                  let $parentSubCommentSection = $subCommentsSection;
                  if ($comment.closest('.sub-comments').length) {
                    $parentSubCommentSection = $comment.closest('.sub-comments');
                  }
                  $parentSubCommentSection.append(res.comment);
                  const $lastComment = $parentSubCommentSection.find('>.comment-item').last();
                  initComment($lastComment);

                  $commentCount.text(parseInt($commentCount.text()) + 1);
                } else {
                  const commentErrors = res.errors.comment;
                  if (commentErrors) {
                    const $error = $('<small class="text-danger">');
                    $error.html(commentErrors[0]);
                    $error.insertAfter($textarea);
                  }
                }
              },
            })
          }
      )
    }

    function loadSubComments(ev) {
      ev.preventDefault();
      commentsCollapsed = !commentsCollapsed;

      if (commentsCollapsed) {
        $subCommentsSection.css('display', 'none');
      } else {
        $subCommentsSection.css('display', 'block');
      }

      if (commentsLoaded) {
        return;
      }
      $.ajax({
        url: $viewSubComments.attr('href'),
        success: (res) => {
          console.log(res);
          if (res.success) {
            commentsLoaded = true;
            $subCommentsSection.append(res.comments);
            const $subComments = $subCommentsSection.find('.comment-item');
            $subComments.each((ind, comment) => {
              initComment($(comment))
            })
          }
        }
      })
    }
  }

  function initComments() {
    const $comments = $('.comment-item');
    $comments.each((ind, comment) => {
      const $comment = $(comment);
      initComment($comment);
    })
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