<?php
/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author    Yireo (info@yireo.com)
 * @copyright Copyright 2016 Yireo.com. All rights reserved
 * @license   GNU Public License
 * @link      https://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';
$helper = new ModBootstrapAccordionMenuHelper($params);

// Determine the layout
$layout = $params->get('layout', 'default');

if (empty($layout))
{
	$layout = 'default';
}

$baseLayout = preg_replace('/^(.*):/', '', $layout);

// Load CSS
$helper->addStylesheet($baseLayout . '.css');

// Load JavaScript
$helper->addScript($baseLayout . '.js');

$parents = $helper->getParents();
$showAll = $params->get('showAllChildren');
$class_sfx = htmlspecialchars($params->get('class_sfx'));

// Determine the tag_id
$tag_id = trim($params->get('tag_id'));

if (empty($tag_id))
{
	$tag_id = md5($params);
}

// If the toplevel is not empty, load the template
if (count($parents))
{
	require JModuleHelper::getLayoutPath('mod_bootstrap_accordionmenu', $layout);
}