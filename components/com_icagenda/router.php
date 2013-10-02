<?php
/** 
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012 JOOMLIC - All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 * 
 * @update		2013-03-31
 * @version		2.1.3
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.categories');

function iCagendaBuildRoute( &$query )
{
       $segments = array();

       // link event
       if(isset($query['layout']) && $query['layout']=='event')
       {
 				// Make sure we have the id and the alias
				if (strpos($query['id'], ':') === false) {
					$db = JFactory::getDbo();
					$aquery = $db->setQuery($db->getQuery(true)
						->select('alias')
						->from('#__icagenda_events')
						->where('id='.(int)$query['id'])
					);
					$alias = $db->loadResult();
					
					$query['id'] = $query['id'].':'.$alias;
					//$query['id'] = $alias;
				}
			
                   $segments[] = $query['id'];
                     unset($query['id']);

                     $segments[]='event_details';
                     unset($query['view']);
                     unset($query['layout']);
       }

       // link registration
       if(isset($query['layout']) && $query['layout']=='registration')
       {

				// Make sure we have the id and the alias
				if (strpos($query['id'], ':') === false) {
					$db = JFactory::getDbo();
					$aquery = $db->setQuery($db->getQuery(true)
						->select('alias')
						->from('#__icagenda_events')
						->where('id='.(int)$query['id'])
					);
					$alias = $db->loadResult();
					
					$query['id'] = $query['id'].':'.$alias;
					//$query['id'] = $alias;
				}

                    $segments[] = $query['id'];
                     unset($query['id']);

                     $segments[]='event_registration';
                     unset($query['view']);
                     unset($query['layout']);
       }

       // link search
       if(isset($query['view'])&&$query['view']=='search')
       {
                     $segments[]='search';
       }


       return $segments;
}

function iCagendaParseRoute( $segments )
{
       $app = JFactory::getApplication();
       $menu = $app->getMenu();
       $item = $menu->getActive();
       $vars = array();

	// Count route segments
	$count = count($segments);
       
       if (in_array('event_details', $segments)){
              $vars['option'] = 'com_icagenda';
              $vars['view'] = 'list';
              $vars['layout'] = 'event';
              $vars['id']=$segments[0];
       }
       if (in_array('event_registration', $segments)){
              $vars['option'] = 'com_icagenda';
              $vars['view'] = 'list';
              $vars['layout'] = 'registration';
              $vars['id']=$segments[0];
       }
       if (in_array('search', $segments)){
              $vars['option'] = 'com_icagenda';
              $vars['view'] = 'list';
              $vars['layout'] = 'search';
       }

       return $vars;
}

