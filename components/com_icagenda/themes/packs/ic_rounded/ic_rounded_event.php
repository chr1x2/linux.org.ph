<!--
 * Theme Pack Official
 * @name		ic_rounded
 * @template	event details
 * @author		Lyr!C (JoomliC)
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @updated     3.1.9 2013-09-04
 * @version		2.0
-->


<?php
// No direct access to this file
defined('_JEXEC') or die();

// Event Details Template ?>
<div>

	<?php // Back button ?>
	<span class="back">
		<a href="javascript:history.go(-1)" title="<?php echo JTEXT::_('COM_ICAGENDA_BACK'); ?>">
			&#9668; <?php echo JTEXT::_('COM_ICAGENDA_BACK'); ?>
		</a>
	</span>
	<div class="titre">
		<table class="table">
			<tbody>
				<tr>
					<td class="tit" valign="middle">
						<div>
							<h1><?php echo $item->title; ?></h1>
						</div>
					</td>
					<td class="cat" valign="middle">
						<div style="color:<?php echo $item->cat_color; ?>;">
							<?php echo $item->cat_title; ?>&nbsp;
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="clear:both"></div>

	<div>&nbsp;</div>
	<table>
		<tr>
			<td style="float:left">
				<?php echo $item->share_event; ?>
			</td>
			<td>
				<?php echo $item->reg; ?>
			</td>
		</tr>
	</table>

	<div class="clr"></div>

	<div class="icinfo">

		<div class="image">
			<?php if ($item->imageTag): ?>
			<div>
				<?php echo $item->imageTag; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="details">
			<b><?php echo $item->dateText; ?>:</b>&nbsp;<?php echo $item->nextDate; ?>

			<br/>

			<?php if ($item->place_name): ?>
				<b><?php echo JTEXT::_('COM_ICAGENDA_EVENT_PLACE'); ?>:</b>
				<?php echo $item->place_name;?>
			<?php endif; ?>

			<?php if (($item->place_name) AND ($item->address) AND ($item->city)): ?>&nbsp;|&nbsp;&nbsp;<b><?php echo JTEXT::_('COM_ICAGENDA_EVENT_CITY'); ?>:</b>
				<?php echo $item->city;?><?php if ($item->country): ?>, <?php echo $item->country;?><?php endif; ?><br/>
			<?php endif; ?>

			<?php if ((!$item->place_name) AND ($item->city)): ?>
				<b><?php echo JTEXT::_('COM_ICAGENDA_EVENT_CITY'); ?>:</b>
				<?php echo $item->city;?><?php if ($item->country): ?>, <?php echo $item->country;?><?php endif; ?><br/>
			<?php endif; ?>

		</div>

		<?php if ($item->periodDisplay): ?>
		<!--div>
			<?php echo $item->periodDates; ?>
		</div-->
		<?php endif; ?>

		<div style="clear:both"></div>

		<?php if ($item->desc): ?>
		<div id="detail-desc">
			<?php echo $item->description; ?>
			<?php endif; ?>
			<?php if (!$item->desc): ?>
		<div>
		<?php endif; ?>
		<br/>
		<?php if ($item->infoDetails): ?>
		<div class="information">
			<table cellspacing="0">
				<tbody>
					<tr>
						<td class="infoleft">
							<label><?php echo JTEXT::_('COM_ICAGENDA_EVENT_INFOS'); ?></label>
						</td>
						<td class="infomiddle">
							<table style="width: auto;">
								<tbody>

				        		<?php if ($item->placeLeft): ?>
									<tr>
										<th>
											<?php echo JTEXT::_('COM_ICAGENDA_REGISTRATION_PLACES_LEFT'); ?>
										</th>
										<td>
											<?php echo $item->placeLeft; ?><?php if ($item->maxNbTickets): ?> / <small><?php echo $item->maxReg; ?><?php endif; ?></small>
										</td>
									</tr>
			       				<?php endif; ?>

								<?php if ($item->phone): ?>
									<tr>
										<th>
											<?php echo JTEXT::_('COM_ICAGENDA_EVENT_PHONE'); ?>
										</th>
										<td>
											<?php echo $item->phone; ?>
										</td>
									</tr>
			        			<?php endif; ?>

			        			<?php if ($item->email): ?>
									<tr>
										<th>
											<?php echo JTEXT::_('COM_ICAGENDA_EVENT_MAIL'); ?>
										</th>
										<td>
											<?php echo $item->emailLink; ?>
										</td>
									</tr>
			        			<?php endif; ?>

			        			<?php if ($item->website): ?>
									<tr>
										<th>
											<?php echo JTEXT::_('COM_ICAGENDA_EVENT_WEBSITE'); ?>
										</th>
										<td>
											<?php echo $item->websiteLink; ?>
										</td>
									</tr>
			        			<?php endif; ?>

			        			<?php if ($item->address): ?>
									<tr>
										<th>
											<?php echo JTEXT::_('COM_ICAGENDA_EVENT_ADDRESS'); ?>
										</th>
										<td>
											<?php echo $item->address; ?>
										</td>
									</tr>
			        			<?php endif; ?>

								</tbody>
							</table>
						</td>

						<td class="inforight">
							<?php if($item->file){ echo '<label><i>'.JTEXT::_('COM_ICAGENDA_EVENT_FILE').'</i></label><br/><b>'.$item->fileTag;} ?></b>
						</td>
					</tr>
				</tbody>
			</table>
			</div>
			<?php endif; ?>
		</div>
		<div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>
	<div>&nbsp;</div>

	<?php if ($item->coordinate): ?>
	<div id="detail-map">
		<h3><?php echo JTEXT::_('COM_ICAGENDA_EVENT_MAP'); ?></h3><br/>
		<div id="icagenda_map">
			<?php echo $item->map; ?>
		</div>
	</div>
	<?php endif; ?>

	<div style="clear:both"></div>
	<div>&nbsp;</div>

	<?php if ($item->datelistUl OR $item->periodDates): ?>
	<div id="detail-date-list">
		<h3 class="alldates"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_DATES'); ?></h3>
		<div class="datesList">
			<?php echo $item->periodDates; ?>
			<?php echo $item->datelistUl; ?>
		</div>
	</div>
	<?php endif; ?>

	<div style="clear:both"></div>
	<div>&nbsp;</div>

	<?php if ($item->participantList == 1) : ?>
	<div>
		<h3><?php echo $item->participantListTitle; ?></h3>
		<?php echo $item->registeredUsers; ?>
	</div>

	<div style="clear:both"></div>
	<?php endif; ?>

</div>

<div style="clear:both"></div>
