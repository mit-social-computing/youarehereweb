<script type="text/javascript">

/*! jQuery JSON plugin 2.4.0 | code.google.com/p/jquery-json */
(function($){'use strict';var escape=/["\\\x00-\x1f\x7f-\x9f]/g,meta={'\b':'\\b','\t':'\\t','\n':'\\n','\f':'\\f','\r':'\\r','"':'\\"','\\':'\\\\'},hasOwn=Object.prototype.hasOwnProperty;$.toJSON=typeof JSON==='object'&&JSON.stringify?JSON.stringify:function(o){if(o===null){return'null';}
var pairs,k,name,val,type=$.type(o);if(type==='undefined'){return undefined;}
if(type==='number'||type==='boolean'){return String(o);}
if(type==='string'){return $.quoteString(o);}
if(typeof o.toJSON==='function'){return $.toJSON(o.toJSON());}
if(type==='date'){var month=o.getUTCMonth()+1,day=o.getUTCDate(),year=o.getUTCFullYear(),hours=o.getUTCHours(),minutes=o.getUTCMinutes(),seconds=o.getUTCSeconds(),milli=o.getUTCMilliseconds();if(month<10){month='0'+month;}
if(day<10){day='0'+day;}
if(hours<10){hours='0'+hours;}
if(minutes<10){minutes='0'+minutes;}
if(seconds<10){seconds='0'+seconds;}
if(milli<100){milli='0'+milli;}
if(milli<10){milli='0'+milli;}
return'"'+year+'-'+month+'-'+day+'T'+
hours+':'+minutes+':'+seconds+'.'+milli+'Z"';}
pairs=[];if($.isArray(o)){for(k=0;k<o.length;k++){pairs.push($.toJSON(o[k])||'null');}
return'['+pairs.join(',')+']';}
if(typeof o==='object'){for(k in o){if(hasOwn.call(o,k)){type=typeof k;if(type==='number'){name='"'+k+'"';}else if(type==='string'){name=$.quoteString(k);}else{continue;}
type=typeof o[k];if(type!=='function'&&type!=='undefined'){val=$.toJSON(o[k]);pairs.push(name+':'+val);}}}
return'{'+pairs.join(',')+'}';}};$.evalJSON=typeof JSON==='object'&&JSON.parse?JSON.parse:function(str){return eval('('+str+')');};$.secureEvalJSON=typeof JSON==='object'&&JSON.parse?JSON.parse:function(str){var filtered=str.replace(/\\["\\\/bfnrtu]/g,'@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,']').replace(/(?:^|:|,)(?:\s*\[)+/g,'');if(/^[\],:{}\s]*$/.test(filtered)){return eval('('+str+')');}
throw new SyntaxError('Error parsing JSON, source is not valid.');};$.quoteString=function(str){if(str.match(escape)){return'"'+str.replace(escape,function(a){var c=meta[a];if(typeof c==='string'){return c;}
c=a.charCodeAt();return'\\u00'+Math.floor(c/16).toString(16)+(c%16).toString(16);})+'"';}
return'"'+str+'"';};}(jQuery));

(function($){
    $(function(){
        $('.widget').each(function(k,v){
            v = $(v);
            if(v.attr('id').match(/^widget-[0-9]+_<?php echo $this->widget_id; ?>/)) {
                var title = v.find('.widget-top .widget-title');
                title.addClass('picture_widget_title');
                title.prepend('<img class="picture_widget_icon" src="<?php bloginfo('template_url'); ?>/widgets/nivo-slider/img/icon.png">');
            }
        })
        
        $('.programista-it-nivo-add-image').live('click', function(){
        	var $this = $(this);
        	var nivo_images = $this.parent().parent().find('.widget-nivo-images');
			var img_count = nivo_images.find('.image_box').length;
        	var nr = img_count + 1;
        	
        	var sidebar = $this.parent().parent().parent().parent().parent();
        	var sid = sidebar.attr('id');
        	
        	nivo_images.append(
        		'<div class="image_box programista-it-image-box">' +
        			'<h3>Image ' + nr  + '</h3>' +
        			'<p>' +
        				'<label for="' + sid + '-programista-it-image-url-' + nr + '">Image URL:</label>' +
        				'<input id="' + sid + '-programista-it-image-url-' + nr + '" type="text" class="widefat nivo-url">' +
        			'</p>' +
        			'<div class="nivo-preview"></div>' +
        			'<p>' +
        				'<label for="' + sid + '-programista-it-image-href-' + nr + '">Optional: Link image to the following page:</label>' +
        				'<input id="' + sid + '-programista-it-image-href-' + nr + '" type="text" class="widefat nivo-href">' +
        			'</p>' +
        			'<p>' +
        				'<label for="' + sid + '-programista-it-image-caption-' + nr + '">Optional: Add an image caption:</label>' +
        				'<input id="' + sid + '-programista-it-image-caption-' + nr + '" type="text" class="widefat nivo-caption">' +
        			'</p>' +
        			'<p><input type="button" class="button button-primary programista-it-nivo-remove-image" value="Remove image"></p>' +
        		'</div>'
        	);
        });
        
        $('.programista-it-nivo-remove-image').live('click', function(){
        	var form = $(this).parent().parent().parent().parent().parent();
        	$(this).parent().parent().remove();
        	$('.programista-it-image-box h3').each(function(k,v){
        		$(v).html('Image ' + (k+1));
        	});
        	generateJSON(form);
        });
        
        var senderInput = null;
        $('.programista-it-image-box .nivo-url').live('focus', function(){
        	senderInput = $(this);
        	tb_show('Select image for the slider', 'media-upload.php?referer=widget-nivo-slider&type=image&TB_iframe=true&post_id=0', false); 
        });
        
		var old_fn = window.send_to_editor;
		window.send_to_editor = function(html) {
			if(senderInput) { 
			    var image_url = $('img','<div>' + html + '</div>').attr('src');  
			    senderInput.val(image_url);
			    if(image_url != '' && image_url) {
			    	senderInput.parent().parent().find('.nivo-preview').html('<img src="' + image_url + '" style="max-width: 100%; margin: 20px 0">');
			    } else {
			    	senderInput.parent().parent().find('.nivo-preview').html('');
			    }
			    generateJSON(senderInput.parent().parent().parent().parent());
			    senderInput = null;
			    tb_remove();
		    }
		    if(old_fn) {
		    	old_fn(html);
		    }
		}
        
        var generateJSON = function(form) {
        	var save = form.find('.widget-control-save');
        	
        	save.attr('disabled', true);
        	
        	var records = [];
        	form.find('.programista-it-image-box').each(function(k,v){
        		v = $(v);
        		records.push({
        			url: $.trim(v.find('.nivo-url').val()),
        			href: $.trim(v.find('.nivo-href').val()),
        			caption: $.trim(v.find('.nivo-caption').val())
        		});
        	});
        	
        	form.find('.nivo-images').val($.toJSON(records));
        	
        	save.removeAttr('disabled');
        };
        
        $('.programista-it-image-box').live('mouseleave', function(){
        	generateJSON($(this).parent().parent().parent().parent());
        });
    });
})(jQuery);
</script>
<style type="text/css">

.programista-it-image-box {
	margin: 20px 0;
	border: 1px solid #ccc;
	border-radius: 5px;
	padding: 0 10px;
}

.programista-it-image-box .nivo-url {
	cursor: pointer;
}
</style>
