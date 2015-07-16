/**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2014 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 */

SliderAdminSettings = Class.create({
	initialize:function(data){
	
		if(data && (typeof data.show_arrows != 'undefined')){
			this.show_arrows = data.show_arrows;
		}
        if(data && (typeof data.show_navigation_bar != 'undefined')){
            this.show_navigation_bar = data.show_navigation_bar;
        }
		
		this.setArrowsType($('arrows_type').value);
        this.setNavigationBar($('show_navigation_bar').value);

	},
	
	setArrowsType:function(arrows_type){

		switch (arrows_type)
		{
			case '2':		
				$('mouse_over_background').up('tr').show();
				break;	
			case '1':
			default:  
				$('mouse_over_background').up('tr').hide();
				break;								
		}
	},
    setNavigationBar:function(arrows_type){

        switch (arrows_type)
        {
            case '2':
                $('navigation_bar_alignment').up('tr').show();
                $('sidebar_width').up('tr').show();
                $('sidebar_height').up('tr').show();
                break;
            default:
                $('navigation_bar_alignment').up('tr').hide();
                $('sidebar_width').up('tr').hide();
                $('sidebar_height').up('tr').hide();
                break;
        }
    }
	
});	