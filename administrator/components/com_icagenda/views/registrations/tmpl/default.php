<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2013 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.1.9 2013-09-04
 * @since		2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::_('behavior.modal');
JHtml::_('behavior.multiselect');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_icagenda');
$saveOrder	= $listOrder == 'a.ordering';

if(version_compare(JVERSION, '3.0', 'lt')) {

	JHtml::_('behavior.tooltip');
	//JHtml::_('script','system/multiselect.js',false,true);

} else {

	// Include the component HTML helpers.
	JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
	JHtml::_('bootstrap.tooltip');
	JHtml::_('formbehavior.chosen', 'select');
	JHtml::_('dropdown.init');

	if ($saveOrder)
	{
	    $saveOrderingUrl = 'index.php?option=com_icagenda&task=registrations.saveOrderAjax&tmpl=component';
	    JHtml::_('sortablelist.sortable', 'registrationsList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
	}


}

?>

<form action="<?php echo JRoute::_('index.php?option=com_icagenda&view=registrations'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>

	<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
		<fieldset id="filter-bar">
			<div class="filter-search fltlft">
				<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
				<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
				<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
				<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
			<div class="filter-select fltrt">
				<select name="filter_published" class="inputbox" onchange="this.form.submit()">
					<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true);?>
				</select>
			</div>
		</fieldset>
		<div class="clr"> </div>

	<?php else : ?>

		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER'); ?></label>
				<input type="text" name="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
			</div>
			<div class="btn-group pull-left hidden-phone">
				<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		</div>
		<div class="clearfix"> </div>

	<?php endif;?>


	<?php if(version_compare(JVERSION, '3.0', 'lt')) : ?>
		<table class="adminlist">
	<?php else : ?>
		<table class="table table-striped" id="registrationsList">
	<?php endif; ?>

			<thead>
				<tr>
<!-- Ordering HEADER Joomla 3.x -->
					<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
 					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
					</th>
					<?php endif; ?>

<!-- CheckBox HEADER -->
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>

<!-- Status HEADER -->
					<th width="1%" style="min-width:55px" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
					</th>

<!-- User HEADER -->
					<th>
						<?php echo JText::_('COM_ICAGENDA_REGISTRATION_INFORMATION'); ?><span class="hidden-phone">:</span><span class="visible-phone"></span>
						<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_USER_ID', 'userid', $listDirn, $listOrder); ?>&nbsp;|
						<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_USERID', 'name', $listDirn, $listOrder); ?>&nbsp;|
						<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_EMAIL', 'email', $listDirn, $listOrder); ?>&nbsp;|
						<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_PHONE', 'phone', $listDirn, $listOrder); ?>&nbsp;|
						<?php //echo JText::_('COM_ICAGENDA_REGISTRATION_LABEL'); ?><!--span class="hidden-phone">:</span><span class="visible-phone"></span-->
						<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_NUMBER_PLACES', 'a.people', $listDirn, $listOrder); ?>&nbsp;-
						<?php echo JHtml::_('grid.sort',  'COM_ICAGENDA_REGISTRATION_EVENTID', 'event', $listDirn, $listOrder); ?>&nbsp;|
						<?php echo JHtml::_('grid.sort',  'ICDATE', 'a.date', $listDirn, $listOrder); ?>&nbsp;|
						<?php echo JHtml::_('grid.sort',  'JGLOBAL_FIELD_CREATED_BY_LABEL', 'created_by', $listDirn, $listOrder); ?>
					</th>




<!-- ID HEADER -->
					<th width="1%" class="nowrap hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
					</th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="11">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody valign="top">
		<?php foreach ($this->items as $i => $item) :
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_icagenda');
			$canEdit	= $user->authorise('core.edit',			'com_icagenda');
			$canCheckin	= $user->authorise('core.manage',		'com_icagenda');
			$canChange	= $user->authorise('core.edit.state',	'com_icagenda');
			// $canEditOwn	= $user->authorise('core.edit.own',		'com_icagenda') && $item->created_by == $userId;

			// Get avatar of the registered user
			$avatar=md5( strtolower( trim( $item->email ) ) );

			// Get Username and name
			if ($item->userid) {
				$db = JFactory::getDBO();
				$db->setQuery(
					'SELECT `name`, `username`' .
					' FROM `#__users`' .
					' WHERE `id` = '. (int) $item->userid
				);
				$data_name=$db->loadObject()->name;
				$data_username=$db->loadObject()->username;
				$item->name = $data_username;
			} else {
				$data_username = $item->name;
				$data_name = false;
			}
			?>
			<tr class="row<?php echo $i % 2; ?>">

<!-- Ordering Joomla 3.x -->
	<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
					<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName = '';
						$disabledLabel	  = '';

						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
					</td>
	<?php endif; ?>


 <!-- CheckBox Joomla -->
					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>

<!-- Status -->
                <?php if (isset($this->items[0]->state)) { ?>
				    <td class="center hidden-phone">
					    <?php echo JHtml::_('jgrid.published', $item->state, $i, 'registrations.', $canChange, 'cb'); ?>
				    </td>
                <?php } ?>


