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
<?php
switch ($feedback->type) {
	case 'pending':
		$pagination = $this->pagination_pending;
		break;
	case 'planned':
		$pagination = $this->pagination_planned;
		break;
	case 'started':
		$pagination = $this->pagination_started;
		break;	
	default:
		$pagination = $this->pagination_pending;
		break;
}
?>

<a class="<?php echo $feedback->type;?>" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedback&id=' . $feedback->id . '&Itemid=' . $this->Itemid, false); ?>"></a>
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
			<a class="vote" id="<?php echo $feedback->id;?>">
				<span class="left_img" rel="<?php echo $feedback->id;?>" id="feedback-vote<?php echo $feedback->id;?>"><?php echo JText::_('FEEDBACK_DO_VOTE'); ?></span>
				<span class="right"></span>
			</a>		
		</div>  	
  	</div>
  	
  	<div class="message_body">
  		<h3 class="title"><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedback&id='.$feedback->id, false); ?>"><?php echo $feedback->title; ?></a></h3>
  		<div><span class="message"><?php echo $feedback->feedback_content; ?></span></div>
  		<div class="bottom">
  		<?php echo JText::_('FEEDBACK_BY'); ?><b><?php echo ($feedback->user_id != 0) ? $feedback->username : 'Guest';?></b>&nbsp;
	  	<?php echo JText::_('FEEDBACK_IN_CATEGORY'); ?>&nbsp;
	  		<a class="bottom" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=categoryfeedbacks&category_id='.$feedback->category_id, false); ?>">
	  			<?php echo $feedback->category_title; ?></a>
	  			&nbsp;<?php echo JText::_('FEEDBACK_STATUS'); ?>
	  		<a class="status" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=statusfeedbacks&status_id='.$feedback->status_id, false); ?>">
	  			<?php echo $feedback->status; ?></a>
  				&nbsp;<a class="feedbackfactory-icon feedbackfactory-comments" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedback&id='.$feedback->id, false); ?>"><?php echo $feedback->no_comments; ?> <?php echo JText::_('FEEDBACK_COMMENTS'); ?></a>
  		</div>
  	</div>
  	<div id="right-button-err<?php echo $feedback->id; ?>"></div> 
  </div>
  
<?php endforeach; ?>

<?php if (isset($pagination)): ?>
<div class="pagination">
	<?php echo $pagination->getPagesLinks();
	//echo $this->pagination_pending->getPagesLinks(); ?>
</div>
<?php endif; ?>

<div class="feedback-spacer"></div>

<script>
  var root = "<?php echo JUri::root(); ?>";
</script>
