<?php
namespace App\Tools;

/**
 * AES 128/工作模式/填充模式
 * AES/ECB/PKCS5Padding
 */
class Aes {
    public static function encryptBase64($input, $key)
    {
        $size  = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = Aes::pkcs5_pad($input, $size);
        $td    = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv    = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data  = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data  = base64_encode($data);
        return $data;
    }

    public static function decryptBase64($sStr, $sKey)
    {
        $decrypted= mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );

        $dec_s      = strlen($decrypted);
        $padding    = ord($decrypted[$dec_s-1]);
        $decrypted  = substr($decrypted, 0, -$padding);
        return $decrypted;
    }


    private static function pkcs5_pad ($text, $blockSize)
    {
        $pad = $blockSize - (strlen($text) % $blockSize);
        return $text . str_repeat(chr($pad), $pad);
    }
}