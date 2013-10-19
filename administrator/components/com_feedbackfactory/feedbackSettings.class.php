<?php

defined('_JEXEC') or die('Restricted access');

class feedbackSettings
{
  var $enable_guest_view     = 1;
  var $allow_guest_write     = 0;
  var $guest_captcha_write   = 0;
  var $allow_multiple_votes  = 0;
  var $min_top_votes         = 2;
  var $allow_guest_comments  = 0;
  var $comments_per_page     = 5;
  var $feedbacks_per_page    = 4;
  var $min_most_commented    = 2;
  var $captcha_comment       = 0;
  var $guest_captcha_comment = 1;
  var $use_cb_avatars        = 1;
  var $avatar_max_width      = 55;
  var $avatar_max_height     = 55;
  var $banned_words          = array('VmlhZ3Jh', 'c2V4');
  var $recaptcha_public_key  = 'NkxjQ2d1WVNBQUFBQUFLaFpkTWMxd1YzOGExWEsxMjBpaEVfaTdjdg==';
  var $recaptcha_private_key = 'NkxjQ2d1WVNBQUFBQUlTbjFEWW1ZZVVLZk1FQmE1S3FQeWJrZU1PRA==';
}