(function($) {
  "use strict";
    $=jQuery;
    jQuery(document).ready(function(){
        var module_id, offset;
        
        jQuery('.masonry-ajax').on('click','.ajax-load-btn.active',function(){
            var $this = jQuery(this);
            if($this.hasClass('nomore')){
                $this.text(ajax_btn_str['nomore']);
                return;
            }
            var module_id = $this.parents('.module-masonry').attr('id');
            var entries = ajax_c[module_id]['entries'];
            var args =  ajax_c[module_id]['args'];
            var sec = ajax_c[module_id]['sec'];
                    
            jQuery('.ajax-load-btn').removeClass('active');
            $this.css("display", "none");
            $this.siblings('.loading-animation').css("display", "inline-block")
             
            var $container = $this.parent('.masonry-ajax').siblings('.bk-masonry-wrap').children().children('.bk-masonry-content');     
            var offset = parseInt($container.find('.item').length)+ parseInt(ajax_c[module_id]['offset']);
            console.log(offset);    
            var data = {
    				action			: 'masonry_load',
                    post_offset     : offset,
                    entries         : entries,
                    sec             : sec,
                    args            : args,
    			};
    		jQuery.post( ajaxurl, data, function( respond ){
                var el = $(respond).hide().fadeIn('1500');
                var respond_length = el.find('.bk-mask').length;
                $container.append(el).masonry( 'appended', el );
                $container.imagesLoaded(function(){
                    setTimeout(function() {
            			var postionscroll = jQuery(window).scrollTop();
                            $container.masonry('destroy');
                            $container.masonry({
                                itemSelector: '.item',
                                columnWidth: 1,
                                isAnimated: true,
                                isFitWidth: true,
                             });
            			window.scrollTo(0,postionscroll);
                        jQuery($container).find('.post-c-wrap').removeClass('sink');
                        jQuery($container).find('.post-category').removeClass('sink');
                        jQuery($container).find('.thumb').removeClass('hide-thumb');
                        jQuery('.ajax-load-btn').addClass('active');
                        $this.find('.ajax-load-btn').text(ajax_btn_str['loadmore']);
                        
                        if(respond_length < entries){
                            $this.text(ajax_btn_str['nomore']);
                            $this.addClass('no-more');
                            $this.removeClass('active');
                        } 
                        $this.css("display", "inline-block");
                        $this.siblings('.loading-animation').css("display", "none");
                    }, 500);
                });
    
            });
        });
    // Blog Load Post
        jQuery('.blog-ajax').on('click','.ajax-load-btn.active',function(){
            var $this = jQuery(this);
            if($this.hasClass('nomore')){
                $this.text(ajax_btn_str['nomore']);
                return;
            }
            var module_id = $this.parents('.module-blog').attr('id');
            var entries = ajax_c[module_id]['entries'];
            var args =  ajax_c[module_id]['args'];
                    
            jQuery('.ajax-load-btn').removeClass('active');
            $this.css("display", "none");
            $this.siblings('.loading-animation').css("display", "inline-block")
             
            var $container = $this.parent('.blog-ajax').siblings('.row').children('.bk-blog-content');  
            if ($this.parent('.blog-ajax').hasClass('large-blog')){
                var bk_ajax_action = 'large_blog';
            }else {
                var bk_ajax_action = 'blog_load';
            } 
            var offset = parseInt($container.find('.item').length)+ parseInt(ajax_c[module_id]['offset']);    
            var data = {
    				action			: bk_ajax_action,
                    post_offset     : offset,
                    entries         : entries,
                    args            : args,
    			};
    		jQuery.post( ajaxurl, data, function( respond ){
                var el = $(respond).hide().fadeIn('1500');
                var respond_length = el.find('.content_out').length;
                $container.append(el);
                $container.imagesLoaded(function(){
                    setTimeout(function() {
                        jQuery($container).find('.thumb').removeClass('hide-thumb');
                        jQuery('.ajax-load-btn').addClass('active');
                        $this.find('.ajax-load-btn').text(ajax_btn_str['loadmore']);
                        if(respond_length < entries){
                            $this.text(ajax_btn_str['nomore']);
                            $this.addClass('no-more');
                            $this.removeClass('active');
                        } 
                        $this.css("display", "inline-block");
                        $this.siblings('.loading-animation').css("display", "none");
                    }, 500);
                });
    
            });
        });
    });
})(jQuery);