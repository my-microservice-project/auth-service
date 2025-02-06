<?php
namespace App\HttpRequests;

use App\Data\LoginData;
use App\Data\UserData;
use BugraBozkurt\InterServiceCommunication\Facades\User;

class AuthHttpRequests
{
    public function verifyCredentials(LoginData $loginData): UserData|false
    {
        try {
            $response = User::post('api/v1/users/verify-credentials', $loginData->toArray());

            if (!$response->successful()) {
                return false;
            }

            return UserData::from($response->json('data'));
        } catch (\Exception $e) {
            return false;
        }
    }

    public function logout(): bool
    {
        try {
            $response = User::post('api/v1/logout');

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
