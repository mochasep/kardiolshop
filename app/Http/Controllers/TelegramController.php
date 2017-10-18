<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Item;

class TelegramController extends Controller
{
    public function webHook(Request $request)
    {
        $data = json_decode($request->getContent());
        $chat_id = $data->message->chat->id;
        $text = $data->message->text;

        $parts = explode("_", $text);
        var_dump($parts);
        if (count($parts) > 0) {
            if ($parts[0] == "BELI" && count($parts) == 2) {
                $this->sendOrderInfo($chat_id, $parts[1]);
            } else if ($parts[0] == "LIHAT" && count($parts) == 2) {
                $this->sendItemInfo($chat_id, $parts[1]);
            } else {
                $error_data = array(
                    'chat_id' => $chat_id,
                    'text' => "Perintah tidak valid. Perintah yang valid adalah LIHAT_<ID_BARANG> atau BELI_<ID_BARANG>",
                );
                $this->sendMessage($error_data);
            }
        }
    }

    // Sent whenever buyer asks for item information
    private function sendItemInfo($chat_id, $item_id)
    {
        $data = array(
            'chat_id' => $chat_id,
        );

        try {
            $item = Item::findOrFail($item_id);
            $data['text'] = "Info barang:\nNama: $item->name\nDeskripsi: $item->description\nHarga: Rp. $item->price\n";
            $data['text'] .= "Silahkan balas dengan BELI_$item->id untuk membeli.";
            $this->sendMessage($data);
        } catch (ModelNotFoundException $e) {
            $data['text'] = "Maaf, barang tidak ditemukan.";
            $this->sendMessage($data);
        }
    }

    // Sent whenever buyer buys an item
    private function sendOrderInfo($chat_id, $item_id)
    {
        $data = array(
            'chat_id' => $chat_id,
        );

        try {
            $item = Item::findOrFail($item_id);
            $data['text'] = "Terima kasih telah melakukan pembelian. Untuk pembayaran, silahkan transfer ke rekening berikut :\n";
            $data['text'] .= "Bank ABC\nA/N Kardi\n1234509876\nsebesar Rp. $item->price";
            $this->sendMessage($data);
        } catch (ModelNotFoundException $e) {
            $data['text'] = "Maaf, barang tidak ditemukan.";
            $this->sendMessage($data);
            return;
        }
    }

    private function sendMessage($data)
    {
        $header = array(
            'Content-Type: application/json',
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
