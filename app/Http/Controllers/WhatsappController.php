<?php

namespace App\Http\Controllers;

class WhatsappController extends Controller
{
    public $token;

    public function __construct()
    {
        $this->token = env('WHATSAPP_TOKEN');
        // $this->token = 'j5wY1LmXSwkbnLwRfTcY';
    }

    public function sendNotification($message, $number)
    {
        // Siapkan data
        // 'target' => bisa multiple (dipisah koma). Di sini satu nomor
        // 'message' => isi pesan. Contoh menambahkan judul artikel dan link approval.
        // Boleh memakai placeholder {name} dsb. tapi di sini kita pakai teks biasa.
        $postFields = [
            'target'   => $number,
            'message'  => $message,
            'delay'    => '1-3', // random 1-3 detik
            'countryCode' => '62',
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postFields,
            CURLOPT_HTTPHEADER     => [
                "Authorization: $this->token",
            ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            // Bisa log error atau menampilkan flash message
            return "Error: $error_msg";
        }

        return $response; // Atau redirect / flash message
    }
}
