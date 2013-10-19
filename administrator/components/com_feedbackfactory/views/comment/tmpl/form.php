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

<form action="index.php" method="post" name="adminForm" id="adminForm">

<table class="adminlist" width="100%">
	<tr valign="top">
		<td>
			<fieldset>
				<legend><?php echo JText::_('FEEDBACK_COMMENT'); ?></legend>

				<table width="100%">
					<tr>
					  <td class="key" width="20%" align="right"><label for="id"><?php echo JText::_('ID'); ?>:</label></td>
					  <td width="80%"><strong><?php echo $this->comment->id; ?></strong></td>
					</tr>
					<!-- author_name -->
					<tr>
						<td class="key" align="right"><label for="published"><?php echo JText::_('FEEDBACK_AUTHOR_NAME'); ?>:</label></td>
						<td>
						  <input type="text" name="author_name" id="author_name" value="<?php echo $this->comment->author_name; ?>" style="width: 200px;" />
						</td>
					</tr>
					<!-- author_email -->
					<tr>
						<td class="key" align="right"><label for="approved"><?php echo JText::_('FEEDBACK_AUTHOR_EMAIL'); ?>:</label></td>
						<td>
							<input type="text" name="author_email" id="author_email" value="<?php echo $this->comment->author_email; ?>" style="width: 200px;" />
						</td>
					</tr>
					<!-- content -->
					<tr>
						<td class="key" align="right" style="vertical-align: top;"><label for="content"><?php echo JText::_('FEEDBACK_COMMENT'); ?>:</label></td>
						<td>
						  <textarea name="content" id="content" rows="5" cols="40"><?php echo $this->comment->comment; ?></textarea>
						</td>
					</tr>

				</table>
			</fieldset>
		</td>
	</tr>
</table>

  <input type="hidden" name="controller" value="comment" />
  <input type="hidden" name="id" value="<?php echo $this->comment->id; ?>" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="" />
</form>
