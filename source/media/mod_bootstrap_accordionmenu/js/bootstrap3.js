/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2016 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link https://www.yireo.com
 */

jQuery(document).ready(function() {
    if(modBootstrapAccordionMenu_hover == 1) {
        jQuery('div.panel-heading').hover(function(){
            var link = jQuery(this).find('a');
            if(link.attr('data-toggle') == 'collapse') {
                var submenu = jQuery(link.attr('href'));
                if (submenu.hasClass('out')) {
                    submenu.collapse('show');
                    return;
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
