<?php

class Recaptcha implements CaptchaInterface
{
  private $publickey  = '6Lc_cb4SAAAAACCwsOacHy0V5xb7dS-VqzoGJ8_v'; // doggy.lc
  private $privatekey = '6Lc_cb4SAAAAAPdIgZVVwitlH2EG6DbovSPa54O9'; // doggy.lc

  function __costruct($publickey = null,$privatekey = null) {
    if($publickey) {
      $this->publickey = $publickey;
    }
    if($privatekey) {
      $this->privatekey = $privatekey;
    }
  }

  function display()
  {
    return recaptcha_get_html($this->publickey, $this->privatekey);
  }

  function isSubmited()
  {
    return isset($_POST["recaptcha_response_field"]) ? true : false;
  }

  function isValid()
  {
    if($this->isSubmited())
    {
      $result = recaptcha_check_answer(
        $this->privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]
      );
      return $result->is_valid;
    }
    return false;
  }

  function template($template = 'default') {
    return;
?>
    <script type="text/javascript">
    var RecaptchaOptions = {
      <?php if($template != 'default'): ?>
        theme : '<?php echo $template; ?>',
      <?php endif; ?>
      custom_translations : {
        visual_challenge : "Zadanie graficzne", 
        audio_challenge : "Zadanie dźwiękowe", 
        refresh_btn : "Wylosuj ponownie nowy zestaw znaków", 
        instructions_visual : "Wpisz znaki z obrazka:", 
        instructions_audio : "Wpisz osiem liczb:", 
        help_btn : "Pomoc", 
        play_again : "Odtwórz dźwięk ponownie", 
        cant_hear_this : "Pobierz dźwięk jako MP3", 
        incorrect_try_again : "Źle. Spróbuj ponownie."
      }
    };
    </script>
<?php
  }
}
