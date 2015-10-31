/**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.3
 */
GomageSliderClass = Class.create({
    config: null,
    slides: null,
    ver: null,
    slides_count: 0,
    order_id: 0,
    autoplay_state: 'pause',
    slider_code: null,
    timeout_id: null,

    initialize: function (data) {

        this.ver = this.getInternetExplorerVersion();

        if (data && (typeof data.config != 'undefined')) {
            this.config = data.config;
        }

        if (data && (typeof data.slides != 'undefined')) {
            this.slides = data.slides;
        }

        if (data && (typeof data.slider_code != 'undefined')) {
            this.slider_code = data.slider_code;
        }

        var self = this;
        var slider_code = this.slider_code;
        this.slides_count = this.slides.length

        var change_slides_manually_event = 'click';
        if (this.config.change_slides_manually != 1) {
            change_slides_manually_event = 'mouseover';
        }

        $('gomage-slider-block-' + slider_code).observe(change_slides_manually_event, function (event) {
            var elem = Event.findElement(event, '.gs-' + slider_code);
            if (elem) {
                var slider_id = elem.dataset.id;
                self.changeSlide(slider_id, 'manual');
            }
        });


        $('gomage-slider-block-' + slider_code).observe('click', function (event) {

            var elem = Event.findElement(event, 'div.gomage-arrow-right a.right-' + slider_code);
            if (elem) {
                self.changeSlide(self.nextId(), 'manual');
            }

            var elem = Event.findElement(event, 'div.gomage-arrow-left a.left-' + slider_code);
            if (elem) {
                self.changeSlide(self.prevId(), 'manual');
            }

            var elem = Event.findElement(event, 'div.gomage-play-pause-' + slider_code);
            if (elem) {
                if (self.autoplay_state == 'play') {
                    self.pause();
                } else {
                    self.start();
                }
            }

            var elem = Event.findElement(event, 'div.gomage-content-' + slider_code);
            if (elem) {
                self.navigate();
            }

        });

        if (this.config.enable_autostart == 1) {
            this.start();
        }

    },

    navigate: function () {
        var url = this.slides.slider_link;
        var type = this.slides.open_slider_link_in;
        if (url != '') {
            if (type == '1' || type == '2') //1 - Not Set, 2 - Same Window
            {
                window.location = url;
            }
            else {
                window.open(url, '_blank');
            }
        }
    },

    start: function () {

        var pause_button = $('gomage-slider-block-' + this.slider_code).down('div.gomage-play-pause-' + this.slider_code);
        var pause_button_link = $('gomage-slider-block-' + this.slider_code).down('div.gomage-play-pause-' + this.slider_code + ' a.play-pause-' + this.slider_code);

        if ($('gomage-slider-block-' + this.slider_code)) {
            if (pause_button) {
                pause_button.addClassName('gomage-pause');
                pause_button.removeClassName('gomage-play');
                pause_button_link.writeAttribute("title", "Pause");
            }
        }

        var delay_time = Math.ceil(this.config.delay_time);

        if (delay_time == 0) {
            delay_time = 1;
        }

        clearTimeout(this.timeout_id);
        this.timeout_id = setTimeout(function () {
            this.changeSlide(this.nextId(), 'auto');
        }.bind(this), delay_time * 1000);

        this.autoplay_state = 'play';
    },

    pause: function () {

        clearTimeout(this.timeout_id);

        var queue = Effect.Queues.get('wipe-' + this.slider_code);
        if (queue.effects.length) {
            var last_element = queue.effects.last();
            var after_finish = last_element.options.afterFinish;

            if (after_finish && typeof(after_finish) === "function") {
                after_finish();
            }
            queue.invoke('cancel');
        }

        var pause_button = $('gomage-slider-block-' + this.slider_code).down('div.gomage-play-pause-' + this.slider_code);
        var pause_button_link = $('gomage-slider-block-' + this.slider_code).down('div.gomage-play-pause-' + this.slider_code + ' a');

        if (pause_button) {
            pause_button.addClassName('gomage-play');
            pause_button.removeClassName('gomage-pause');
            pause_button_link.writeAttribute("title", "Play");
        }

        this.autoplay_state = 'pause';
    },

    changeSlide: function (slider_id, type) {

        if (typeof type === 'undefined') {
            type = 'auto';
        }

        var queue = Effect.Queues.get('wipe-' + this.slider_code);

        if (type == 'manual' && queue.effects.length) {
            var last_element = queue.effects.last();
            var after_finish = last_element.options.afterFinish;

            if (after_finish && typeof(after_finish) === "function") {
                after_finish();
            }
            queue.invoke('cancel');
        }

        if (type == 'auto') {
            var delay_time = Math.ceil(this.config.delay_time);
            var transition_time = Math.ceil(this.config.transition_time);

            if (delay_time == 0) {
                delay_time = 1;
            }

            if (transition_time == 0) {
                transition_time = 1;
            }

            if (queue.effects.length) {
                clearTimeout(this.timeout_id);
                this.timeout_id = setTimeout(function () {
                    this.changeSlide(this.nextId(), 'auto');
                }.bind(this), transition_time * 1000);

                return;
            }

            clearTimeout(this.timeout_id);
            this.timeout_id = setTimeout(function () {
                this.changeSlide(this.nextId(), 'auto');
            }.bind(this), (transition_time + delay_time) * 1000);

        }

        this.changeWithEffect(slider_id);
        this.contentStyle(slider_id);
    },

    contentStyle: function (slider_id) {

        var content_text = $('gomage-slider-block-' + this.slider_code).down('div.gomage-content-text');
        if (content_text) {
            var content_text_bg = $('gomage-slider-block-' + this.slider_code).down('div.gomage-content-text-bg');
            var width;
            var height;
            var leftIndent = Math.ceil(this.slides[slider_id].text_window_left_indent);
            var topIndent = Math.ceil(this.slides[slider_id].text_window_top_indent);

            if (this.slides[slider_id].text_window_width != '' && (Math.ceil(this.slides[slider_id].text_window_width)) > 0) {
                content_text.style.width = this.slides[slider_id].text_window_width + 'px';
                content_text_bg.style.width = this.slides[slider_id].text_window_width + 'px';
            }
            else {
                if (this.config.show_navigation_bar == 2) // 2 - Sidebar
                {
                    if (this.config.navigation_bar_alignment != 3 //TOP
                        &&
                        this.config.navigation_bar_alignment != 4) //BOTTOM
                    {
                        width = (Math.ceil(this.getBlockWidth())) - (Math.ceil(this.config.sidebar_width));
                    }
                    else {
                        width = (Math.ceil(this.getBlockWidth()));
                    }
                }
                else {
                    width = (Math.ceil(this.getBlockWidth()));
                }

                width = width - leftIndent;

                content_text.style.width = width + 'px';
                content_text_bg.style.width = width + 'px';
            }

            if (this.slides[slider_id].text_window_height != '' && (Math.ceil(this.slides[slider_id].text_window_height)) > 0) {
                content_text.style.height = this.slides[slider_id].text_window_height + 'px';
                content_text_bg.style.height = this.slides[slider_id].text_window_height + 'px';
            }
            else {
                if (this.config.show_navigation_bar == 2) // 2 - Sidebar
                {
                    if (this.config.navigation_bar_alignment != 3 //TOP
                        &&
                        this.config.navigation_bar_alignment != 4) //BOTTOM
                    {
                        height = (Math.ceil(this.getBlockHeight()));
                    }
                    else {
                        height = (Math.ceil(this.getBlockHeight())) - (Math.ceil(this.config.sidebar_height));
                    }
                }
                else {
                    height = (Math.ceil(this.getBlockHeight()));
                }

                height = height - topIndent;

                content_text.style.height = height + 'px';
                content_text_bg.style.height = height + 'px';
            }

            if (this.slides[slider_id].text_window_alignment == 1) { // 1 - Left
                content_text.style.textAlign = 'left';
            }
            else {
                content_text.style.textAlign = 'right';
            }


            if (this.slides[slider_id].text_window_background != '') {
                content_text_bg.style.backgroundColor = this.slides[slider_id].text_window_background;

                if (this.slides[slider_id].text_window_opacity != '') {
                    if (navigator.appVersion.indexOf("MSIE 7.") != -1 || this.ver == '8') {
                        content_text_bg.style.filter = 'alpha(opacity=' + (Math.ceil(this.slides[slider_id].text_window_opacity)) * 100 + ');';
                    }
                    else {
                        content_text_bg.style.opacity = this.slides[slider_id].text_window_opacity;
                    }
                }
                else {
                    content_text_bg.style.backgroundColor = '';
                }
            }
            else {
                content_text_bg.style.backgroundColor = '';

                if (navigator.appVersion.indexOf("MSIE 7.") != -1 || this.ver == '8') {
                    content_text_bg.style.filter = '';
                }
                else {
                    content_text_bg.style.opacity = '';
                }
            }

            if (this.slides[slider_id].text_window_left_indent != '') {
                content_text.style.marginLeft = this.slides[slider_id].text_window_left_indent + 'px';
                content_text_bg.style.marginLeft = this.slides[slider_id].text_window_left_indent + 'px';
            }

            if (this.slides[slider_id].text_window_top_indent != '') {
                content_text.style.marginTop = this.slides[slider_id].text_window_top_indent + 'px';
                content_text_bg.style.marginTop = this.slides[slider_id].text_window_top_indent + 'px';
            }

            content_text.innerHTML = this.slides[slider_id].slider_text;
        }

        var image_link = $('gomage-slider-block-' + this.slider_code).down('div.gomage-content-image a.slide-id-' + this.slider_code);
        if (image_link) {
            var url = this.slides[slider_id].slider_link;
            var type = this.slides[slider_id].open_slider_link_in;

            if (url != '') {
                image_link.writeAttribute('href', url);
            }
            else {
                image_link.removeAttribute('href');
            }

            if (type == '1' || type == '2') //1 - Not Set, 2 - Same Window
            {
                image_link.writeAttribute('target', '_self');
            }
            else {
                image_link.writeAttribute('target', '_blank');
            }
        }

        var image_alt = $('gomage-slider-block-' + this.slider_code).down('div.gomage-content-image img.gs-img-' + this.slider_code);
        if (image_alt) {
            var alt = this.slides[slider_id].alt_text;
            image_alt.writeAttribute('alt', alt);
        }

        if (this.config.show_navigation_bar == 2) // 2 - Sidebar
        {
            $$('div.gomage-sidebar-item-' + this.slider_code).each(function (e) {
                e.removeClassName('active');
            });
        }
        else {
            $$('li.gs-' + this.slider_code).each(function (e) {
                e.removeClassName('active');
            });
        }

        if ($('sidebar-item-order-' + this.slider_code + '-' + slider_id)) {
            $('sidebar-item-order-' + this.slider_code + '-' + slider_id).addClassName('active');
        }

        if ($('slide-order-' + this.slider_code + '-' + slider_id)) {
            $('slide-order-' + this.slider_code + '-' + slider_id).addClassName('active');
        }

        this.order_id = slider_id;
    },

    getInternetExplorerVersion: function () {
        var rv = -1; // Return value assumes failure.
        if (navigator.appName == 'Microsoft Internet Explorer') {
            var ua = navigator.userAgent;
            var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null) {
                rv = parseFloat(RegExp.$1);
            }
        }
        return rv;
    },

    changeWithEffect: function (slider_id) {

        if (this.slides[slider_id].effect == 'SIMPLE') { // Simple
            var mode = 'simple';
        }
        else if (this.slides[slider_id].effect == 'VERTICAL_SPLIT') { // Vertical split
            var mode = 'vSplit';
        }
        else if (this.slides[slider_id].effect == 'HORIZONTAL_SPLIT') { // Horizontal split
            var mode = 'hSplit';
        }
        else if (this.slides[slider_id].effect == 'WIPE_RIGHT') { // Wipe right
            var mode = 'toRight';
        }
        else if (this.slides[slider_id].effect == 'WIPE_LEFT') { // Wipe left
            var mode = 'toLeft';
        }
        else if (this.slides[slider_id].effect == 'WIPE_UP') { // Wipe up
            var mode = 'toTop';
        }
        else if (this.slides[slider_id].effect == 'WIPE_DOWN') { // Wipe down
            var mode = 'toBottom';
        }
        else if (this.slides[slider_id].effect == 'PAGE_FLIP') { // Page Flip
            var mode = 'flipRight';
        }
        else if (this.slides[slider_id].effect == 'HORIZONTAL_PANELS') { // Horizontal panels
            var mode = 'hpanels';
        }
        else if (this.slides[slider_id].effect == 'VERTICAL_PANELS') { // Vertical panels
            var mode = 'vpanels';
        }

        var img = $('gomage-slider-block-' + this.slider_code).down('div.gomage-content-image a img.gs-img-' + this.slider_code);

        if (mode != 'simple') {
            $('slide-id-' + this.slider_code).innerHTML = '<img src="' + img.src + '" class="' + img.className + '">';
            new Effect.Wipe('slide-id-' + this.slider_code, {
                slider_code: this.slider_code,
                block_height: $('gomage-slider-block-' + this.slider_code).down('div.gomage-slider-content').getHeight(),
                block_width: $('gomage-slider-block-' + this.slider_code).down('div.gomage-slider-content').getWidth(),
                newImg: this.slides[slider_id].image,
                duration: this.config.transition_time,
                mode: mode
            });
        }
        else {
            img.writeAttribute("src", this.slides[slider_id].image);
        }

    },


    nextId: function () {
        if ($('slide-order-' + this.slider_code + '-' + (this.order_id + 1))) {
            return this.order_id + 1;
        }
        return 0;
    },

    prevId: function () {

        if ((this.order_id - 1) >= 0 && $('slide-order-' + this.slider_code + '-' + (this.order_id - 1))) {
            return this.order_id - 1;
        }

        return this.slides_count - 1;
    },

    getBlockHeight: function () {
        return $('gomage-slider-block-' + this.slider_code).getHeight();
    },

    getBlockWidth: function () {
        return $('gomage-slider-block-' + this.slider_code).getWidth();
    }


});