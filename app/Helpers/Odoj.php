<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('getRandomAyah')) {
    function getRandomAyah()
    {
        try {
            // Ambil ayat acak dalam bahasa Arab
            $arabicResponse = file_get_contents('https://api.alquran.cloud/v1/ayah/random');
            $arabicData = json_decode($arabicResponse, true);

            if (!isset($arabicData['data'])) {
                Log::error('Data ayat acak tidak ditemukan.', ['response' => $arabicData]);
                return null;
            }

            // Ambil terjemahan dalam bahasa Indonesia
            $translationResponse = file_get_contents('https://api.alquran.cloud/v1/ayah/' . $arabicData['data']['number'] . '/editions/id.indonesian');
            $translationData = json_decode($translationResponse, true);

            if (!isset($translationData['data'][0]['text'])) {
                Log::error('Terjemahan ayat tidak ditemukan.', ['response' => $translationData]);
                return null;
            }

            return [
                'arabic' => $arabicData['data']['text'],
                'translation' => $translationData['data'][0]['text'],
                'surah' => $arabicData['data']['surah']['name'],
                'ayah_number' => $arabicData['data']['numberInSurah'],
            ];
        } catch (\Exception $e) {
            // Catat error ke log Laravel
            Log::error('Gagal mengambil ayat acak.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }
}
