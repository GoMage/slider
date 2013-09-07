/**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2012 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.0 
 */ 
GomageSliderClass = Class.create({
	gomage_slider_config: null,
	gomage_slider_slides: null,
	block_id: null,
	order_id: 0,
	start_order_id: 0,
	slides_count: null,
	interval_id: null,
	timeout: null,
	autoplay_state: 'pause',
	initialize:function(data){
		
		if(data && (typeof data.gomage_slider_config != 'undefined')){
			this.gomage_slider_config = data.gomage_slider_config; 
		}
		
		if(data && (typeof data.gomage_slider_slides != 'undefined')){
			this.gomage_slider_slides = data.gomage_slider_slides;
		}
		
		if(data && (typeof data.block_id != 'undefined')){
			this.block_id = data.block_id;
		}
		
		if(data && (typeof data.slides_count != 'undefined')){
			this.slides_count = data.slides_count;
		}
		
		if(data && (typeof data.start_order_id != 'undefined')){
			this.start_order_id = data.start_order_id;
			this.order_id = data.start_order_id;
		}
		
		if ( this.gomage_slider_config 
				&& 
			this.gomage_slider_config[this.block_id]
				&&
			this.gomage_slider_config[this.block_id].enable_autostart == 1
			){
				this.autostart();
		}
		
		if ( this.gomage_slider_config[this.block_id].change_slides_manually == 1 )
		{
			$(document).observe('click', function(event) {
	            var elem = Event.findElement(event, '.sidebar-link');
	
	            if ( elem )
	            {
	            	var clean_id = GomageSlider.cleanId(elem.id, 12);
	            	GomageSlider.changeSlide(clean_id);
	            }
	        });
		}
		else
		{
			$(document).observe('mouseover', function(event) {
	            var elem = Event.findElement(event, '.sidebar-link');
	
	            if ( elem )
	            {
	            	var clean_id = GomageSlider.cleanId(elem.id, 12);
	            	GomageSlider.changeSlide(clean_id);
	            }
	        });
		}
		
		$(document).observe('click', function(event) {
            var elem = Event.findElement(event, 'div.gomage-arrow-right a');

            if ( elem )
            {
            	GomageSlider.changeSlide(GomageSlider.nextId());
            }
        });
		
		$(document).observe('click', function(event) {
            var elem = Event.findElement(event, 'div.gomage-arrow-left a');

            if ( elem )
            {
            	GomageSlider.changeSlide(GomageSlider.prevId());
            }
        });
		
		$(document).observe('click', function(event) {
            var elem = Event.findElement(event, 'div.gomage-play-pause');

            if ( elem )
            {
            	if ( GomageSlider.autoplay_state == 'play' )
            	{
            		GomageSlider.pause();
            	}
            	else
            	{
            		GomageSlider.autostart();
            	}
            }
        });
		
		$(document).observe('click', function(event) {
            var elem = Event.findElement(event, 'div.gomage-content');
            
            if ( elem )
            {
            	GomageSlider.navigate();
            }
        });

	},

	navigate:function(){
		
		var url = this.gomage_slider_slides[this.block_id][this.order_id].slider_link;
		var type = this.gomage_slider_slides[this.block_id][this.order_id].open_slider_link_in;
		
		if ( url != '' )
		{
			if ( type == '1' || type == '2' ) //1 - Not Set, 2 - Same Window
			{
				window.location = url;
			}
			else
			{
				window.open(url, '_blank');
			}
		}
		
	},
	
	autostart:function(change_slide){
		
		var pause_button = $('gomage-slider-block-' + this.block_id).down('div.gomage-play-pause');
		var pause_button_link = $('gomage-slider-block-' + this.block_id).down('div.gomage-play-pause a');
		
		if( change_slide && this.autoplay_state == 'pause' )
		{
			return;
		}
		
		var delay_time = this.gomage_slider_config[this.block_id].delay_time - 0;
		if ( delay_time == 0 )
		{
			delay_time = 0.3;
		}
		
		this.interval_id = setInterval('GomageSlider.changeSlide(GomageSlider.nextId())', delay_time * 1000);
		
		if($('gomage-slider-block-' + this.block_id))
		{
			if ( pause_button )
			{
				pause_button.addClassName('gomage-pause');
				pause_button.removeClassName('gomage-play');
				
				pause_button_link.writeAttribute("title", "Pause" );
			}
		}

		this.autoplay_state = 'play';
	},
	
	pause:function(no_button_change){
		
		clearInterval(this.interval_id);
		
		var pause_button = $('gomage-slider-block-' + this.block_id).down('div.gomage-play-pause');
		var pause_button_link = $('gomage-slider-block-' + this.block_id).down('div.gomage-play-pause a');
		
		if ( pause_button && no_button_change != true )
		{
			pause_button.addClassName('gomage-play');
			pause_button.removeClassName('gomage-pause');
			
			pause_button_link.writeAttribute("title", "Play" );
			
			this.autoplay_state = 'pause';
		}
	},
	
	changeSlide:function(clean_id){
		this.changeWithEffect(clean_id);
		this.changeStyle(clean_id);
		
		var content_text = $('gomage-slider-block-' + this.block_id).down('div.gomage-content-text');
		if ( content_text )
		{
			content_text.innerHTML = this.gomage_slider_slides[this.block_id][clean_id].slider_text;
		}
		
		var image_link = $('gomage-slider-block-' + this.block_id).down('div.gomage-content-image a.slide-id');
		if ( image_link )
		{
			var url = this.gomage_slider_slides[this.block_id][clean_id].slider_link;
			var type = this.gomage_slider_slides[this.block_id][clean_id].open_slider_link_in;
			
			if ( url != '' )
			{
				image_link.writeAttribute('href', url);
			}
			else
			{
				image_link.removeAttribute('href');
			}
			
			if ( type == '1' || type == '2' ) //1 - Not Set, 2 - Same Window
			{
				image_link.writeAttribute('target', '_self');
			}
			else
			{
				image_link.writeAttribute('target', '_blank');
			}
		}
		
		var image_alt = $('gomage-slider-block-' + this.block_id).down('div.gomage-content-image img');
		if ( image_alt )
		{
			var alt = this.gomage_slider_slides[this.block_id][this.order_id].alt_text;
			
			image_alt.writeAttribute('alt', alt);
		}
		
		
		if ( this.gomage_slider_config[this.block_id].show_navigation_bar == 2 ) // 2 - Sidebar 
		{
			$$('div.gomage-sidebar-item').each(function(e) {
		        e.removeClassName('active');
		    });
		}
		else
		{
			$$('li.sidebar-link').each(function(e) {
		        e.removeClassName('active');
		    });
		}
		
		
		if ( $('sidebar-item-order-' + clean_id) )
		{
			$('sidebar-item-order-' + clean_id).addClassName('active');
		}
		
		if ( $('slide-order-' + clean_id) )
		{
			$('slide-order-' + clean_id).addClassName('active');
		}
		
		this.order_id = clean_id;
		current_id = clean_id;
	},
	
	changeStyle:function(clean_id){
		
		this.contentStyle(clean_id);
	},
	
	contentStyle:function(clean_id){
		
		var content_text = $('gomage-slider-block-' + this.block_id).down('div.gomage-content-text');
		if ( content_text )
		{
			var content_text_bg = $('gomage-slider-block-' + this.block_id).down('div.gomage-content-text-bg');
			var width;
			var height;
			var leftIndent = this.gomage_slider_slides[this.block_id][clean_id].text_window_left_indent - 0;
			var topIndent = this.gomage_slider_slides[this.block_id][clean_id].text_window_top_indent - 0;
			
			if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_width != '' && (this.gomage_slider_slides[this.block_id][clean_id].text_window_width - 0) > 0 ){
				content_text.style.width = this.gomage_slider_slides[this.block_id][clean_id].text_window_width + 'px';
				content_text_bg.style.width = this.gomage_slider_slides[this.block_id][clean_id].text_window_width + 'px';
			}
			else
			{
				if (this.gomage_slider_config[this.block_id].show_navigation_bar == 2) // 2 - Sidebar
				{	
					if ( this.gomage_slider_config[this.block_id].navigation_bar_alignment != 3 //TOP
			    			&&
			    		 this.gomage_slider_config[this.block_id].navigation_bar_alignment != 4) //BOTTOM 
			    	{
			    		width = (this.gomage_slider_config[this.block_id].block_width - 0) - (this.gomage_slider_config[this.block_id].sidebar_width - 0);
			    	}
			    	else 
			    	{
			    		width = (this.gomage_slider_config[this.block_id].block_width - 0);
			    	}
				}
				else
				{
					width = (this.gomage_slider_config[this.block_id].block_width - 0);
				}
				
				width = width - leftIndent;
				
				content_text.style.width = width + 'px';
				content_text_bg.style.width = width + 'px';
			}
			
			if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_height != '' && (this.gomage_slider_slides[this.block_id][clean_id].text_window_height - 0) > 0 ){
				content_text.style.height = this.gomage_slider_slides[this.block_id][clean_id].text_window_height + 'px';
				content_text_bg.style.height = this.gomage_slider_slides[this.block_id][clean_id].text_window_height + 'px';
			}
			else
			{
				if (this.gomage_slider_config[this.block_id].show_navigation_bar == 2) // 2 - Sidebar
				{
					if ( this.gomage_slider_config[this.block_id].navigation_bar_alignment != 3 //TOP
			    			&&
			    		 this.gomage_slider_config[this.block_id].navigation_bar_alignment != 4) //BOTTOM 
			    	{
			    		height = (this.gomage_slider_config[this.block_id].block_height - 0);
			    	}
			    	else 
			    	{
			    		height = (this.gomage_slider_config[this.block_id].block_height - 0) - (this.gomage_slider_config[this.block_id].sidebar_height - 0);
			    	}
				}
				else
				{
					height = (this.gomage_slider_config[this.block_id].block_height - 0);
				}
				
				height = height - topIndent;
				
				content_text.style.height = height + 'px';
				content_text_bg.style.height = height + 'px';
			}
			
			if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_alignment == 1  ){ // 1 - Left
				content_text.style.textAlign = 'left';
			}
			else
			{
				content_text.style.textAlign = 'right';
			}
			
			var ver = this.getInternetExplorerVersion();
			
			if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_background != '' ){
				content_text_bg.style.backgroundColor = this.gomage_slider_slides[this.block_id][clean_id].text_window_background;
				
				if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_opacity != '' ){
					if (navigator.appVersion.indexOf("MSIE 7.") != -1 || ver == '8')
					{
						content_text_bg.style.filter = 'alpha(opacity=' + (this.gomage_slider_slides[this.block_id][clean_id].text_window_opacity - 0) * 100 + ');';
					}
					else
					{
						content_text_bg.style.opacity = this.gomage_slider_slides[this.block_id][clean_id].text_window_opacity;
					}
				}
				else
				{
					content_text_bg.style.backgroundColor = '';
				}
			}
			else
			{
				content_text_bg.style.backgroundColor = '';
				
				if (navigator.appVersion.indexOf("MSIE 7.") != -1 || ver == '8')
				{
					content_text_bg.style.filter = '';
				}
				else
				{
					content_text_bg.style.opacity = '';
				}
			}
			
			if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_left_indent != '' ){
				content_text.style.marginLeft = this.gomage_slider_slides[this.block_id][clean_id].text_window_left_indent + 'px';
				content_text_bg.style.marginLeft = this.gomage_slider_slides[this.block_id][clean_id].text_window_left_indent + 'px';
			}
			
			if ( this.gomage_slider_slides[this.block_id][clean_id].text_window_top_indent != '' ){
				content_text.style.marginTop = this.gomage_slider_slides[this.block_id][clean_id].text_window_top_indent + 'px';
				content_text_bg.style.marginTop = this.gomage_slider_slides[this.block_id][clean_id].text_window_top_indent + 'px';
			}
		}
	},
	
	getInternetExplorerVersion:function(){

	    var rv = -1; // Return value assumes failure.

	    if (navigator.appName == 'Microsoft Internet Explorer') {

	        var ua = navigator.userAgent;

	        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");

	        if (re.exec(ua) != null)

	            rv = parseFloat(RegExp.$1);

	    }

	    return rv;

	},
	
	changeWithEffect:function(clean_id){
		
		clearTimeout(this.timeout);
		
		if( this.gomage_slider_slides[this.block_id][clean_id].effect == '1' ){ // Simple
			var mode = 'simple';
		}
		else if ( this.gomage_slider_slides[this.block_id][clean_id].effect == '2' ){ // Vertical split
			var mode = 'vSplit';
		}
		else if ( this.gomage_slider_slides[this.block_id][clean_id].effect == '3' ){ // Horizontal split
			var mode = 'hSplit';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '4' ){ // Wipe right
			var mode = 'toRight';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '5' ){ // Wipe left
			var mode = 'toLeft';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '6' ){ // Wipe up
			var mode = 'toTop';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '7' ){ // Wipe down
			var mode = 'toBottom';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '8' ){ // Page Flip
			var mode = 'flipRight';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '9' ){ // Horizontal panels
			var mode = 'hpanels';
		}
		else if( this.gomage_slider_slides[this.block_id][clean_id].effect == '10' ){ // Vertical panels
			var mode = 'vpanels';
		}
		
		this.effect(clean_id, mode);
	},
	
	
	effect: function(clean_id, mode)
	{
	    if ( this.gomage_slider_config 
				&& 
			this.gomage_slider_config[this.block_id]
				&&
			this.gomage_slider_config[this.block_id].enable_autostart == 1 // true
				&&
			this.autoplay_state == 'play'
			){
	    		this.pause(true);
	    		
				this.changeTimeout = setTimeout('GomageSlider.autostart(true);', this.gomage_slider_config[this.block_id].transition_time * 1000);
		}
	    
	    var img = $('gomage-slider-block-' + this.block_id).down('div.gomage-content-image a img');
	    
	    if ( mode != 'simple' )
	    {
	    	$('slide-id').innerHTML = '<img src="' + img.src + '">';
	    	
	    	new Effect.Wipe('slide-id',{block_height:this.gomage_slider_config[this.block_id].block_height,block_width:this.gomage_slider_config[this.block_id].block_width,'newImg':this.gomage_slider_slides[this.block_id][clean_id].image,duration:this.gomage_slider_config[this.block_id].transition_time,mode:mode});
	    }
	    else
	    {
	    	img.writeAttribute("src", this.gomage_slider_slides[this.block_id][clean_id].image );
	    }
	},
	
	
	cleanId:function(dirty_id, start){
		return dirty_id.substr(start) - 0;
	},
	
	nextId:function(){
		
		if ( $('slide-order-' + (this.order_id + 1) ) )
		{
			return this.order_id + 1;
		}
		
		return this.start_order_id;
	},
	
	prevId:function(){
		
		if ( (this.order_id - 1) >=0 && $('slide-order-' + (this.order_id - 1) ) )
		{
			return this.order_id - 1;
		}
		
		return this.slides_count - 1;
	},
	
	returnNull:function(){
		
	}
});