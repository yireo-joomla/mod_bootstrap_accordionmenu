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
<div class="accordion" id="<?php echo $tag_id; ?>">
    <div class="accordion-group">
        <?php foreach($parents as $parent) : ?>
        <?php $collapse_status = ($parent->active) ? 'in' : 'out'; ?>
        <div class="accordion-heading">
            <?php if(!empty($parent->childs)) : ?>
            <a class="accordion-toggle accordion-parent <?php echo implode(' ', $parent->classes); ?>" data-toggle="collapse" data-parent="#<?php echo $tag_id; ?>" href="#<?php echo $parent->html_id; ?>"><?php echo $parent->title; ?></a>
            <?php else: ?>
            <a class="accordion-toggle <?php echo implode(' ', $parent->classes); ?>" href="<?php echo $parent->href; ?>"><?php echo $parent->title; ?></a>
            <?php endif; ?>
        </div>
        <?php if(!empty($parent->childs)) : ?>
        <div id="<?php echo $parent->html_id; ?>" class="accordion-body collapse <?php echo $collapse_status; ?>">
            <div class="accordion-inner">
                <?php modBootstrapAccordionMenuHelper::submenu($parent->childs); ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
