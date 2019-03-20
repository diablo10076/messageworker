<?php

namespace app\commands;


use yii\console\Controller;
use app\models\MessageWorker;

class InternalCommandsController1 extends Controller
{
    public function actionSendC(){
        $messageSend = new MessageWorker();
        $messageSend->continuingSend();
    }
    public function actionSendD(){
        $messageSend = new MessageWorker();
        $messageSend->defferedSend();
    }
}