/**
 * Created by TheCodeholic on 4/17/2020.
 */
$(function () {
  'use strict';
  $('#videoFile').change(ev => {
    $(ev.target).closest('form').trigger('submit');
  })
});