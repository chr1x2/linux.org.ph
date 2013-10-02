<!--
 * Theme Pack Official
 * @name		default
 * @template	registration
 * @author		Lyr!C (JoomliC)
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @updated		2013-05-12
 * @version		1.9
-->


<?php
// No direct access to this file
defined('_JEXEC') or die();

// First Part of Registration page ?>
<div>

	<div class="items">
	<?php foreach ($stamp->items as $item){ ?>


		<?php // Show event ?>
		<div class="event">
			<table class="table">
				<tr class="table">

					<?php // Show icon (left-box) ?>
					<td class="leftbox">
					<?php if ($item->next): ?>
						<div class="box_date">
							<img src="media/com_icagenda/images/registration-48.png">
						</div>
					</td>
					<?php endif; ?>

					<?php // Show Event Details (right-box) ?>
					<td class="content">
						<div>

							<?php // Category ?>
							<span class="cat"><?php echo $item->cat_title; ?> </span>

							<?php // Event Title with link to event ?>
							<h2>
								<a href="<?php echo $item->url; ?>" alt="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
							</h2>


							<?php // Short Description ?>
							<?php if ($item->desc): ?>
							<span class="descshort"><?php echo $item->descShort ; ?></span>
							<?php endif; ?>

						</div>
						<?php // Cleaning the DIV ?>
						<div class="clr"></div>
					</td>
				</tr>
			</table>

			<?php // Add Registration infos (places left) ?>
			<div class="reginfos">
				<?php if ($item->placeLeft): ?><?php echo JTEXT::_('COM_ICAGENDA_REGISTRATION_PLACES_LEFT');  ?>: <?php echo $item->placeLeft; ?><?php endif; ?>
			</div>


		</div>


		<?php } ?>


	</div>
</div>
