<?php
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class FrontendModelComment extends JModelLegacy
{
  function __construct()
  {
    parent::__construct();

    $this->feedbackSettings = new feedbackSettings();
  }
  
  function store()
  {
    $user = JFactory::getUser();

    if ($user->guest && !$this->feedbackSettings->allow_guest_comments)
    {
      die('{ "errors": 2, "message": "' . JText::_('You must login to be able to write a comment') . '"}');
    }

    if ($this->feedbackSettings->captcha_comment)
    {
      require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'recaptcha'.DS.'recaptchalib.php');

      $resp = recaptcha_check_answer(base64_decode($this->feedbackSettings->recaptcha_private_key),
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);

      if (!$resp->is_valid)
      {
        die('{ "errors": 1, "message": "' . JText::_('Invalid captcha! Try again!') . '"}');
      }
    }

    $app = JFactory::getApplication();
    $content = $app->input->getString('comment', '');
    $feedback_id = $app->input->getInt('feedback_id', 0);

    $query = ' SELECT f.enable_comments, f.user_id'
           . ' FROM #__feedback_feedbacks f'
           . ' WHERE f.id = ' . $feedback_id;
    $this->_db->setQuery($query);
    $info = $this->_db->loadObject();

    if (!$info->enable_comments)
    {
      die('{ "errors": 2, "message": "' . JText::_('Comments have been disabled for this feedback') . '"}');
    }

    // Get banned words list
    $banned_words = $this->feedbackSettings->banned_words;
    foreach ($banned_words as $i => $word)
    {
      $banned_words[$i] = base64_decode($word);
    }

    $author_name  = $app->input->getString('author_name',  '');
    $author_email = $app->input->getString('author_email', '');

    $content = str_ireplace($banned_words, '***', $content);

    $comment =& $this->getTable('comment');

    $comment->feedback_id  = $feedback_id;
    $comment->user_id      = $user->id;
    $comment->author_name  = $author_name;
    $comment->author_email = $author_email;
    $comment->comment      = $content;
    $comment->date_added   = date('Y-m-d H:i:s');

    $comment->store();

    die('{ "errors": 0, "message": "' . JText::_('Comment saved') . '" }');
    // Send notification
  /*  if ($this->feedbackSettings->enable_notification_new_comment)
    {
      $this->sendNewCommentNotification($comment->id);
    }
*/
    
  }

  function sendNewCommentNotification($comment_id)
  {
    $query = ' SELECT c.content, c.id, p.title AS feedback_title, p.id AS feedback_id, b.title AS blog_title,'
           . '   b.id AS blog_id, u.username AS owner_username, u.id AS owner_id, u.email AS owner_email,'
           . '   b.comment_notification'
           . ' FROM #__feedbackfactory_comments c'
           . ' LEFT JOIN #__feedbackfactory_feedbacks p ON p.id = c.feedback_id'
           . ' LEFT JOIN #__feedbackfactory_blogs b ON b.id = p.blog_id'
           . ' LEFT JOIN #__users u ON u.id = b.user_id'
           . ' WHERE c.id = ' . $comment_id;
    $this->_db->setQuery($query);
    $comment = $this->_db->loadObject();

    $subject = base64_decode($this->feedbackSettings->notification_new_comment_subject);
    $message = base64_decode($this->feedbackSettings->notification_new_comment_message);

    $search  = array('%%username%%', '%%feedbacktitle%%', '%%commenttext%%', '%%feedbacklink%%', '%%bloglink%%', '%%commentlink%%');

    // Send notification to the blog owner
    if ($comment->comment_notification)
    {
      $replace = array(
        $comment->owner_username,
        $comment->blog_title,
        $comment->feedback_title,
        $comment->content
      );

      if ($this->feedbackSettings->enable_notification_email_html)
      {
        $replace[] = '<a href="' . JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id) . '">' . $comment->feedback_title . '</a>';
        $replace[] = '<a href="' . JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id) . '#comments">' . $comment->feedback_title . '</a>';
      }
      else
      {
        $replace[] = JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id);
        $replace[] = JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id . '#comments');
      }

      $custom_message = str_replace($search, $replace, $message);
      $custom_subject = str_replace($search, $replace, $subject);

      if ($this->feedbackSettings->enable_notification_email_html)
      {
        $custom_message = nl2br($custom_message);
      }

      $mail =& JFactory::getMailer();
      $mail->addRecipient($comment->owner_email);
      $mail->setSubject(JText::_($custom_subject));
      $mail->setBody(JText::_($custom_message));
      $mail->IsHTML($this->feedbackSettings->enable_notification_email_html);

      $mail->send();
    }

    // Send notifications to the admins
    if (count($this->feedbackSettings->notification_new_comment_receivers))
    {
      $query = ' SELECT u.username, u.email'
             . ' FROM #__users u'
             . ' WHERE u.id IN (' . implode(', ', $this->feedbackSettings->notification_new_comment_receivers) . ')';
      $this->_db->setQuery($query);
      $receivers = $this->_db->loadObjectList();

      foreach ($receivers as $receiver)
      {
        $replace = array(
          $receiver->username,
          $comment->blog_title,
          $comment->feedback_title,
          $comment->content
        );

        if ($this->feedbackSettings->enable_notification_email_html)
        {
          $replace[] = '<a href="' . JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id) . '">' . $comment->feedback_title . '</a>';
          $replace[] = '<a href="' . JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=blog&id=' . $comment->blog_id) . '">' . $comment->blog_title . '</a>';
          $replace[] = '<a href="' . JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id) . '#comments">' . $comment->feedback_title . '</a>';
        }
        else
        {
          $replace[] = JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id);
          $replace[] = JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=blog&id=' . $comment->blog_id);
          $replace[] = JRoute::_(JURI::root() . 'index.php?option=com_feedbackfactory&task=feedback&id=' . $comment->feedback_id . '#comments');
        }

        $custom_message = str_replace($search, $replace, $message);
        $custom_subject = str_replace($search, $replace, $subject);

        if ($this->feedbackSettings->enable_notification_email_html)
        {
          $custom_message = nl2br($custom_message);
        }

        $mail =& JFactory::getMailer();
        $mail->addRecipient($receiver->email);
        $mail->setSubject(JText::_($custom_subject));
        $mail->setBody(JText::_($custom_message));
        $mail->IsHTML($this->feedbackSettings->enable_notification_email_html);

        $mail->send();
      }
    }
  }

}
