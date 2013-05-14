<?php
    class AuthHelper {
        public function activation_code($email)
        {
            $key = 'the fish was delish';
            
            $activation_code = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $email, MCRYPT_MODE_CBC, md5(md5($key))));
            $activation_code = str_replace('=', '', $activation_code);
            $activation_code = str_replace('/', '_S', $activation_code);
            $activation_code = str_replace('+', '_P', $activation_code);
            
            return $activation_code;
        }
        
        public function decypher_activation_code($activation_code)
        {
            $key = 'the fish was delish';
            
            $activation_code = $activation_code.'=';
            $activation_code = str_replace('_S', '/', $activation_code);
            $activation_code = str_replace('_P', '+', $activation_code);
            $email = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($activation_code), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
            
            return $email;
        }
    }