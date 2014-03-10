Effect.Wipe = function(element) {
	
	
	$(element).style.overflow='hidden'
	//$(element).absolutize()
	$(element).relativize()
	
	var img = arguments[1].newImg || {}
	var wipeDuration = arguments[1].duration || 1
	var wipeMode = arguments[1].mode || 'vSplit'
	var wipeDelay = arguments[1].delay || 0.0
	var oldImg = $(element).firstChild.src
	
	var panels = arguments[1].panels || 10
	var wipeWidth=arguments[1].block_width;
	var wipeHeight=arguments[1].block_height;
	var wipeCenter = parseInt(wipeWidth/2)
	var wipeMiddle = parseInt(wipeHeight/2)
    var slider_code =arguments[1].slider_code;


	switch(wipeMode) {
	
	case 'vSplit':
		$(element).insert(new Element("div", { id: "wipeLeft-"+slider_code, class: "wipe-"+slider_code,  style:'display:none;position:absolute;top:0px;left:0px;z-index:10;overflow:hidden;width:'+wipeCenter+'px;height:'+wipeHeight+'px;background-image:url('+oldImg+'); background-size: '+wipeWidth+'px '+wipeHeight+'px;' }))
		$(element).insert(new Element("div", { id: "wipeRight-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:0px;left:'+wipeCenter+'px;z-index:10;overflow:hidden;width:'+wipeCenter+'px;height:'+wipeHeight+'px;background-image:url('+oldImg+');background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:-'+wipeCenter+'px 0px;' }))
		return new Effect.Parallel([
			new Effect.Morph('wipeLeft-'+slider_code,{queue: { scope: 'wipe-'+slider_code },duration:wipeDuration,style:'width:0px'}),
			new Effect.Morph('wipeRight-'+slider_code,{queue: { scope: 'wipe-'+slider_code},duration:wipeDuration,style:'left:'+wipeWidth+'px;width:0px;background-position:-'+wipeWidth+'px 0px'})], {
				beforeStart: function() {
					Element.show('wipeLeft-'+slider_code)
					Element.show('wipeRight-'+slider_code)
					$(element).firstChild.src=img

				},
				afterFinish: function() {
                    if($('wipeRight-'+slider_code)){
                        Element.remove('wipeRight-'+slider_code)
                    }
                    if($('wipeLeft-'+slider_code)){
                        Element.remove('wipeLeft-'+slider_code)
                    }
				},
				duration:wipeDuration
			}
		)
	break;
	case 'hSplit':
		$(element).insert(new Element("div", { id: "wipeLeft-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:0px;left:0px;z-index:10;overflow:hidden;width:'+wipeWidth+'px;height:'+wipeMiddle+'px;background-image:url('+oldImg+'); background-size: '+wipeWidth+'px '+wipeHeight+'px; ' }))
		$(element).insert(new Element("div", { id: "wipeRight-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:'+wipeMiddle+'px;left:0px;z-index:10;overflow:hidden;width:'+wipeWidth+'px;height:'+wipeMiddle+'px;background-image:url('+oldImg+'); background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:0px -'+wipeMiddle+'px;' }))
		return new Effect.Parallel([
			new Effect.Morph('wipeLeft-'+slider_code,{queue: {scope: 'wipe-'+slider_code},duration:wipeDuration,style:'height:0px'}),
			new Effect.Morph('wipeRight-'+slider_code,{queue: {scope: 'wipe-'+slider_code },duration:wipeDuration,style:'top:'+wipeHeight+'px;height:0px;'})], {
				afterUpdate: function() {
					//work-around to fix fact that effect.morph does not handle background position properly
					if ( $('wipeRight-'+slider_code) )
					{
						$('wipeRight-'+slider_code).style.backgroundPosition='0px -'+$('wipeRight-'+slider_code).style.top
					}
				},
				beforeStart: function() {					
					Element.show('wipeLeft-'+slider_code)
					Element.show('wipeRight-'+slider_code)
					$(element).firstChild.src=img
				},
				afterFinish: function() {
                    if($('wipeRight-'+slider_code)){
                        Element.remove('wipeRight-'+slider_code)
                    }
                    if($('wipeLeft-'+slider_code)){
					Element.remove('wipeLeft-'+slider_code)
                    }

				},
				duration:wipeDuration
			}
		)
	break;
	case 'toRight':
		$(element).insert(new Element("div", { id: "wipeRight-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:0px;left:0px;z-index:10;overflow:hidden;width:0px;height:'+wipeHeight+'px;background-image:url('+img+');background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:0px 0px;' }))
		return new Effect.Morph('wipeRight-'+slider_code,{
                queue: {scope: 'wipe-'+slider_code},
                duration:wipeDuration,
			style:'left:0px;width:'+wipeWidth+'px', 
			beforeStart: function() {
				Element.show('wipeRight-'+slider_code)
			},
			afterFinish: function() {				
				$(element).firstChild.src=img

                if($('wipeRight-'+slider_code)){
                    Element.remove('wipeRight-'+slider_code)
                }
			}}
		)
	break;
	case 'toLeft':
		$(element).insert(new Element("div", { id: "wipeRight-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:0px;left:'+wipeWidth+'px;z-index:10;overflow:hidden;width:0px;height:'+wipeHeight+'px;background-image:url('+img+'); background-size: '+wipeWidth+'px '+wipeHeight+'px; background-position:-'+wipeWidth+'px 0px;' }))
		return new Effect.Morph('wipeRight-'+slider_code,{
                queue: {scope: 'wipe-'+slider_code },
                duration:wipeDuration,
			style:'left:0px;width:'+wipeWidth+'px;background-position:0px 0px', 
			beforeStart: function() {
				Element.show('wipeRight-'+slider_code)
			},
			afterFinish: function() {								
				$(element).firstChild.src=img

                if($('wipeRight-'+slider_code)){
                    Element.remove('wipeRight-'+slider_code)
                }
			}}
		)
	break;
	case 'toTop':
		$(element).insert(new Element("div", { id: "wipeRight-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:'+wipeHeight+'px;left:0px;z-index:10;overflow:hidden;width:'+wipeWidth+'px;height:0px;background-image:url('+img+');background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:0px '+wipeHeight+'px;' }))
		return new Effect.Morph('wipeRight-'+slider_code,{
                queue: {scope: 'wipe-'+slider_code},
                duration:wipeDuration,
			style:'top:0px;height:'+wipeHeight+'px;', 
			afterUpdate: function() {
					//work-around to fix fact that effect.morph does not handle background position properly
					$('wipeRight-'+slider_code).style.backgroundPosition='0px -'+$('wipeRight-'+slider_code).style.top
				},
			beforeStart: function() {
				Element.show('wipeRight-'+slider_code)
			},
			afterFinish: function() {								
				$(element).firstChild.src=img

                if($('wipeRight-'+slider_code)){
                    Element.remove('wipeRight-'+slider_code)
                }
			}}
		)
	break;
	case 'toBottom':
		$(element).insert(new Element("div", { id: "wipeRight-"+slider_code, class: "wipe-"+slider_code, style:'display:none;position:absolute;top:0px;left:0px;z-index:10;overflow:hidden;width:'+wipeWidth+'px;height:0px;background-image:url('+img+'); background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:0px 0px;' }))
		return new Effect.Morph('wipeRight-'+slider_code,{
                queue: {scope: 'wipe-'+slider_code },
                duration:wipeDuration,
			style:'top:0px;height:'+wipeHeight+'px;background-position:0px 0px', 
			beforeStart: function() {
				Element.show('wipeRight-'+slider_code)
			},
			afterFinish: function() {								
				$(element).firstChild.src=img

                if($('wipeRight-'+slider_code)){
                    Element.remove('wipeRight-'+slider_code)
                }
			}}
		)
	break;
	case 'flipRight':
		//break the image down into pieces
		var steps = 50
		var vBars=Math.round(wipeWidth/steps)
		var hBars=Math.round(wipeHeight/steps)
		for(var x=0;x<steps;x++) {
			barHeight = hBars
			if(x==steps-1) {				
				barHeight = barHeight + wipeHeight - (hBars*steps)
			}
			barLeft = (hBars*x)+(wipeWidth/3)
			$(element).insert(new Element("div", { id: "wipeBar-"+slider_code+x, class: "wipe-"+slider_code, style:'position:absolute;top:'+hBars*x+'px;left:-'+barLeft+'px;z-index:10;overflow:hidden;width:'+vBars*x+'px;height:'+barHeight+'px;background-image:url('+img+'); background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:0px -'+hBars*x+'px;' }))
		}
		//return;
		for(var x=0;x<steps-1;x++) {
			new Effect.Morph('wipeBar-'+slider_code+x,{queue: {scope: 'wipe-'+slider_code }, style:'left:0px;width:'+wipeWidth+'px;background-position:0px 0px'})
		}
		new Effect.Morph('wipeBar-'+slider_code+(steps-1),{queue: {scope: 'wipe-'+slider_code }, style:'left:0px;width:'+wipeWidth+'px;background-position:0px 0px',
			afterFinish:function(){
				$(element).firstChild.src=img
				for(var x=0;x<steps;x++) {
					if ( $('wipeBar-'+slider_code+x) )
					{
						Element.remove('wipeBar-'+slider_code+x)
					}
				}
			}
		})
	break;
	case 'hpanels':
		steps = panels
		vBars=Math.round(wipeWidth/steps)
		hBars=Math.round(wipeHeight/steps)
		for(var x=0;x<steps;x++) {
			barHeight = hBars
			if(x==steps-1) {				
				barHeight = barHeight + wipeHeight - (hBars*steps)
			}
			barLeft = Math.round(Math.random()*wipeWidth)
			$(element).insert(new Element("div", { id: "wipeBar-"+slider_code+x, class: "wipe-"+slider_code, style:'position:absolute;top:'+hBars*x+'px;left:-'+barLeft+'px;z-index:10;overflow:hidden;width:0px;height:'+barHeight+'px;background-image:url('+img+');background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:0px -'+hBars*x+'px;' }))
		}
		//return;
		for(var x=0;x<steps-1;x++) {
			new Effect.Morph('wipeBar-'+slider_code+x,{
                queue: {scope: 'wipe-'+slider_code},
                duration:wipeDuration,
				style:'left:0px;width:'+wipeWidth+'px;background-position:0px '+wipeWidth+'px'})
		}
		
		new Effect.Morph('wipeBar-'+slider_code+(steps-1),{
            queue: {scope: 'wipe-'+slider_code},
            duration:wipeDuration,
			style:'left:0px;width:'+wipeWidth+'px;background-position:0px '+wipeWidth+'px',
			afterFinish:function(){
				$(element).firstChild.src=img
				for(var x=0;x<steps;x++) {
					if ( $('wipeBar-'+slider_code+x) )
					{
						Element.remove('wipeBar-'+slider_code+x)
					}
				}
			}
		})

	break;
	case 'vpanels':
		
		steps = panels
		vBars=Math.round(wipeWidth/steps)
		hBars=Math.round(wipeHeight/steps)
		
		for(var x=0;x<steps;x++) {
			barWidth = vBars
			if(x==steps-1) {				
				barWidth = barWidth + wipeWidth - (vBars*steps)
			}
			barLeft = Math.round(Math.random()*wipeWidth)
			
			$(element).insert(new Element("div", { id: "wipeBar-"+slider_code+x, class: "wipe-"+slider_code, style:'position:absolute;left:'+vBars*x+'px;top:-'+barLeft+'px;z-index:10;overflow:hidden;height:0px;width:'+barWidth+'px;background-image:url('+img+');background-size: '+wipeWidth+'px '+wipeHeight+'px;  background-position:-'+vBars*x+'px 0px;' }))
		}
        
		//return;
		for(var x=0;x<steps-1;x++) {
			new Effect.Morph('wipeBar-'+slider_code+x,{
                queue: {scope: 'wipe-'+slider_code},
				duration:wipeDuration,
				style:'top:0px;height:'+wipeHeight+'px;', afterUpdate:
				function() {
					if ( $('wipeBar-'+slider_code+x) )
					{
						$('wipeBar-'+slider_code + x).style.backgroundPosition = wipeHeight + 'px 0px';
					}
				}
			})
		}
		
		new Effect.Morph('wipeBar-'+slider_code+(steps-1),{
            queue: {scope: 'wipe-'+slider_code },
			duration:wipeDuration,
			style:'top:0px;height:'+wipeHeight+'px;',
			afterUpdate:function() {
				if ( $('wipeBar-'+slider_code+x) )
				{
					$('wipeBar-' +slider_code+ x).style.backgroundPosition = wipeHeight + 'px 0px';
				}
			},
			afterFinish:function(){
				$(element).firstChild.src=img
				for(var x=0;x<steps;x++) {
					if ($('wipeBar-'+slider_code+x))
					{
						Element.remove('wipeBar-'+slider_code+x)
					}
				}
			}
		})

	break;	
	default:
		//
	}
	
   
};