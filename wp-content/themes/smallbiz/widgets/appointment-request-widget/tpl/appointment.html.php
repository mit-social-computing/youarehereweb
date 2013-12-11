<?php
  require dirname(__FILE__).'/../recaptcha/loader.php';
  $recaptcha = new Recaptcha();
  if(isset($_POST['Form'])) {
	$captcha_status = $recaptcha->isValid();
  }
  
  if(isset($_POST['Form'])) {
    list($hour, $minutes) = explode(':', $_POST['Form']['Time']);
  } else {
     list($hour, $minutes) = explode(':', $_GET['time']);
  }
  $hour = intval($hour);
  $minutes = intval($minutes);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Appointment Details</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/css/wp-head.css">
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/js/jquery.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/js/wp-head.js"></script>
	<style type="text/css">

input[type=submit] {
  background-color: #21759B;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#2A95C5),to(#21759B));
  background-image: -webkit-linear-gradient(top,#2A95C5,#21759B);
  background-image: -moz-linear-gradient(top,#2A95C5,#21759B);
  background-image: -ms-linear-gradient(top,#2A95C5,#21759B);
  background-image: -o-linear-gradient(top,#2A95C5,#21759B);
  background-image: linear-gradient(to bottom,#2A95C5,#21759B);
  border-color: #21759B;
  border-bottom-color: #1E6A8D;
  -webkit-box-shadow: inset 0 1px 0 rgba(120, 200, 230, 0.5);
  box-shadow: inset 0 1px 0 rgba(120, 200, 230, 0.5);
  color: white;
  text-decoration: none;
  text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
  display: inline-block;
  text-decoration: none;
  font-size: 12px;
  line-height: 23px;
  height: 24px;
  margin: 0;
  padding: 0 10px 1px;
  cursor: pointer;
  border-width: 1px;
  border-style: solid;
  -webkit-border-radius: 3px;
  -webkit-appearance: none;
  border-radius: 3px;
  white-space: nowrap;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

input[type=text], input[type=email] {
  border: 1px solid #CCC;
  border-radius: 3px;
  padding: 2px 6px;
}

table td {
  vertical-align: top;
}

td.first {
  width: 200px;
  font-weight: bold;
  color: navy;
}

.form a {
  color: navy;
}

.required {
  color: red;
}

table.form {
  margin-bottom: 20px;
}

.recaptcha_error.error {
	font-weight: bold;
	color: red;
}

	</style>

<?php if(isset($captcha_status) && $captcha_status): ?>
<?php

  $msg = '';
  $_POST['Form']['Comments'] = mb_substr($_POST['Form']['Comments'], 0, 250);
  foreach($_POST['Form'] as $key => $val) {
    $msg .= '<p><b>'.$key.'</b>: '.$val.'</p>';
  }

  add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
  wp_mail(get_settings('admin_email'), 'Appointment Request', $msg);

?>
<script>
  $(window.top.document).find('#appointment_request_widget_footer_iframe').fadeOut(200, function(){
    alert('We will contact you as soon as possible');
  });
</script>
<?php endif; ?>

</head>
<body>
	
<?php if(isset($captcha_status) && !$captcha_status): ?>
  <span class="recaptcha_error error">Invalid captcha</span>
<?php endif; ?>
	
<form action="?<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>" class="appointment-request-widget" method="post">
	<table class="form">
		<tr>
			<td class="first">
				<span class="required">*</span>
				Name:
			</td>
			<td>
				<input type="text" name="Form[First-Name]" required <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['First-Name']).'"' : ''); ?>>
				<br>
				<i>First</i>
			</td>
			<td>
				<input type="text" name="Form[Last-Name]" required <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['Last-Name']).'"' : ''); ?>>
				<br>
				<i>Last</i>
			</td>
		</tr>
	</table>
	<table class="form">
		<tr>
			<td class="first">
				<span class="required">*</span>
				Phone:
			</td>
			<td>
				<input type="text" name="Form[Phone]" required <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['Phone']).'"' : ''); ?>>
				<br>
				<i>(555) 555-5555</i>
			</td>
		</tr>
	</table>
	<table class="form">
		<tr>
			<td class="first">
				<span class="required">*</span>
				Email:
			</td>
			<td>
				<input type="email"  name="Form[Email]" required <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['Email']).'"' : ''); ?>>
				<br>
				<i>xxx@xxxx.xxx</i>
			</td>
		</tr>
	</table>
	<hr>
	<table class="form">
	  <tr>
	    <td rowspan="3" class="first">
	      <span class="required">*</span>
	      Date:
	    </td>
	    <td>
	      <span>
		      <span class="datepicker">
			      <input type="text" readonly="readonly" name="Form[Date]" <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['Date']).'"' : 'value="'.$_GET['date'].'"'); ?>>
			      <img src="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/img/calendar.png" alt="calendar">
		      </span>
		    </span>
		    <div class="calendar"></div>
	    </td>
	    <td>
	      <span>
		      <span class="datepicker">
			      <input type="text" readonly="readonly" name="Form[Date2]" <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['Date2']).'"' : 'value="DD/MM/YYYY"'); ?>>
			      <img src="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/img/calendar.png" alt="calendar">
		      </span>
		    </span>
		    <div class="calendar"></div>
	    </td>
	    <td>
	      <span>
		      <span class="datepicker">
			      <input type="text" readonly="readonly" name="Form[Date3]" <?php echo (isset($_POST['Form']) ? 'value="'.htmlspecialchars($_POST['Form']['Date3']).'"' : 'value="DD/MM/YYYY"'); ?>>
			      <img src="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/img/calendar.png" alt="calendar">
		      </span>
		    </span>
		    <div class="calendar"></div>
	    </td>
	  </tr>
	  
	  <tr>
	    <td><i>Required</i></td>
	    <td><i>Optional</i></td>
	    <td><i>Optional</i></td>
	  </tr>
	  
	  <tr>
	    <td colspan="3" class="info">Appointments needs to be requested at least 1 day(s) in advance.</td>
	  </tr>
	  
	</table>
	
	<table class="form">
	  <tr>
	    <td class="first">
	      <span class="required">*</span>
	      Time:
	    </td>
	    <td>
	      <select name="Form[Time]">
			    <?php for($i=8; $i<=20; $i++): ?>
				    <option
				      value="<?php echo $i; ?>:00"
				      <?php echo ($hour == $i && $minutes == 0 ? 'selected="selected"' : ''); ?>
				    ><?php echo date('h:i A', strtotime($i.':00')); ?></option>
				    <option
				      value="<?php echo $i; ?>:00"
				      <?php echo ($hour == $i && $minutes == 30 ? 'selected="selected"' : ''); ?>
				    ><?php echo date('h:i A', strtotime($i.':30')); ?></option>
			    <?php endfor; ?>
		    </select>
	    </td>
	  </tr>
	</table>

	<table class="form">
	  <tr>
	    <td class="first">
	      Comments:
	    </td>
	  </tr>
	  <tr>
	    <td>
	      Additional questions or<br>comments related to your<br>appointment
	    </td>
	  </tr>
	  <tr>
	    <td>
	      <textarea cols="50" rows="10" maxlength="250" name="Form[Comments]"><?php echo (isset($_POST['Form']) ? htmlspecialchars($_POST['Form']['Comments']) : ''); ?></textarea>
	      <br>
	      <i>250 words maximum</i>
	    </td>
	  </tr>
	</table>

  <hr>
  
	<table class="form">
	  <tr>
	    <td class="first">
	      <span class="required">*</span>
	      Verification code:
	    </td>
	    <td colspan="2">
	    	<?php echo $recaptcha->display(); ?>
	    	<?php if(isset($captcha_status) && !$captcha_status): ?>
			  <span class="recaptcha_error error">Invalid captcha</span>
			<?php endif; ?>
	    </td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td colspan="2"><input type="submit" value="Submit"></td>
	  </tr>

	  <tr>
	    <td>&nbsp;</td>
	    <td colspan="2">
	      Please note that the date and time you requested may not be<br>
	      available. We will contact you to confirm your actual appointment<br>
	      details.
	    </td>
	  </tr>
	</table>

</form>


</body>
</html>
