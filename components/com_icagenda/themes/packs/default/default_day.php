<?php
// Theme by default of iCagenda
// @name		default
// @template	day and tip (calendar)
// @author		Lyr!C (JoomliC)
// @license		GNU General Public License version 2 or later; see LICENSE.txt
// @updated		2013-05-07
// @version		1.9

// No direct access to this file
defined('_JEXEC') or die();

?>


<?php // Day with event ?>
<?php if ($stamp->events) {?>

	<?php // Main Background of a day ?>

	<div class="icevent <?php echo $multi_events; ?>" style="background:<?php echo $bg_day; ?> !important; z-index:1000;">

		<?php // Color of date text depending of the category color ?>
		<a><div class="<?php echo $stamp->ifToday; ?> <?php echo $bgcolor; ?>"><?php echo $stamp->Days; ?></div></a>

		<?php // Start of the Tip ?>
		<span class="spanEv">
			<?php foreach($stamp->events as $e){

				// Show image if exist
				if ($e['image']) {
					echo '<span style="background: '.$e['cat_color'].';" class="img"><img src="'.$e['image'].'"/></span>';
				}
				else {
					echo '<span style="background: '.$e['cat_color'].';" class="img"><div class="noimg '.$bgcolor.'">'.$e['no_image'].'</div></span>';
				}

				// Display Title (with link to event) and Other info (city, country, place, short description)
				echo '<span class="text"><div><a href="'.$e['url'].'">&rsaquo; '.$e['title'].'</a></div>';
				if ($e['city']) {
					echo '<div>'.$e['city'];
					if (($e['country']) && ($e['city'])) {
						echo ', '.$e['country'];
					}
					if (($e['country']) AND (!$e['city'])) {
						echo $e['country'];
					}
					echo '</div>';
				}
				if ($e['place']) {
					echo '<div class="infotip">'.$e['place'].'</div>';
				}
				if ($e['descShort']) {
					echo '<div class="infotip"><i>'.$e['descShort'].'</i></div>';
				}
				echo '</span><span class="clr"></span>';
			}
			?>
		</span>

		<?php // Display Date (top of the Tip) ?>
		<span class="date"><span class="datetxt"><?php echo JTEXT::_('JDATE');  ?> : </span>&nbsp;<span class="dateformat"><?php echo $stamp->dateTitle; ?></span></span>

	</div><?php // end of the day ?>


<?php // Day with no event ?>
<?php }else{ ?>
	<div class="no_event">
		<?php echo $stamp->day; ?>
	</div>
<?php } ?>
