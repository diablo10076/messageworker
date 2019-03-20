<?php

namespace app\models;


class ExampleMessenger
{
    public function PrintMessage1(int $id,string $message):bool{
        print_r($id);
        echo ' ';
        print_r($message);
        echo "\n";
        return true;
    }

    public function PrintMessage2(int $id,string $message):bool{
        print_r($id);
        echo ' ';
        print_r($message);
        echo "\n";
        return true;
    }

}