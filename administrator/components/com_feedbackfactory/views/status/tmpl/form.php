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

<table class="adminlist" width="70%">
		<tr valign="top">
			<td>
				<fieldset>
					<legend><?php echo JText::_('FEEDBACK_STATUS'); ?></legend>

					<table width="70%">
						<?php if ($this->status->id): ?>
						  <tr>
							  <td class="key" width="15%" align="right"><label for="id"><?php echo JText::_('ID'); ?>:</label></td>
							  <td width="80%"><strong><?php echo $this->status->id; ?></strong></td>
						  </tr>
						<?php endif; ?>

						<!-- title -->
						<tr>
							<td class="key" align="right"><label for="title"><?php echo JText::_('FEEDBACK_TITLE'); ?>:</label></td>
							<td>
							  <input name="status" id="status" value="<?php echo $this->status->status; ?>" style="width: 200px;" />
							</td>
						</tr>

						<!-- default_status -->
						<tr>
							<td class="key" align="right"><label for="default_status"><?php echo JText::_('FEEDBACK_DEFAULT'); ?>:</label></td>
							<td><?php echo $this->status->default_status; ?>
							</td>
						</tr>

						<!-- published -->
						<tr>
							<td class="key" align="right"><label for="published"><?php echo JText::_('FEEDBACK_PUBLISHED'); ?>:</label></td>
							<td>
							  <select name="published" id="published">
							    <option value="0" <?php echo ($this->status->published == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
							    <option value="1" <?php echo ($this->status->published == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
							  </select>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>

  <input type="hidden" name="controller" value="status" />
  <input type="hidden" name="id" value="<?php echo $this->status->id; ?>" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="" />
</form>
