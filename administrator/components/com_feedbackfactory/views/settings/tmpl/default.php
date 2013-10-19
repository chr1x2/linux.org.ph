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
<?php
	JHtml::_("behavior.tooltip");
	JHtml::_('formbehavior.chosen', 'select');
	jimport('joomla.html.html.bootstrap');
?>

<form action="index.php" method="post" name="adminForm" id = "adminForm" style="width: 98%; margin: 0px auto;" enctype="multipart/form-data">

<?php //echo $this->pane->startPane('pane'); ?>
<?php echo JHtml::_('bootstrap.startPane', 'menu-settings', array('active' => 'general')); ?>
	<ul class = "nav nav-tabs" id = "menu-settings">
        <li class = ""><a data-toggle = "tab" href = "#general"><?php echo JText::_('FEEDBACK_GENERAL'); ?></a></li>
        <li class = ""><a data-toggle = "tab" href = "#votes"><?php echo JText::_('Votes'); ?></a></li>
        <li class = ""><a data-toggle = "tab" href = "#comments"><?php echo JText::_('FEEDBACK_COMMENTS'); ?></a></li>
        <li class = ""><a data-toggle = "tab" href = "#cb_integration"><?php echo JText::_('FEEDBACK_CBINTEGRATION'); ?></a></li>
        <li class = ""><a data-toggle = "tab" href = "#recaptcha"><?php echo JText::_('FEEDBACK_RECAPTCHA'); ?></a></li>
        <li class = ""><a data-toggle = "tab" href = "#banned_words"><?php echo JText::_('FEEDBACK_BANNED_WORDS'); ?></a></li>

    </ul>

<!-- General -->
  <?php echo JHtml::_('bootstrap.addPanel', 'menu-settings', 'general');
  //echo $this->pane->startPanel(JText::_('FEEDBACK_GENERAL'), 'general');
	?>
    <div style="width: 100%">
      <fieldset class="adminform">
      	<legend><?php echo JText::_('FEEDBACK_FEEDBACKS'); ?></legend>
      	<?php require_once('_general_feedbacks.php'); ?>
      </fieldset>
    </div>
   <?php echo JHtml::_('bootstrap.endPanel'); ?>

  <!-- Votes -->
  <?php //echo $this->pane->startPanel(JText::_('Votes'), 'votes'); 
	echo JHtml::_('bootstrap.addPanel', 'menu-settings', 'votes');
	?>
    <div style="width: 100%">
      <fieldset class="adminform">
	      <legend><?php echo JText::_('FEEDBACK_GENERAL'); ?></legend>
	      <?php require_once('_votes.php'); ?>
      </fieldset>
    </div>
    <?php echo JHtml::_('bootstrap.endPanel'); ?>

  <!-- Comments -->
  <?php //echo $this->pane->startPanel(JText::_('FEEDBACK_COMMENTS'), 'comments');
		echo JHtml::_('bootstrap.addPanel', 'menu-settings', 'comments');
 	?>
    <div style="width: 100%">
      <fieldset class="adminform">
	      <legend><?php echo JText::_('FEEDBACK_GENERAL'); ?></legend>
	      <?php require_once('_comments.php'); ?>
      </fieldset>
    </div>
    <?php echo JHtml::_('bootstrap.endPanel'); ?>

  <!-- CB Integration -->
  <?php //echo $this->pane->startPanel(JText::_('FEEDBACK_CBINTEGRATION'), 'cb_integration');
		echo JHtml::_('bootstrap.addPanel', 'menu-settings', 'cb_integration');
 ?>
    <div style="width: 100%">
      <fieldset class="adminform">
	      <legend><?php echo JText::_('FEEDBACK_CBINTEGRATION'); ?></legend>
	      <?php require_once('_cb_integration.php'); ?>
      </fieldset>
    </div>
  <?php echo JHtml::_('bootstrap.endPanel'); ?>

  <!-- ReCaptcha -->
  <?php //echo $this->pane->startPanel(JText::_('FEEDBACK_RECAPTCHA'), 'recaptcha');
echo JHtml::_('bootstrap.addPanel', 'menu-settings', 'recaptcha');
?>
    <div style="width: 100%">
      <fieldset class="adminform">
	      <legend><?php echo JText::_('FEEDBACK_GENERAL'); ?></legend>
	      <?php require_once('_recaptcha.php'); ?>
      </fieldset>
    </div>
    <?php echo JHtml::_('bootstrap.endPanel'); ?>

  <!-- Banned words list -->
  <?php //echo $this->pane->startPanel(JText::_('FEEDBACK_BANNED_WORDS'), 'banned_words');
echo JHtml::_('bootstrap.addPanel', 'menu-settings', 'banned_words');
 ?>
    <div style="width: 100%">
      <fieldset class="adminform">
	      <legend><?php echo JText::_('FEEDBACK_BANNED_WORDS'); ?></legend>
	      <?php require_once('_banned_words.php'); ?>
      </fieldset>
    </div>
    <?php echo JHtml::_('bootstrap.endPanel'); ?>

<?php echo JHtml::_('bootstrap.endPane'); ?>

  <input type="hidden" name="controller" value="settings" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="" />
</form>
