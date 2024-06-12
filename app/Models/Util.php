<?php

namespace App\Models;
use Exception;
use App\Exceptions\ClientExceptionHandler;
use League\Csv\Reader;

class Util
{
    //Distance de levenshtein
    public static function levenshteinDistance($str1, $str2) {
        $m = mb_strlen($str1);
        $n = mb_strlen($str2);
        $dp = [];
    
        for ($i = 0; $i <= $m; $i++) {
            $dp[$i][0] = $i;
        }
    
        for ($j = 0; $j <= $n; $j++) {
            $dp[0][$j] = $j;
        }
    
        for ($i = 1; $i <= $m; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                $cost = $str1[$i - 1] !== $str2[$j - 1];
                $dp[$i][$j] = min(
                    $dp[$i - 1][$j] + 1,
                    $dp[$i][$j - 1] + 1,
                    $dp[$i - 1][$j - 1] + $cost
                );
            }
        }
    
        return $dp[$m][$n];
    }
         
    //Distance de damerau levenshtein
    public static function damerauLevenshteinDistance($str1, $str2) {
        $m = mb_strlen($str1);
        $n = mb_strlen($str2);
        $dp = [];
    
        for ($i = 0; $i <= $m; $i++) {
            $dp[$i][0] = $i;
        }
    
        for ($j = 0; $j <= $n; $j++) {
            $dp[0][$j] = $j;
        }
    
        for ($i = 1; $i <= $m; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                $cost = $str1[$i - 1] !== $str2[$j - 1];
                $dp[$i][$j] = min(
                    $dp[$i - 1][$j] + 1,
                    $dp[$i][$j - 1] + 1,
                    $dp[$i - 1][$j - 1] + $cost
                );
    
                if ($i > 1 && $j > 1 && $str1[$i - 1] === $str2[$j - 2] && $str1[$i - 2] === $str2[$j - 1]) {
                    $dp[$i][$j] = min($dp[$i][$j], $dp[$i - 2][$j - 2] + $cost);
                }
            }
        }
    
        return $dp[$m][$n];
    }    

    //Recuperer les donnees du fichier csv
    public static function getCsv() {
        $emplacement = 'app/public/frequence.csv';
        $path = storage_path($emplacement); // Chemin vers le fichier CSV
        
        $csv = Reader::createFromPath($path, 'r');
        $csv->setDelimiter(';'); // Définir le délimiteur approprié pour votre fichier CSV

        $records = $csv->getRecords(); // Récupérer les enregistrements (lignes) du fichier CSV

        return $records;
    }

    //Trouver les mots similaires
    public static function findSimilarWords($inputWord) {
        $datasCsv = Util::getCsv(); //Recuperation des donnees csv
        $threshold = 1; // Seuil de distance
        $similarWords = [];
    

        foreach ($datasCsv as $row) {
            $word = $row[2];
            $distance = Util::damerauLevenshteinDistance($inputWord, $word);

            if ($distance <= $threshold) {
                $similarWords[] = [
                    'word' => $word,
                    'distance' => $distance,
                ];
            }
        }
    
        // Trier les mots similaires en ordre croissant de distance
        usort($similarWords, function ($a, $b) {
            return $a['distance'] - $b['distance'];
        });

        return $similarWords;
    }

///Encryptage
    // Chiffrement AES
    public static function encryptAES($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        $encryptedData = base64_encode($iv . $encrypted);

        return $encryptedData;
    }

    // Déchiffrement AES
    public static function decryptAES($encryptedData, $key)
    {
        $data = base64_decode($encryptedData);
        $ivSize = openssl_cipher_iv_length('aes-256-cbc');

        // Vérifiez la taille correcte de l'IV
        if (strlen($data) < $ivSize) {
            throw new Exception("Données chiffrées invalides.");
        }

        $iv = substr($data, 0, $ivSize);
        $encrypted = substr($data, $ivSize);
        $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }   
}