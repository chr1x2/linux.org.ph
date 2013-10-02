<?php
/** 
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012-2013 JOOMLIC - All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 * 
 * @since		2.0.4
 *----------------------------------------------------------------------------
*/

<?php
 
defined('JPATH_BASE') or die;
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
class JFormFieldEventTitle extends JFormFieldList
{
        /**
         * The form field type.
         *
         * @var         string
         * @since       1.6
         */
        protected $type = 'Eventname';
 
        /**
         * Method to get the field options.
         *
         * @return      array   The field option objects.
         * @since       1.6
         */
        public function getOptions()
        {
                // Initialize variables.
                $options = array();
 
                $db     = JFactory::getDbo();
                $query  = $db->getQuery(true);
 
                $query->select('id As value, title As text');
                $query->from('#__icagenda_events AS a');
                $query->order('a.title');
                $query->where('state = 1');
 
                // Get the options.
                $db->setQuery($query);
 
                $options = $db->loadObjectList();
 
                // Check for a database error.
                if ($db->getErrorNum()) {
                        JError::raiseWarning(500, $db->getErrorMsg());
                }
 
                return $options;
        }
}