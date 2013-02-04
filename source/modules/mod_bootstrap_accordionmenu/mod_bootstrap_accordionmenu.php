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

// Global variables    
$document = JFactory::getDocument();

// Load CSS
if($params->get('load_css', 1) == 1) {
    $document->addStylesheet('media/mod_bootstrap_accordionmenu/css/default.css');
}

// Load JavaScript
if($params->get('load_js', 1) == 1) {
    $document->addScript('media/mod_bootstrap_accordionmenu/js/default.js');
}

// Include the syndicate functions only once
require_once __DIR__.'/helper.php';

$parents = modBootstrapAccordionMenuHelper::getParents($params);
$showAll = $params->get('showAllChildren');
$class_sfx = htmlspecialchars($params->get('class_sfx'));

// Determine the tag_id
$tag_id = trim($params->get('tag_id'));
if(empty($tag_id)) $tag_id = md5($params);

// If the toplevel is not empty, load the template
if(count($parents)) {
    require JModuleHelper::getLayoutPath('mod_bootstrap_accordionmenu', $params->get('layout', 'default'));
}
