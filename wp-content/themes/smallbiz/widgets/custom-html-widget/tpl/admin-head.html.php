<script type="text/javascript">
(function($){

  $(window).load(function(){
    tinyMCE.init({
      language:"en",
      spellchecker_languages:"+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv",
      theme_advanced_resizing:true,
      theme_advanced_resize_horizontal:false,
      dialog_type:"modal",
      theme_advanced_toolbar_location:"top",
      theme_advanced_toolbar_align:"left",
      theme_advanced_statusbar_location:"bottom",
      document_base_url: "<?php echo home_url(); ?>/wp-includes/js/tinymce",
      theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|,bullist,numlist,|,link,unlink,|,sup,sub,code",
      theme_advanced_buttons2: "image,hr,indent,outdent,|,forecolor,backcolor,charmap,removeformat,|,undo,redo,|,help",
      theme:"advanced",
      skin:"wp_theme",
      //mode: "specific_textareas",
      mode: 'none',
      width: "100%",
      height: "500px",
      relative_urls : false,
      editor_css : '<?php echo get_bloginfo('template_directory'); ?>/widgets/custom-html-widget/css/tinymce.css',
      //editor_selector: id
    });
  });

  var displayTinyMCE = function(id) {
    removeTinyMCE(id);

    if(!tinyMCE.getInstanceById(id)) {
      try {
        var el = $('#id');
        el.css('visibility', 'hidden');
        setTimeout(function(){
          //console.log('done');
          tinyMCE.execCommand('mceAddControl', true, id);
          el.css('visibility', 'visible');
        }, 1);
      } catch(ex) {
      }
    }
  };

  window.programistaItDisplayTinyMce = displayTinyMCE;

  var removeTinyMCE = function(id) {
    //console.log('remove');
    if(tinyMCE.getInstanceById(id)) {
        try {
          //console.log($('#' + id)[0]);
          tinyMCE.execCommand('mceFocus', false, id);

          tinyMCE.execCommand('mceRemoveControl', true, id);
          //tinyMCE.remove(tinyMCE.getInstanceById(id));

        } catch(ex) {
          tinymce.remove(tinyMCE.getInstanceById(id));
          console.log(ex);
      }
    }
  };

  var animateWidget = function(widget) {
    if(widget.parent().attr('id') != 'wp_inactive_widgets') {
      widget.css('position', 'relative');
      widget.animate({width: '600px', "margin-left": '-335px'});
    } else {
      widget.css('width', '600px');
    }
  };

    $(function(){
        $('.widget').each(function(k,v){
            v = $(v);
            if(v.attr('id').match(/^widget-[0-9]+_<?php echo $this->widget_id; ?>/)) {
                var title = v.find('.widget-top .widget-title');
                title.addClass('picture_widget_title').addClass('custom_html_widget');
                title.prepend('<img class="picture_widget_icon" src="<?php bloginfo('template_url'); ?>/widgets/<?php echo $this->directory; ?>/img/icon.png">');
            }
        });

    /**
     * fix adding widgets etc
     */
    var clicked = false;

    var mouseDown = function(e){
      //if(e.which != 3) {
        var $this = $(this);
        var parent_id = $(this).parent().parent().attr('id');
        if(!parent_id.match(/widget-[0-9]+_custom_html_widget-__i__/)) {
          clicked = true;
        }
      //}
    };

    $('.custom_html_widget').live('mousedown', mouseDown);
    $('.custom_html_widget').live('touchstart', mouseDown);

    var mouseUp = function(){
          if(clicked) {
            var $this = $(this);
            var widget = $this.parent().parent();
            try {
              var display = widget.find('.widget-inside').css('display');
              if(display == 'none') {
            displayTinyMCE(widget.find('textarea').attr('id'));
            if(clicked && widget.css('position') != 'absolute') {
              animateWidget(widget);
            }
              } else {
                removeTinyMCE(widget.find('textarea').attr('id'));
              }
            } catch(ex) {}
            clicked = false;
            moved = false;
          } else {
            var placeholder = $('.widget-placeholder');
            if(placeholder.length > 0) {
              var parent = placeholder.parent();
              var widgets_count = parent.find('.widget').length;
          var position = placeholder.prevAll().length;
          if(widgets_count == 1) {
            position--;
          }
          setTimeout(function(){
            if(parent.attr('id') == 'wp_inactive_widgets') {
              position--;
            }
            var widget = $(parent.find('.widget')[position]);
            displayTinyMCE(widget.find('textarea').attr('id'));
            animateWidget(widget);
          }, 200);
            }
          }
        };
        $('.custom_html_widget').live('mouseup', mouseUp);
        $('.custom_html_widget').live('touchend', mouseUp);

        // update textarea content
        var updateTinyMCETextarea = function(){
          var parent = $(this).parent().parent().parent();
          if(parent.find('.programista_it_tinymce_widget_hidden').length > 0) {
            var textarea_id = parent.find('textarea').attr('id');
            //tinyMCE.updateContent(textarea_id);
            var content = $('#' + textarea_id + '_ifr').contents().find('#tinymce').html();
            var textarea = $('#' + textarea_id);
            textarea.val(content);
          }
        };
        $('.widget-control-actions').live('mouseenter', updateTinyMCETextarea);
        $('.widget-control-save').live('focus', updateTinyMCETextarea);


    // upload media
    var sender = null;
    var uploadMediaEvt = function(){
          sender = $(this);
          tb_show('Select image', 'media-upload.php?referer=widget-custom-html-programista-it&type=image&TB_iframe=true&post_id=0', false);
        };
        $('.programista-it-custom-html-media-button a').live('focus', uploadMediaEvt);
        $('.programista-it-custom-html-media-button a').live('click', uploadMediaEvt);

    var old_fn = window.send_to_editor;
    window.send_to_editor = function(html) {
      if(sender) {
        var caption = html.match(/\[caption([^\]]+)\]([^\[]+)\[\/caption\]/);
        if(caption) {
          var width = caption[1].match(/width="([^"]+)"/);
          var align = caption[1].match(/align="([^"]+)"/);
          html =  '<div class="caption ' + align[1] + '" style="width: ' + width[1] + 'px">' + caption[2].replace('</a>', '</a><br>') + '</div>';
        }
        tinyMCE.get(sender.parent().parent().find('textarea').attr('id')).execCommand('mceInsertContent', false, html);
          sender = null;
          tb_remove();
          return true;
       } else if(old_fn) {
          old_fn(html);
        }
    }
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

.programista-it-custom-html-media-button {
  text-align: right;
  margin-bottom: 15px;
}

.programista-it-tinymce-container .wp_themeSkin table.mceToolbar,
.programista-it-tinymce-container .wp_themeSkin tr.mceFirst .mceToolbar tr td,
.programista-it-tinymce-container .wp_themeSkin tr.mceLast .mceToolbar tr td {
  background: none;
}
.programista-it-custom-html-media-button .wp-media-buttons-icon {
  background: url('<?php echo admin_url(); ?>images/media-button.png') no-repeat top left;
  display: inline-block;
  width: 16px;
  height: 16px;
  vertical-align: text-top;
  margin: 0 2px;
}
</style>