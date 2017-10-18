<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Item;

class LineController extends Controller
{
    public function webHook(Request $request)
    {
        $data = json_decode($request->getContent());
        $chat_id = $data->events[0]->source->userId;
        $text = $data->events[0]->message->text;

        $parts = explode("_", $text);
        var_dump($parts);
        if (count($parts) > 0) {
            if ($parts[0] == "BELI" && count($parts) == 2) {
                $this->sendOrderInfo($chat_id, $parts[1]);
            } else if ($parts[0] == "LIHAT" && count($parts) == 2) {
                $this->sendItemInfo($chat_id, $parts[1]);
            } else {
                $error_data = array(
                    'to' => $chat_id,
                    'messages' => array(
                        array(
                            'type' => 'text',
                            'text' => "Perintah tidak valid. Perintah yang valid adalah LIHAT_<ID_BARANG> atau BELI_<ID_BARANG>",
                        )
                    ),
                );
                $this->sendMessage($error_data);
            }
        }
    }

    private function sendItemInfo($chat_id, $item_id)
    {
        $data = array(
            'to' => $chat_id,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => "",
                )
            )
        );

        try {
            $item = Item::findOrFail($item_id);
            $data['messages'][0]['text'] = "Info barang:\nNama: $item->name\nDeskripsi: $item->description\nHarga: Rp. $item->price\n";
            $data['messages'][0]['text'] .= "Silahkan balas dengan BELI_$item->id untuk membeli.";
            $this->sendMessage($data);
        } catch (ModelNotFoundException $e) {
            $data['messages'][0]['text'] = "Maaf, barang tidak ditemukan.";
            $this->sendMessage($data);
        }
    }

    private function sendOrderInfo($chat_id, $item_id)
    {
        $data = array(
            'to' => $chat_id,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => "",
                )
            )
        );

        try {
            $item = Item::findOrFail($item_id);
            $data['messages'][0]['text'] = "Terima kasih telah melakukan pembelian. Untuk pembayaran, silahkan transfer ke rekening berikut :\n";
            $data['messages'][0]['text'] .= "Bank ABC\nA/N Kardi\n1234509876\nsebesar Rp. $item->price";
            $this->sendMessage($data);
        } catch (ModelNotFoundException $e) {
            $data['messages'][0]['text'] = "Maaf, barang tidak ditemukan.";
            $this->sendMessage($data);
            return;
        }
    }

    private function sendMessage($data)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . "B7JSzXoH7dvAOv3ZUm3Py1QeK+mYL2OAKqN5IukRARlVx5VJk+JAMU3wtXP3yYVzFY/r5PhsqexO+BkyLYs+6SMOlNF+LNfo4FC1hgJdAQO38v2F9zMJPzelr8a8GWJCdD3OMsYN4h73XFnbf5saGgdB04t89/1O/w1cDnyilFU=",
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
