<?php

if (!function_exists('getRandomAyah')) {
    function getRandomAyah()
    {
        try {
            $arabicResponse = file_get_contents('https://api.alquran.cloud/v1/ayah/random');
            $arabicData = json_decode($arabicResponse, true);

            if (!isset($arabicData['data'])) {
                return null;
            }

            $translationResponse = file_get_contents('https://api.alquran.cloud/v1/ayah/' . $arabicData['data']['number'] . '/editions/id.indonesian');
            $translationData = json_decode($translationResponse, true);

            if (!isset($translationData['data'][0]['text'])) {
                return null;
            }

            return [
                'arabic' => $arabicData['data']['text'],
                'translation' => $translationData['data'][0]['text'],
                'surah' => $arabicData['data']['surah']['name'],
                'ayah_number' => $arabicData['data']['numberInSurah'],
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
