<?php

interface CaptchaInterface
{
  function display(); // pobierz kod boksa z captchą
  function isSubmited(); // czy wysłano zapytanie z kodem
  function isValid(); // czy wpisano prawidłowy kod
}
