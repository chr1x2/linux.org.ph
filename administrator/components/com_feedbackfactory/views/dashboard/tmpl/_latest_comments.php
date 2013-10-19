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

<fieldset>
  <legend><?php echo JText::_('FEEDBACK_LATEST_COMMENTS'); ?></legend>

  <table class="adminlist table">
    <thead>
	    <tr>
		    <th style="width: 150px;"><?php echo JText::_('FEEDBACK_CREATED_AT'); ?></th>
			  <th><?php echo JText::_('FEEDBACK_TEXT'); ?></th>
	    </tr>
	  </thead>

	  <tbody>
	    <?php if (count($this->latest_comments)): ?>
        <?php foreach ($this->latest_comments as $i => $comment): ?>
          <tr>
            <td><?php echo $comment->date_added; ?></td>
            <td><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=comment&task=edit&cid[]=' . $comment->id); ?>"><?php echo $comment->comment; ?></a></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="10"><?php echo JText::_('FEEDBACK_NO_COMMENTS_FOUND'); ?></td>
        </tr>
      <?php endif; ?>
    </tbody>

    <tfoot>
      <tr>
        <td colspan="10" style="padding-top: 10px;"><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=comments'); ?>"><?php echo JText::_('FEEDBACK_ALL_COMMENTS'); ?></td>
      </tr>
    </tfoot>
  </table>
</fieldset>
