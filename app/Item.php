<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function publishToFacebook($request)
    {

    }

    public function publishToLine($request)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . "B7JSzXoH7dvAOv3ZUm3Py1QeK+mYL2OAKqN5IukRARlVx5VJk+JAMU3wtXP3yYVzFY/r5PhsqexO+BkyLYs+6SMOlNF+LNfo4FC1hgJdAQO38v2F9zMJPzelr8a8GWJCdD3OMsYN4h73XFnbf5saGgdB04t89/1O/w1cDnyilFU=",
            'User-Agent: curl',
        );

        $data = array(
            'to' => 'Uf8374a4fc2a70b7d4b114843159bd9a7',
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Name: ' . $this->name . '\nDescription: ' . $this->description . '\nPrice: ' . $this->price,
                )
            )
        );

        $json = str_replace("\\\\n", "\\n", json_encode($data));

        $curl = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        $status = curl_exec($curl);

        echo "ORIG = " . json_encode($data) . "<br>";
        echo "JSON = $json<br>";
        echo "Status = $status";
    }

    public function publishToTelegram($request)
    {
        $header = array(
            'Content-Type: application/json',
        );

        $data = array(
            'chat_id' => 469548770,
            'text' => $this->name . '\n' . $this->description,
        );

        $json = str_replace("\\\\n", "\\n", json_encode($data));

        $curl = curl_init("https://api.telegram.org/bot371851158:AAFdH3wPS-nN10_18R1HdX2gCAPZZ30SV1Y/sendMessage");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_exec($curl);
    }
}
