<?php
$options = get_option('uppsite_options');
$fb_comments_counter = 0;
if (isset($options['fbcomment'])){
		$comments_xml = mysiteapp_print_facebook_comments($fb_comments_counter);
}
if ($comments || $fb_comments_counter > 0) : ?>
	<comments comment_total="<?php echo (count($comments)+$fb_comments_counter)?>">
		<?php print !empty($comments_xml) ? $comments_xml : null; ?>
		<?php foreach ($comments as $comment) : ?>
	    <comment ID="<?php comment_ID() ?>" post_ID="<?php the_ID(); ?>" isApproved="<?php echo $comment->comment_approved == '0' ? "false" : "true" ?>">
			<permalink><![CDATA[<?php the_permalink() ?>]]></permalink>
			<time><![CDATA[<?php comment_date() ?>]]></time>
			<unix_time><![CDATA[<?php comment_date('U'); ?>]]></unix_time>
			<?php mysiteapp_get_member_for_comment(); ?>
			<text><![CDATA[<?php comment_text() ?>]]></text>
        </comment>
		<?php endforeach; ?>
	</comments>
<?php endif; ?>
<newcommentfields>
	<?php mysiteapp_comment_form(); ?>
</newcommentfields>
