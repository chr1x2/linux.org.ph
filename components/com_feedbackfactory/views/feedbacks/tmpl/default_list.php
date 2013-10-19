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

<?php foreach ($this->feedbacks as $feedback): ?>
  <a class="feedback" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedback&id=' . $feedback->id . '&Itemid=' . $this->Itemid); ?>"></a>
  <!--list of feedbacks -->
  <div class="votes">
  	<div class="left_img">
		<div class="right-button">
			<a class="count">
				<span class="left_img"></span>
				<span class="tt" id="feedback-vote-value<?php echo $feedback->id; ?>"><?php echo $feedback->hits; ?></span>
				<span class="right"></span>
				<br />
				<span class="t"><?php echo JText::_('FEEDBACK_VOTES'); ?></span>
			</a>
			<?php if ($feedback->status_id != $this->completed_id_status)	: ?>
				<a class="vote" id="<?php echo $feedback->id;?>">
					<span class="left_img" rel="<?php echo $feedback->id;?>" id="feedback-vote<?php echo $feedback->id;?>"><?php echo JText::_('FEEDBACK_DO_VOTE'); ?></span>
					<span class="right"></span>
				</a>	
			<?php endif; ?>		
		</div>
  	</div>
  	<div class="message_body">
  		<h3 class="title"><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedback&id='.$feedback->id); ?>"><?php echo $feedback->title; ?></a></h3>
        <div><span class="message"><?php echo $feedback->feedback_content; ?></span></div>
  		<div class="bottom">
  			<?php echo JText::_('FEEDBACK_BY'); ?><b><?php echo ($feedback->user_id != 0) ? $feedback->username : 'Guest';?></b>&nbsp;
	  		<?php echo JText::_('FEEDBACK_IN_CATEGORY'); ?>&nbsp;
	  		<a class="feedbackfactory-icon feedbackfactory-folder_page" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=categoryfeedbacks&category_id='.$feedback->category_id); ?>">
	  			<?php echo $feedback->category_title; ?></a>
	  			&nbsp;<?php echo JText::_('FEEDBACK_STATUS'); ?>
	  		<a class="status feedbackfactory-icon feedbackfactory-status" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=statusfeedbacks&status_id='.$feedback->status_id); ?>">
	  			<?php echo $feedback->status; ?></a>
  			&nbsp;<a class="feedbackfactory-icon feedbackfactory-comments" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedback&id='.$feedback->id); ?>"><?php echo $feedback->no_comments; ?> <?php echo JText::_('FEEDBACK_COMMENTS'); ?></a>
  		</div>
  	</div>

  	<div id="right-button-err<?php echo $feedback->id; ?>"></div>  	
  </div>
  
<?php endforeach; ?>

<div class="pagination">
	<p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<div class="feedback-spacer"></div>
<script>
   var root = "<?php echo JUri::root(); ?>";
</script>
