<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class TelegramController extends Controller
{
    public function __construct() {
        $this->token = \Config::get('services.telegram-bot-token');
    }

    // NOTIFICACIONES TELEGRAM
    // Mensaje Simple
    public function sendText($chat_id, $payload){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$this->token.'/sendMessage?chat_id='.$chat_id.'&parse_mode=HTML&link_preview_options[is_disabled]=true'.'&text='.$payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    // Documentos Adjuntos
    public function sendDocument($chat_id, $ruta){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$this->token.'/sendDocument',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $chat_id,
                'document'=> new \CURLFILE($ruta,mime_content_type($ruta))
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    // Panel Mensajeria ESTATUS
    public function mensajeriaTelegram(){

        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $res = $client->request('GET', 'https://api.telegram.org/bot7251630970:AAFvn3K2be2mFh-bi_i-o5PAUk1E1rgZA28/getMe', $headers);
        $resultado = response()->json(['type'=> true, 'message' => 'informacion obtenida exitosamente!', 'informacion' => json_decode($res->getBody())]);

        // Comprobación del estatus del bot
        // echo $resultado;

        return view('Panel.mensajeriatelegram',compact('res'));
    }
}
