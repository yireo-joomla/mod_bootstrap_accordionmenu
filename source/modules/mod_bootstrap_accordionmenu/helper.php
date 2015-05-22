<?php
/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author    Yireo (info@yireo.com)
 * @copyright Copyright 2015 Yireo.com. All rights reserved
 * @license   GNU Public License
 * @link      http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;

/*
 * Helper class
 */

class ModBootstrapAccordionMenuHelper
{
	/**
	 * Constructor
	 *
	 * @param null $params
	 */
	public function __construct($params = null)
	{
		$this->params = $params;
	}

	/**
	 * Method to return the currently active Menu-Item
	 *
	 * @param null
	 *
	 * @return mixed $active
	 */
	public function getActive()
	{
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();

		return $active;
	}

	/**
	 * Method to return a list of all Menu-Items that form the top-level of the accordion
	 *
	 * @return array $parents
	 */
	public function getParents()
	{
		$items = $this->getItems();
		$parents = array();
		if (!empty($items))
		{
			$i = 0;
			foreach ($items as $item)
			{

				$base = $this->params->get('base');
				$active = $this->getActive();
				if (empty($base) && !empty($active))
				{
					$base = $active->parent_id;
				}
				if (empty($base))
				{
					continue;
				}

				if ($item->level == $this->params->get('startLevel', 1) && ($item->parent_id == $base))
				{

					$item = $this->prepareItem($item, $i);
					$item->html_id = md5($this->params) . '-' . $item->id;

					$parents[] = $item;
					$i++;
				}
			}
		}

		return $parents;
	}

	/**
	 * Method to return all Menu-Items that lie underneath a specific parent Menu-Item
	 *
	 * @param int $parent_id
	 *
	 * @return array $childs
	 */
	public function getChildren($parent_id)
	{
		$items = $this->getItems();
		$childs = array();
		if (!empty($items))
		{
			$i = 0;
			foreach ($items as $item)
			{
				if ($item->parent_id == $parent_id)
				{
					$item = $this->prepareItem($item, $i);
					$childs[] = $item;
				}
				$i++;
			}
		}

		return $childs;
	}

	/**
	 * Method to return the currently active Menu-Item
	 *
	 * @param object $item
	 * @param int    $i
	 *
	 * @return object $item
	 */
	public function prepareItem($item, $i)
	{
		$active = $this->getActive();
		if (!empty($active->tree))
		{
			$item->active = (in_array($item->id, $active->tree)) ? true : false;
			$item->current = ($item->id == $active->id) ? true : false;
		}
		else
		{
			$item->active = false;
			$item->current = false;
		}

		$item->classes = array();
		if ($item->active)
		{
			$item->classes[] = 'active';
		}
		if ($item->current)
		{
			$item->classes[] = 'current';
		}
		if ($i % 2 == 0)
		{
			$item->classes[] = 'even';
		}
		if ($i % 2 == 1)
		{
			$item->classes[] = 'odd';
		}

		switch ($item->type) :
			case 'separator':
				$item->href = null;
				break;

			case 'url':
				if (isset($item->flink))
				{
					$item->href = $item->flink;
				}
				if (isset($item->link))
				{
					$item->href = $item->link;
				}
				break;

			case 'alias':
				$item->href = JRoute::_('index.php?Itemid=' . $item->params->get('aliasoptions', null));
				break;

			default:
				$item->href = JRoute::_('index.php?Itemid=' . $item->id);
				break;
		endswitch;

		$item->childs = $this->getChildren($item->id);

		return $item;
	}

	/**
	 * Method to return all the Menu-Items
	 *
	 * @return array $items
	 */
	public function getItems()
	{
		static $items = array();
		$paramsHash = md5(serialize($this->params));

		if (empty($items[$paramsHash]))
		{
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
			$menutype = $this->params->get('menutype');
			//$menutype = (is_object($this->params)) ? $this->params->get('menutype') : null;
			$items[$paramsHash] = $menu->getItems('menutype', $menutype);
			// @todo: Implement ACLs
		}

		return $items[$paramsHash];
	}

	/**
	 * Method to print a submenu
	 *
	 * @param array $childs
	 *
	 * @return null
	 */
	public function submenu($items)
	{
		if (!empty($items))
		{
			require JModuleHelper::getLayoutPath('mod_bootstrap_accordionmenu', 'default_submenu');
		}
	}

	/**
	 * Method to add a stylesheet
	 *
	 * @param $css
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function addStylesheet($css)
	{
		if ($this->params->get('load_css', 1) == 0)
		{
			return false;
		}

		$template = JFactory::getApplication()->getTemplate();
		$document = JFactory::getDocument();

		if (file_exists(JPATH_SITE . '/templates/' . $template . '/css/mod_bootstrap_accordionmenu/' . $css))
		{
			$document->addStylesheet('templates/' . $template . '/css/mod_bootstrap_accordionmenu/' . $css);
		}
		else
		{
			$document->addStylesheet('media/mod_bootstrap_accordionmenu/css/' . $css);
		}

		return true;
	}

	/**
	 * Method to add a JavaScript file
	 *
	 * @param $js
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function addScript($js)
	{
		if ($this->params->get('load_js', 1) == 0)
		{
			return false;
		}

		$template = JFactory::getApplication()->getTemplate();
		$document = JFactory::getDocument();

		if (file_exists(JPATH_SITE . '/templates/' . $template . '/js/mod_bootstrap_accordionmenu/' . $js))
		{
			$document->addScript('templates/' . $template . '/js/mod_bootstrap_accordionmenu/' . $js);
		}
		else
		{
			$document->addScript('media/mod_bootstrap_accordionmenu/js/' . $js);
		}

		return true;
	}
}
