<script type="text/javascript">
(function($){
    $(function(){
        $('.widget').each(function(k,v){
            v = $(v);
            if(v.attr('id').match(/^widget-[0-9]+_<?php echo $this->widget_id; ?>/)) {
                var title = v.find('.widget-top .widget-title');
                title.addClass('picture_widget_title');
                title.prepend('<img class="picture_widget_icon" src="<?php bloginfo('template_url'); ?>/widgets/blog-style-recent-posts/img/icon.png">');
            }
        })
    });
})(jQuery);
</script>
<style type="text/css">

.picture_widget_title {
    position: relative;
    padding-left: 27px !important;
}

.picture_widget_icon {
    width: 20px;
    height: 20px;
    position: absolute;
    top: 3px;
    left: 2px;
}
</style>