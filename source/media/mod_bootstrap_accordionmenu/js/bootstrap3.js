/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2015 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link http://www.yireo.com
 */

jQuery(document).ready(function() {
    if(modBootstrapAccordionMenu_hover == 1) {
        jQuery('div.panel-heading').hover(function(){
            var link = jQuery(this).children();
            if(link.attr('data-toggle') == 'collapse') {
                var submenu = jQuery(this).children().attr('href');
                if(jQuery(submenu).css('height') == '0px') {
                    jQuery('div.panel-body').each(function(){
                        if(this != submenu && jQuery(this).css('height') != '0px') {
                            jQuery(this).collapse('hide');
                        }
                    });
                    jQuery(submenu).collapse('show');
                }
            }
        });

        jQuery('.panel-title a').click(function(){
            var location = jQuery(this).attr('data-href');
            window.location.replace(location);
        });

    } else {
        jQuery('.panel-title a').click(function(){
            if(jQuery(this).attr('aria-expanded') == 'true') {
                var location = jQuery(this).attr('data-href');
                window.location.replace(location);
            }
        });
    }
});
