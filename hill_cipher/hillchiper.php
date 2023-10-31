<?php
function cleanText($text) {
    $text = preg_replace("/[^A-Z]/", "", strtoupper($text)); // Hanya mengambil huruf kapital
    return $text;
}

function encryptHillCipher($plaintext, $keyMatrix)
{
    $plaintext = cleanText($plaintext);
    $len = strlen($plaintext);
    $ciphertext = "";

    // Mengecek apakah panjang plaintext adalah kelipatan 2
    if ($len % 2 != 0) {
        $plaintext .= "X"; // Jika bukan kelipatan 2, tambahkan 'X' sebagai padding
        $len++;
    }

    for ($i = 0; $i < $len; $i += 2) {
        $block = substr($plaintext, $i, 2);
        $result = "";

        for ($j = 0; $j < 2; $j++) {
            $sum = 0;
            for ($k = 0; $k < 2; $k++) {
                $sum += (ord($block[$k]) - 65) * $keyMatrix[$j][$k];
            }
            $result .= chr(($sum % 26) + 65);
        }
        $ciphertext .= $result;
    }

    return $ciphertext;
}

function decryptHillCipher($ciphertext, $keyMatrix)
{
    $len = strlen($ciphertext);
    $plaintext = "";

    // Mengecek apakah panjang ciphertext adalah kelipatan 2
    if ($len % 2 != 0) {
        return "Ciphertext tidak valid"; // Ciphertext harus berupa kelipatan 2
    }

    for ($i = 0; $i < $len; $i += 2) {
        $block = substr($ciphertext, $i, 2);
        $result = "";

        for ($j = 0; $j < 2; $j++) {
            $sum = 0;
            for ($k = 0; $k < 2; $k++) {
                $sum += (ord($block[$k]) - 65) * $keyMatrix[$j][$k];
            }
            $result .= chr(($sum % 26) + 65);
        }
        $plaintext .= $result;
    }

    return $plaintext;
}

?>
