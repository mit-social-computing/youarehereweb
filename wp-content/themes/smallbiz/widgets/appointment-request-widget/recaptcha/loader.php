<?php

$path = dirname(__FILE__).'/';
foreach(array('interface/captcha','class/recaptcha','lib/recaptcha-php-1.11/recaptchalib') as $lib)
{
  require_once $path.$lib.'.php';
}
unset($lib,$path);
