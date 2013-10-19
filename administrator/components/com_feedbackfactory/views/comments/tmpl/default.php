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

<form action="index.php" method="post" name="adminForm" id="adminForm" style="width: 98%; margin: 0px auto;">

	<table>
		<tr>
			<!-- Search filter -->
		  <td align="left" width="100%">
				<label for="search"><?php echo JText::_('FEEDBACK_FILTER'); ?>:</label>
				<input type="text" id="search" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_('FEEDBACK_GO'); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.getElementById('approved').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
			</td>
		</tr>
	</table>

<table class="adminlist table-striped" width="100%">
	<thead>
		<tr>
			<th width="20px"><?php echo JText::_('NUM'); ?></th>
			<th width="20px">
                <input type="checkbox" name="toggle" value="" class="checklist-toggle" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
			<th class="title left"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_COMMENT'), 'c.comment', $this->lists['order_Dir'], $this->lists['order'], 'comments'); ?></th>
			<th class="title left" width="20%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_TITLE'), 'f.title', $this->lists['order_Dir'], $this->lists['order'], 'comments'); ?></th>
			<th class="title left" width="19%"><?php echo JText::_('FEEDBACK_AUTHOR_INFO'); ?></th>
			<th width="11%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_CREATED_AT'), 'c.date_added', $this->lists['order_Dir'], $this->lists['order'], 'comments'); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="6">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>

	<tbody>
	  <?php foreach ($this->comments as $i => $comment): ?>
	    <tr class="row<?php echo $i % 2; ?>">
	      <td width="20px"><?php echo ($i + 1 + $this->pagination->limitstart); ?></td>
	      <td width="20px"><?php echo JHTML::_('grid.id', $i, $comment->id); ?></td>
	      <td><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=comment&task=edit&cid[]=' . $comment->id); ?>">
	      		<?php echo feedbackHelper::trimText($comment->comment,150); ?></a>
	      </td>
	      <td><?php echo $comment->feedback_title; ?></td>
	      <td>
	        <b><?php echo JText::_('FEEDBACK_USERNAME'); ?>:</b> <?php echo $comment->username; ?>
	        <br />
	        <b><?php echo JText::_('FEEDBACK_NAME'); ?>:</b> <?php echo $comment->author_name; ?>
	        <br />
	        <b><?php echo JText::_('FEEDBACK_EMAIL'); ?>:</b> <?php echo $comment->author_email; ?>
	      </td>
	      <td style="text-align: center;"><?php echo $comment->date_added; ?></td>
	    </tr>
	  <?php endforeach; ?>
	</tbody>
</table>

  <input type="hidden" name="controller" value="comment" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="comments" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
