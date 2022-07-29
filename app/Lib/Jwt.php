<?php

namespace App\Lib;
use \DateTime;

class Jwt {
    
    /**
     * create token
     * @param string $userId
     * @return string
     */
    public function createToken(string $userId): string {
        
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        
        $payload = [
            'userId' => $userId
        ];

        $token = $this->generate($header, $payload, $_ENV['SECRET_TOKEN_KEY']);

        return $token;

    }

    /**
     * generate JWT
     * @param array $header token header
     * @param array $payload token payload
     * @param string $secret secret key
     * @param int $validity token valid time
     * @return string Token
     */
    private function generate(array $header, array $payload, string $secret, int $validity = 86400): string
    {
        if($validity > 0){
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }

        // base64 encoding
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // cleaning values
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // generating signature
        $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // create the token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }

    /**
     * token check
     * @param string $token
     * @param string $secret secret key
     * @return bool 
     */
    public function check(string $token): bool
    {

        $secret = $_ENV['SECRET_TOKEN_KEY'];

        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }

    /**
     * get the token header
     * @param string $token 
     * @return array Header
     */
    public function getHeader(string $token)
    {
        // split token
        $array = explode('.', $token);

        // decoding token header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    /**
     * get payload
     * @param string $token 
     * @return array Payload
     */
    public function getPayload(string $token)
    {
        // split token
        $array = explode('.', $token);

        // decoding payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    /**
     * check expiration date
     * @param string $token 
     * @return bool 
     */
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTime();

        return $payload['exp'] < $now->getTimestamp();
    }

    /**
     * check if token is valid
     * @param string $token 
     * @return bool 
     */
    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }

}