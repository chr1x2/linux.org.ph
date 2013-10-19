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

defined('_JEXEC') or die('Restricted access'); ?>

<?php if (!$this->feedback): ?>

  <h1><?php echo JText::_('ERROR_TITLE'); ?></h1>
  <p><?php echo JText::_('FEEDBACK_NOT_FOUND'); ?></p>
  <br />
  <p><?php echo JText::_('FEEDBACK_RETURN'); ?> <a href="javascript: history.back();"><?php echo JText::_('FEEDBACK_PREVIOUS_PAGE'); ?></a>, 
  <?php echo JText::_('FEEDBACK_FIND_MORE_FEEDBACK'); ?> <a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedbacks&Itemid=' . $this->Itemid); ?>"><?php echo JText::_('FEEDBACK_HERE'); ?></a>.</p>

<?php else: ?>

  <div id="loading-bar" style="display: none;"><?php echo JText::_('FEEDBACK_LOADING'); ?></div>

  <table style="width: 100%; color: #6E6E6E;">
    <tr>
      <td style="width: 50px; vertical-align: top; padding: 10px 10px; text-align: center;">
        <?php echo feedbackHelper::feedbackDate($this->feedback->date_created); ?>
      </td>
      <td>
        <!-- Feedback -->
        <h1><?php echo $this->feedback->title; ?></h1>

        <div style="float: right">
        <?php if ($this->isCBIntegration && $this->feedbackSettings->use_cb_avatars && $this->feedback->enable_cb_avatar): ?>
            <?php $author_avatar_image = FeedbackHelper::getAvatar($this->feedback->user_id, 'cb');
              echo $author_avatar_image; ?>
        <?php endif; ?>
        </div>
        <?php echo JText::_('FEEDBACK_BY'); ?> <?php echo $this->feedback->username; ?><br /><br />
        <?php echo $this->feedback->feedback_content; ?>

        <?php if ($this->feedback->date_created != $this->feedback->date_updated): ?>
          <i>(<?php echo JText::_('FEEDBACK_LAST_EDITED_AT'); ?>: <?php echo $this->feedback->date_updated; ?>)</i>
        <?php endif; ?>

        <!-- Category -->
          <br /><br />
          <?php echo JText::_('FEEDBACK_FILED_UNDER_CATEGORY'); ?>
          <a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=categoryfeedbacks&category_id='.$this->feedback->category_id); ?>" 
class="feedbackfactory-icon feedbackfactory-folder_page"><?php echo $this->feedback->category_title; ?></a>
		<span class="feedbackfactory-icon feedbackfactory-bullet"></span> 
		<?php echo JText::_('FEEDBACK_STATUS'); ?>
 		<a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=statusfeedbacks&status_id='.$this->feedback->status_id); ?>" 
class="feedbackfactory-icon feedbackfactory-status"><?php echo $this->feedback->status; ?></a>
        <br /><br />
        <?php echo JText::_('FEEDBACK_VOTES'); ?>: <?php echo ($this->feedback->hits); ?>

        <!-- Comments -->
        <a name="comments"></a>
        <fieldset id="fieldset-comments">
          <legend style="text-transform: capitalize;"><?php echo JText::_('FEEDBACK_COMMENTS'); ?></legend>

          <?php if (!$this->feedback->enable_comments): ?>
            <div><?php echo JText::_('FEEDBACK_COMMENTS_DISABLED'); ?></div>
          <?php else: ?>
            <div id="feedbackfactory-comments"><span class='feedbackfactory-icon feedbackfactory-loader'><?php echo JText::_('FEEDBACK_LOADING_COMMENTS'); ?></span></div>
          <?php endif; ?>
        </fieldset>

        <!-- Write a comment -->
        <?php if ($this->feedback->enable_comments): ?>
        <fieldset>
          <legend><?php echo JText::_('FEEDBACK_WRITE_COMMENT'); ?></legend>
          <div id="write-comment">
          <?php if ($this->user->guest && !$this->feedbackSettings->allow_guest_comments): ?>
            <?php echo JText::_('FEEDBACK_LOGIN_TO_WRITE_COMMENT'); ?>
          <?php else: ?>
              <!--<div style="float: right">
                    <?php //if ($this->isCBIntegration && $this->feedbackSettings->use_cb_avatars && $this->feedback->enable_cb_avatar): ?>
                        <?php //echo $this->avatar_image; ?>
                    <?php //endif; ?>
              </div>-->
            <table>
              <tbody>
                <tr><td id="author_name_error" colspan="2" style="color: #ff0000; display: none;">&darr;&nbsp;<?php echo JText::_('FEEDBACK_FIELD_REQUIRED'); ?>&nbsp;&darr;</td></tr>
                <tr>
                  <td><label for="author_name"><?php echo JText::_('FEEDBACK_NAME'); ?>:</label></td>
                  <td><input type="text" name="author_name" id="author_name" size="45" value="<?php echo (!$this->user->guest) ? $this->user->name : ''; ?>" /></td>
                </tr>

                <tr><td id="author_email_error" colspan="2" style="color: #ff0000; display: none;">&darr;&nbsp;<?php echo JText::_('FEEDBACK_VALID_EMAIL_REQUIRED'); ?>&nbsp;&darr;</td></tr>
                <tr>
                  <td><label for="author_email"><?php echo JText::_('FEEDBACK_EMAIL'); ?>:</label></td>
                  <td><input type="text" name="author_email" id="author_email" size="45" value="<?php echo (!$this->user->guest) ? $this->user->email : ''; ?>" /></td>
                </tr>

                <tr><td id="comment_error" colspan="2" style="color: #ff0000; display: none;">&darr;&nbsp;<?php echo JText::_('FEEDBACK_FIELD_REQUIRED'); ?>&nbsp;&darr;</td></tr>

                <tr>
                  <td style="vertical-align: top;"><label for="comment"><?php echo JText::_('FEEDBACK_YOUR_COMMENT'); ?>:</label></td>
                  <td><textarea id="comment" class="feedbackfactory-comment-content" rows="10" cols="40"></textarea></td>
                </tr>

                <?php if ($this->feedbackSettings->captcha_comment || ($this->feedbackSettings->guest_captcha_comment && $this->user->guest)): ?>
                  <tr><td id="recaptcha_response_field_error" colspan="2" style="color: #ff0000; display: none;">&darr;&nbsp;<span></span>&nbsp;&darr;</td></tr>
                  <tr>
                    <td style="vertical-align: top;"><label for="recaptcha_response_field"><?php echo JText::_('FEEDBACK_ARE_YOU_HUMAN'); ?></label></td>
                    <td><?php echo $this->captcha_html; ?></td>
                  </tr>
                <?php endif; ?>

                <tr>
                  <td colspan="2">
                    <input type="button" id="submit_comment" value="<?php echo JText::_('FEEDBACK_SUBMIT_COMMENT'); ?>" />
                    <span style="display: none;" id="comment-loader" class="feedbackfactory-icon feedbackfactory-loader"><?php echo JText::_('FEEDBACK_PROCESSING_FORM'); ?></span>
                  </td>
                </tr>
              </tbody>
            </table>
          <?php endif; ?>
          </div>
        </fieldset>
        <?php endif; ?>
      </td>
    </tr>
  </table>
<?php endif; ?>
