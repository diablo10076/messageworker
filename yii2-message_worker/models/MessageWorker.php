<?php

namespace app\models;

use app\models\helpers\query_deferred;
use app\models\helpers\query_instant;

class MessageWorker
{
    public $datetime;
    public $id;
    public $message;


    public function continuingSend()
    {
        while (query_instant::find()->count()!== null) {
            $messages = query_instant::find()
                ->all();
            $count = count($messages);
            if ($count == 0) {
                continue;
            }
            $this->Send($count, $messages);
        }
    }

    public function defferedSend()
    {
        $pasttime = date('Y-m-d\ H:i:s', time() - 60);
        $futuretime = date('Y-m-d\ H:i:s', time() + 60);
        while ((count(query_deferred::find()
                ->where(['between', 'Date', $pasttime, $futuretime])
                ->all())) > 0) {
            $messages = (query_deferred::find()
                ->where(['between', 'Date', $pasttime, $futuretime])
                ->all());
            $count = count($messages);
            $this->Send($count, $messages);
        }
    }

    public function Send($count, $messages){
        for ($i = 0; $i < $count; $i++) {
            $messenger = new ExampleMessenger();
            if ($messages[$i]->Messenger_ID === 1){
                $result = $messenger->PrintMessage1($messages[$i]->ID, $messages[$i]->Message_body);
            }
            elseif ($messages[$i]->Messenger_ID[$i] === 2){
                $result = $messenger->PrintMessage2($messages[$i]->ID, $messages[$i]->Message_body);
            }
            else{
                echo 'wrong messenger ID';
                echo '/n';
                $result = true;
            }
            $attempts = $messages[$i]->Attempts;
            if ($result || ($attempts >= 10)) {
                $messages[$i]->delete();
            } elseif ($attempts < 10) {
                $messages[$i]->Attempts = ++$attempts;
            }
        }
    }


}
