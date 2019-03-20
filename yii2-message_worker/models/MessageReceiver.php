<?php
/**
 * Created by PhpStorm.
 * User: Diablo
 * Date: 09.03.2019
 * Time: 17:35
 */

namespace app\models;
use app\models\helpers\query_deferred;
use app\models\helpers\query_instant;

class MessageReceiver
{
    protected $datetime;
    protected $messenger_id;
    protected $id;
    protected $message;



    public function SendToDB():bool{
        if ($this->datetime!==null){
            return $this->ReceiveDeffered();
        }
        else{
            return $this->ReceiveInstant();
        }
    }

    public function ReceiveDeffered():bool{
        $messages = new query_deferred();
        $messages->Date = $this->datetime;
        $messages->Messenger_ID = $this->messenger_id;
        $messages->ID = $this->id;
        $messages->Message_body = $this->message;
        $messages->Attempts = 1;
        return $messages->save();
    }

    public function ReceiveInstant():bool{
        $messages = new query_instant();
        $messages->Messenger_ID = $this->messenger_id;
        $messages->ID = $this->id;
        $messages->Message_body = $this->message;
        $messages->Attempts = 1;
        return $messages->save();
    }

    public function __construct(string $datetime = null,int $messenger_id,int $id,string $message)
    {
        $this->datetime = $datetime;
        $this->messenger_id = $messenger_id;
        $this->id = $id;
        $this->message = $message;
    }

}