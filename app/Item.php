<?php

namespace App;

use Facebook\Facebook;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function publishToFacebook($request)
    {
        $data = array(
            'link' => "https://kardi-test.herokuapp.com/product/$this->id",
            'message' => "New item!"
        );
        $fb = new Facebook([
            'app_id' => config('facebook.config.app_id'),
            'app_secret' => config('facebook.config.app_secret'),
            'default_graph_version' => config('facebook.config.default_graph_version')
        ]);
        $pageAccessToken = config('facebook.config.page_access_token');
        $fb->post('/1949768102013883/feed', $data, $pageAccessToken);
    }

    public function publishToLine($request)
    {
        $friends = Linefriend::orderBy('created_at', 'asc')->get();

        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . "B7JSzXoH7dvAOv3ZUm3Py1QeK+mYL2OAKqN5IukRARlVx5VJk+JAMU3wtXP3yYVzFY/r5PhsqexO+BkyLYs+6SMOlNF+LNfo4FC1hgJdAQO38v2F9zMJPzelr8a8GWJCdD3OMsYN4h73XFnbf5saGgdB04t89/1O/w1cDnyilFU=",
            'User-Agent: curl',
        );

        $sent = 0;
        for ($i = count($friends) / 150; $i >= 0; $i--) {
            $temp = Linefriend::orderBy('created_at', 'asc')->skip($sent)->take(150)->get();
            if (count($temp) == 0) return;
            $sent += count($temp);
            $ids = array_map(function ($user) {
                return $user->friend_id;
            }, $temp);

            $data = array(
                'to' => $ids,
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
            curl_exec($curl);
        }
    }

    public function publishToTelegram($request)
    {
        $header = array(
            'Content-Type: application/json',
        );

        $friends = Telegramfriend::orderBy('created_at', 'asc')->get();
        foreach ($friends as $friend) {
            $data = array(
                'chat_id' => $friend->friend_id,
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
}
