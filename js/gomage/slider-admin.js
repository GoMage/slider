/**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2012 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.1
 */

SliderAdminSettings = Class.create({
	initialize:function(data){
	
		if(data && (typeof data.show_arrows != 'undefined')){
			this.show_arrows = data.show_arrows;
		}
		
		this.setArrowsType($('arrows_type').value);
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
	
});	