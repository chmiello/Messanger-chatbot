<?php

namespace FBChatBot;

class VerifyToken
{
    private $configuration;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
    }

    public function getChallenge()
    {
        $challenge = null;
        $verifyToken = null;
        if (isset($_REQUEST['hub_challenge'])) {
            $challenge = $_REQUEST['hub_challenge'];
            $verifyToken = $_REQUEST['hub_verify_token'];
        }
        if ($verifyToken === $this->configuration['VeryfiToken']) {
            return $challenge;
        } else {
            return 'fail';
        }
    }
}