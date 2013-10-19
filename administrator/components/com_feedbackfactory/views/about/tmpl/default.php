<?php 
/*------------------------------------------------------------------------
com_wallfactory - Wall Factory 3.0.0
------------------------------------------------------------------------
author    TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support:  Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

$document=JFactory::getDocument();
$js='(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, \'script\', \'facebook - jssdk\'));';
$document->addScriptDeclaration($js);
?>

<table class="adminlist" style="border: none;">
    <tr style="background-color: #FFFFFF; border: none;">
        <td style="padding-left: 20px; background-color: #FFFFFF; border: none;">

            <h2><a href="#" style="text-decoration: none;">Latest Release Notes</a></h2>

            <div>
                <?php if ($this->isnew_version): ?>
                <div>
                    <h2><span style="color:red"><?php echo JText::_("FACTORY_NEW_VERSION_AVAILABLE"); ?></span></h2>
                </div>
                <?php endif; ?>
                <div style="float: left; width: 260px;">
                    Your installed version <strong><?php echo COMPONENT_VERSION; ?></strong><br/>
                    Latest version available <strong><?php echo $this->latestversion; ?></strong><br/><br/>
                    <?php echo $this->versionhistory; ?>
                </div>
                <div style="float: left">
                    <div class="fb-like" data-href="https://www.facebook.com/theFactoryJoomla" data-send="false"
                         data-layout="box_count" data-width="450" data-show-faces="false"></div>
                </div>
                <div style="clear: both; line-height: 1px;">&nbsp;</div>

            </div>

            <h2><a href="#" style="text-decoration: none;">Support and Updates</a></h2>
            <?php if ($this->downloadlink): ?>
            <div>
                <?php echo $this->downloadlink; ?>
            </div>
            <?php endif; ?>

            <h2><a href="#" style="text-decoration: none;">Other Products</a></h2>
            <?php if ($this->otherproducts): ?>
            <div>
                <?php echo $this->otherproducts; ?>
            </div>
            <?php endif; ?>

            <h2><a href="#" style="text-decoration: none;">About theFactory</a></h2>
            <?php if ($this->aboutfactory): ?>
            <div>
                <?php echo $this->aboutfactory; ?>
            </div>
            <?php endif; ?>
        </td>
    </tr>
</table>

<form action="index.php" method="post" name="adminForm" id="adminForm">
    <input type="hidden" name="option" value="com_feedbackfactory"/>
    <input type="hidden" name="task" value="about"/>
</form>



<!--
<?php /*foreach ($this->information as $name => $text): */?>
  <?php /*if (!empty($text)): */?>
    <div style="padding: 10px;">
      <h1 style="text-decoration: underline; "><?php /*echo JText::_($name); */?></h1>
      <?php /*if ($name == 'latestversion'): */?>
        <?php /*require_once('_version.php'); */?>
      <?php /*else: */?>
        <?php /*echo $text; */?>
      <?php /*endif; */?>
    </div>
  <?php //endif; ?>
--><?php //endforeach; ?>