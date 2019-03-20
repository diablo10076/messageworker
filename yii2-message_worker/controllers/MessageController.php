<?php

namespace app\controllers;

use app\models\MessageReceiver;
use app\models\helpers\ParseRequest;
use yii\web\Controller;


/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class MessageController extends Controller
{

    protected $data;
    public $datetime;
    public $messenger_id;
    public $id;
    public $message;

    public function actionCreate()
    {

        $this->data = $_REQUEST;
        $result = 0;
        $unsent = 0;

        if ($this->Parse()&&(count($this->messenger_id) === count($this->id))){
            for ($i = 0;$i<count($this->messenger_id);$i++) {
                $messageReceiver = new MessageReceiver($this->datetime, $this->messenger_id[$i], $this->id[$i], $this->message);
                if($messageReceiver->SendToDB()){
                    ++$result;
                }
                else{
                    ++$unsent;
                }
            }
            $str = "Successful transfer ".$result." records and not transfered to database ".$unsent." records";
            return $str;
        }
        else{
            return 'wrong set of parameters';
        }
    }

    public function Parse()
    {
        if (isset($this->data["datetime"])) {
            $this->datetime = $this->data["datetime"];
        }
        else {
            $this->datetime = null;
        }
        if (isset($this->data["messenger_id"])&&isset($this->data["id"])&&isset($this->data["message"])){
            $this->messenger_id = $this->data["messenger_id"];
            $this->id = $this->data["id"];
            $this->message = $this->data["message"];
            return true;
        }
        else{
            return false;
        }
    }

}
