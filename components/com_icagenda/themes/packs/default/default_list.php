<!--
 * Theme Pack Official
 * @name		default
 * @template	events list
 * @author		Lyr!C (JoomliC)
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @updated		2013-05-12
 * @version		1.9
-->


<?php
// No direct access to this file
defined('_JEXEC') or die();

// List of events Template ?>
<div>

	<?php // Items ?>
	<div class="items">
	<?php foreach ($stamp->items as $item){ ?>

		<?php // Show event ?>
		<div class="event">
			<table class="table">
				<tr class="table">

					<?php // Left-Box with Date ?>
					<td class="leftbox">

						<?php // Display Date ?>
						<?php if ($item->next): ?>
						<div class="box_date <?php echo $item->fontColor; ?>" style="background:<?php echo $item->cat_color; ?>;">
							<div class="ic-date">

								<?php // Day ?>
								<div class="day"><?php echo $item->day; ?></div>

								<?php // Month ?>
								<div class="month"><?php echo $item->monthShort; ?></div>

								<?php // Year ?>
								<div class="year"><?php echo $item->year; ?></div>

							</div>
						</div>
					</td>
					<?php endif; ?>


					<?php // Right-Box with Infos ?>
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
		</div>

		<?php } ?>


		<?php // AddThis buttons ?>
		<?php if ($this->atlist): ?>
			<div class="share"><?php echo $item->share; ?></div>
		<?php endif; ?>

	</div>
	<?php // Cleaning the DIV ?>
	<div class="clr"></div>
</div>
<?php // Cleaning the DIV ?>
<div class="clr"></div>
