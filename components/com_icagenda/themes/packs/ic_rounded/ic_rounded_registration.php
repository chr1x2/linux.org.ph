<!--
 * Theme Pack Official
 * @name		ic_rounded
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


		<div>
			<table class="eventtitle">
				<tr>

					<td class="leftbox">
					<?php if ($item->next): ?>
						<div style="padding:10px">
							<img src="media/com_icagenda/images/registration-48.png">
						</div>
					</td>
					<?php endif; ?>

								<td class="tit" valign="middle">
									<div>
										<h3><a href="<?php echo $item->url; ?>" alt="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h3>
									</div>
								</td>
								<td class="cat" valign="middle">
									<div style="color:<?php echo $item->cat_color; ?>;">
										<?php echo $item->cat_title; ?>
									</div>
								</td>
				</tr>
			</table>

			<?php if ($item->placeLeft): ?>
			<div class="reginfos">
				<?php echo JTEXT::_('COM_ICAGENDA_REGISTRATION_PLACES_LEFT');  ?>: <?php echo $item->placeLeft; ?>
			</div>
			<?php endif; ?>

		</div>


		<?php } ?>


	</div>
</div>
