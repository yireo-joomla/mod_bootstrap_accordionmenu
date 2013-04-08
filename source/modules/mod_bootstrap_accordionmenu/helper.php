<?php
/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2013 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;

/*
 * Helper class
 */
abstract class modBootstrapAccordionMenuHelper 
{
    /*
     * Method to return the currently active Menu-Item
     *
     * @param null 
     * @return mixed $active 
     */
    public static function getActive()
    {
        $menu = JFactory::getApplication()->getMenu();
        $active = $menu->getActive();
        return $active;
    }

    /*
     * Method to return a list of all Menu-Items that form the top-level of the accordion
     *
     * @param JRegistry $params
     * @return array $parents
     */
    public static function getParents($params)
    {
        $items = self::getItems($params);
        $parents = array();
        if(!empty($items)) {
            $i = 0;
            foreach($items as $item) {
                if($item->level == $params->get('startLevel', 1)) {

                    $item = self::prepareItem($item, $i, $params);
                    $item->html_id = md5($params).'-'.$item->id;

                    $parents[] = $item;
                    $i++;
                }
            }
        }
        return $parents;
    }

    /*
     * Method to return all Menu-Items that lie underneath a specific parent Menu-Item
     *
     * @param int $parent_id
     * @param JRegistry $params
     * @return array $childs
     */
    public static function getChildren($parent_id, $params = null)
    {
        $items = self::getItems($params);
        $childs = array();
        if(!empty($items)) {
            $i = 0;
            foreach($items as $item) {
                if($item->parent_id == $parent_id) {
                    $item = self::prepareItem($item, $i, $params);
                    $childs[] = $item;
                }
                $i++;
            }
        }
        return $childs;
    }

    /*
     * Method to return the currently active Menu-Item
     *
     * @param object $item
     * @param int $i
     * @return object $item
     */
    public static function prepareItem($item, $i, $params)
    {
        $active = self::getActive();
        if(!empty($active->tree)) {
            $item->active = (in_array($item->id, $active->tree)) ? true : false;
            $item->current = ($item->id == $active->id) ? true : false;
        } else {
            $item->active = false;
            $item->current = false;
        }

        $item->classes = array();
        if($item->active) $item->classes[] = 'active';
        if($item->current) $item->classes[] = 'current';
        if($i % 2 == 0) $item->classes[] = 'even';
        if($i % 2 == 1) $item->classes[] = 'odd';

        switch($item->type) :
            case 'separator':
                $item->href = null;
                break;
        
            case 'url':
                if(isset($item->flink)) $item->href = $item->flink;
                if(isset($item->link)) $item->href = $item->link;
                break;
        
            case 'alias':
                $item->href = JRoute::_('index.php?Itemid='.$item->params->get('aliasoptions', null));
                break;
            
            default:
                $item->href = JRoute::_('index.php?Itemid='.$item->id);
                break;
        endswitch;

        $item->childs = self::getChildren($item->id, $params);

        return $item;
    }

    /*
     * Method to return all the Menu-Items
     *
     * @param JRegistry $params
     * @return array $items
     */
    public static function getItems($params)
    {
        static $items = array();
        $paramsHash = md5(serialize($params));
        if(empty($items[$paramsHash])) {
            $app = JFactory::getApplication();
            $menu = $app->getMenu();
            $menutype = $params->get('menutype');
            //$menutype = (is_object($params)) ? $params->get('menutype') : null;
            $items[$paramsHash] = $menu->getItems('menutype', $menutype);
            // @todo: Implement ACLs
        }
        return $items[$paramsHash];
    }

    /*
     * Method to print a submenu
     *
     * @param array $childs
     * @return null
     */
    public static function submenu($items)
    {
        if(!empty($items)) {
            require JModuleHelper::getLayoutPath('mod_bootstrap_accordionmenu', 'default_submenu');
        }
    }
}