<!-- User Information -->
					<td class="nowrap has-context">
						<div class="pull-left hidden-phone" style="margin-right:10px;">
							<img alt="<?php echo $item->name; ?>"  src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=36&d=mm"/>
						</div>
						<div class="pull-left" style="width:45%">
							<?php if ($item->checked_out) : ?>
								<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'events.', $canCheckin); ?>
							<?php endif; ?>
							<?php //if ($item->language == '*'):?>
								<?php //$language = JText::alt('JALL', 'language'); ?>
							<?php //else:?>
								<?php //$language = $item->language ? $this->escape($item->language) : JText::_('JUNDEFINED'); ?>
							<?php //endif;?>
							<?php //if ($canEdit || $canEditOwn) : ?>
								<!--a href="<?php //echo JRoute::_('index.php?option=com_icagenda&task=registration.edit&id=' . $item->id); ?>" title="<?php //echo JText::_('JACTION_EDIT'); ?>"-->


							<?php if ($data_username) : ?>
									<?php echo '<b>'.$this->escape($item->name).'</b>'; if ($data_name) echo ' <small>['.$this->escape($data_name).']</small>'; ?>
							<?php endif; ?>

									<!--/a-->
							<?php //else : ?>
								<!--span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"--><?php //echo $this->escape($item->name); ?><!--/span-->
							<?php //endif; ?>
							<?php if ($item->userid != '0') : ?>
							<p class="smallsub">
								<?php echo JText::_('COM_ICAGENDA_REGISTRATION_USER_ID') . ": " . $this->escape($item->userid); ?>
							</p>
							<?php else:?>
							<p class="smallsub">
								<?php echo JText::_('COM_ICAGENDA_REGISTRATION_USER_ID') . ": " . JText::_('COM_ICAGENDA_REGISTRATION_NO_USER_ID'); ?>
							</p>
							<?php endif; ?>
							<?php if (($item->email) OR ($item->phone)) : ?>
							<!--div class="small" style="height:5px; border-bottom: solid 1px #D4D4D4">
							</div-->
							<p>
							<?php if ($item->email) : ?>
							<div class="small iC-italic-grey">
								<?php echo JText::_('COM_ICAGENDA_REGISTRATION_EMAIL') . ": <b>" . $this->escape($item->email) . "</b>"; ?>
							</div>
							<?php endif; ?>
							<?php if ($item->phone) : ?>
							<div class="small iC-italic-grey">
								<?php echo JText::_('COM_ICAGENDA_REGISTRATION_PHONE') . ": <b>" . $this->escape($item->phone) . "</b>"; ?>
							</div>
							<?php endif; ?>
							<?php if ($item->notes) :
							?>
							<br />
							<a href="#loadDiv<?php echo $item->id; ?>" class="modal" rel="{size: {x: 600, y: 350}}">
								<input type="submit" class="btn" value="<?php echo JText::_( 'COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL' ); ?>" />
							</a>
							<div style="display:none;">
								<div id="loadDiv<?php echo $item->id; ?>">
									<?php echo "<h3>".JText::_('COM_ICAGENDA_REGISTRATION_NOTES_DISPLAY_LABEL') . ": </h3><hr>" . nl2br(html_entity_decode($item->notes)); ?>
								</div>
							</div>
							<?php endif; ?>
							</p>
							<?php endif; ?>
						</div>
						<div class="pull-right visible-phone" style="margin-right:10px;">
							<img alt="<?php echo $item->name; ?>"  src="http://www.gravatar.com/avatar/<?php echo $avatar; ?>?s=36&d=mm"/>
						</div>
						<div class="pull-left">
							<div class="small">
								<?php echo JText::_('ICEVENT'); ?>
							</div>
							<div class="small iC-italic-grey">
								<?php echo JText::_('ICTITLE') . ": <b>" . $this->escape($item->event) . "</b>"; ?>
							</div>
							<div class="small iC-italic-grey">
								<?php
								if ($item->period == 1) {
									echo JText::_('ICDATES') . ": <b>" . JText::_( 'COM_ICAGENDA_REGISTRATION_ALL_PERIOD' ) . "</b>";
								} else {
									echo JText::_('ICDATE') . ": <b>" . $item->date . "</b>";
								} ?>
							</div>
							<?php if ($item->created_by) :
								// Get Author Name
								$db = JFactory::getDBO();
								$db->setQuery(
									'SELECT `name`' .
									' FROM `#__users`' .
									' WHERE `id` = '. (int) $item->created_by
								);
								$authorname=$db->loadObject()->name;
 							?>
							<div class="small iC-italic-grey">
								<?php echo JText::_('JGLOBAL_FIELD_CREATED_BY_LABEL') . ": <b>" . $this->escape($authorname) . "</b>"; ?>
							</div>
							<?php endif; ?>
							<p>
							<div class="small">
								<?php echo JText::_('ICINFORMATION'); ?>
							</div>
							<div class="small iC-italic-grey">
								<?php echo JText::_('COM_ICAGENDA_REGISTRATION_NUMBER_PLACES') . ": <b>" . $item->people . "</b>"; ?>
							</div>
							</p>
						</div>
					</td>




<!-- ID -->
                	<?php if (isset($this->items[0]->id)) { ?>
					<td class="center hidden-phone">
						<?php echo (int) $item->id; ?>
					</td>
                	<?php } ?>

			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

		<div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>
