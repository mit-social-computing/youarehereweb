<style type="text/css">
	#custom_sidebar_area {
		border-collapse: collapse;
	}
	#custom_sidebar_area td, #custom_sidebar_area th {
		border: 1px solid #eee;
		padding: 6px 12px;
	}
</style>

<div class="wrap">
	<div id="icon-themes" class="icon32">
		<br>
	</div><h2>SmallBiz Custom Widget Areas</h2>

	<h3 style="margin-top: 40px;">Create custom page template with dedicated sidebar for widgets.</h3>

	<form action="themes.php?page=custom-sidebars-panel" method="post">
		<fieldset style="margin: 20px 0; border: 1px solid #eee; border-radius: 5px; padding: 20px;">
			<p>
				<label for="i-custom-widget-area-name">Custom widget area name:</label>
				<input id="i-custom-widget-area-name" type="text" pattern="[a-zA-Z0-9 ]+" required name="CustomSidebar[Name]">
				<i>Only letters, numbers and spacebars</i>
			</p>
			<p class="submit">
				<input type="submit" id="save-background-options" class="button button-primary" value="Add new">
			</p>
		</fieldset>
	</form>

	<h3 style="margin-top: 60px;">Your custom widget areas:</h3>

	<?php if(count($this->getSidebars()) == 0): ?>
		You do not have any custom widget areas.
	<?php else: ?>
		<table id="custom_sidebar_area">
			<tr>
				<th>Custom widget area name:</th>
				<th>Sidebar name:</th>
				<th>Page template name:</th>
				<th>&nbsp;</th>
			</tr>
			<?php foreach($this->getSidebars() as $id => $sidebar): ?>
				<tr>
					<td><?php echo $sidebar; ?></td>
					<td>Custom Sidebar - <?php echo $sidebar; ?></td>
					<td>Custom Template - <?php echo $sidebar; ?></td>
					<td><a href="javascript:" onclick="if(confirm('Remove widget area: <?php echo $sidebar; ?>?'))window.location.href='themes.php?page=custom-sidebars-panel&amp;remove-area=<?php echo $id; ?>';">Remove this area</a></td>
				</tr>
			<?php endforeach; ?>
		</table>
		
		<div style="margin-top: 60px;">
			<p>
				To use new created page template, please go to <a href="edit.php?post_type=page">Page</a> and select it from Page Template menu.
			</p>
			<p>
				To add widgets to the new page template sidebar, please go to <a href="widgets.php">Widgets</a> and move widgets to the new created sidebar.
			</p>
		</div>
	<?php endif; ?>

	<br class="clear">
</div>