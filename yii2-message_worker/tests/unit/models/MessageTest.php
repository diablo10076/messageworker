<?php

namespace app\tests\unit\models\commands;



class MessageTest extends \Codeception\Test\Unit
{



    public function testInstantReceive(){
        $command = 'wget "http://10.0.2.15:80/basic/web/index.php?r=message/create&id[0]=1&id[1]=2&message=asdasd&messenger_id[0]=1&messenger_id[1]=1"';
        exec($command);
        $dbh = new \PDO('mysql:host=localhost;dbname=Messages', 'root', '1');
        $count = $dbh->query('SELECT COUNT(*) from query_instant');
        $count = $count->fetchAll();
        $count = $count[0][0];
        $this->assertEquals(2,$count);
    }

    public function testDefferedReceive(){
        $command = 'wget "http://10.0.2.15:80/basic/web/index.php?r=message/create&id[0]=1&id[1]=2&message=asdasd&messenger_id[0]=1&messenger_id[1]=1&datetime='.date('Y-m-d\ H:i:s', time()).'"';
        exec($command);
        $dbh = new \PDO('mysql:host=localhost;dbname=Messages', 'root', '1');
        $count = $dbh->query('SELECT COUNT(*) from query_deferred');
        $count = $count->fetchAll();
        $count = $count[0][0];

        $this->assertEquals(2,$count);
    }

}