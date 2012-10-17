<?php
/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2012 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;
?>
<ul>
    <?php foreach($items as $item) : ?>
    <li class="<?php echo implode(' ', $item->classes); ?>">
        <a href="<?php echo $item->href; ?>"><?php echo $item->title; ?></a>
        <?php if(!empty($item->childs)) : ?>
        <?php modBootstrapAccordionMenuHelper::submenu($item->childs); ?>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
</ul>
