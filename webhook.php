<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require "app/VerifyToken.php";
require "app/Answer.php";

$conifg = include "app/settings.php";


use \FBChatBot\VerifyToken as Token;
use \FBChatBot\Answer as Answer;

$debug = var_export($_REQUEST, true);

$token = new Token($conifg);
$challenge = $token->getChallenge();
echo $challenge;

$answer = new Answer($conifg);
$answer->sendAnswer();