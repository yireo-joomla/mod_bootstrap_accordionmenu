/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2012 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link http://www.yireo.com
 */

jQuery(document).ready(function() {
    if(modBootstrapAccordionMenu_hover == 1) {
        jQuery('div.accordion-heading').hover(function(){
            var link = jQuery(this).children();
            if(link.attr('data-toggle') == 'collapse') {
                var submenu = jQuery(this).children().attr('href');
                if(jQuery(submenu).css('height') == '0px') {
                    jQuery('div.accordion-body').each(function(){
                        if(this != submenu && jQuery(this).css('height') != '0px') {
                            jQuery(this).collapse('hide');
                        }
                    });
                    jQuery(submenu).collapse('show');
                }
            }
        });

        jQuery('a.accordion-parent').click(function(){
            var location = jQuery(this).attr('data-href');
            window.location.replace(location);
        });
    }
});
