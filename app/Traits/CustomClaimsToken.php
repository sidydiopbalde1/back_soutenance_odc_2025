<?php

namespace App\Traits;

use Laravel\Passport\PersonalAccessTokenResult;

trait CustomClaimsToken
{
    /*
    public function createTokenWithClaims($name, array $scopes = [])
    {
        $tokenResult = $this->createToken($name, $scopes);
        $claims = [
            'nom' => "nom",
            'prenom' => $this->prenom,
            'login' => $this->login,
            'role' => $this->role->name,
        ];

        // Encode the claims in the tokenResult
        $jwt = $this->encodeCustomClaims($tokenResult->accessToken, $claims);

        return new PersonalAccessTokenResult($jwt, $tokenResult->token);
    }

    protected function encodeCustomClaims($token, $claims)
    {
        // Decode the token to add the custom claims
        $payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));

        foreach ($claims as $key => $value) {
            $payload->{$key} = $value;
        }

        // Encode the payload again to create the new token
        $segments = explode('.', $token);
        $segments[1] = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

        return implode('.', $segments);
    }
*/


}
