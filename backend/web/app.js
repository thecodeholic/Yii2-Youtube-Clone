/**
 * Created by TheCodeholic on 4/12/2020.
 */
$(function () {
  'use strict';
  $('#videoFile').change((evt) => {
    console.log("changed");
    $(evt.target).closest('form')[0].submit()
  });
});