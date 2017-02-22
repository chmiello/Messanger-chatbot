<?php


namespace FBChatBot;

class Answer
{
    private $sender;
    private $orgMessage;
    private $answer;
    private $configuration;
    private $answerMessage;
    private $input;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
        $this->input = json_decode(file_get_contents('php://input'), true);
        if ($this->notEmptyMessage()) {
            $this->setSender($this->input['entry'][0]['messaging'][0]['sender']['id']);
            $this->setOrgMessage($this->input['entry'][0]['messaging'][0]['message']['text']);
            $this->prepareAnswer();
            $this->prepareJson();
        }
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function setOrgMessage($message)
    {
        $this->orgMessage = $message;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    public function prepareAnswer()
    {
        $this->answerMessage = 'It\'s work!!';
    }

    public function prepareJson()
    {
        $this->answer = '{
            "recipient":{   
                "id":"' . $this->sender . '"
            },
            "message":{
                "text":"' . $this->answerMessage . '"
            }
        }';
    }

    private function notEmptyMessage()
    {
        if (empty($this->input['entry'][0]['messaging'][0]['message'])) {
            return false;
        } else {
            return true;
        }
    }

    public function sendAnswer()
    {
        if ($this->notEmptyMessage()) {
            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $this->configuration['PageAccessToken'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->answer);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            return curl_exec($ch);
        }
        return null;
    }
}