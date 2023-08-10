<?php

declare(strict_types=1);

/**
 * Keestash
 *
 * Copyright (C) <2023> <Dogan Ucar>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Keestash\Sdk\Register;

use GuzzleHttp\Exception\GuzzleException;
use Keestash\Sdk\Client\KeestashClient;
use Keestash\Sdk\Entity\Keestash\Response;
use Keestash\Sdk\Entity\Keestash\ResponseInterface;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;
use Keestash\Sdk\Register\Entity\UserAdd;

class User
{
    private KeestashClient $keestashClient;

    public function __construct(
        KeestashClient $keestashClient
    )
    {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param string $firstName
     * @param string $lastName
     * @param string $userName
     * @param string $email
     * @param string $password
     * @param string $passwordRepeat
     * @param bool $termsAndConditions
     * @return UserAdd
     * @throws GuzzleException
     */
    public function add(
        ApiCredentialsInterface $apiCredentials,
        string                  $firstName,
        string                  $lastName,
        string                  $userName,
        string                  $email,
        string                  $password,
        string                  $passwordRepeat,
        bool                    $termsAndConditions
    ): UserAdd
    {
        $response = $this->keestashClient->post(
            '/register/add',
            $apiCredentials,
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'user_name' => $userName,
                'email' => $email,
                'password' => $password,
                'passwordRepeat' => $passwordRepeat,
                'terms_and_conditions' => $termsAndConditions
            ]
        );

        $responseData = (array)json_decode(
            (string)$response->getBody(),
            true,
            JSON_THROW_ON_ERROR
        );

        return new UserAdd(
            $responseData['session'] ?? null,
            $responseData['data'] ?? null
        );
    }

    /**
     * @param string $input
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function resetPassword(string $input): ResponseInterface
    {
        $response = $this->keestashClient->postPublicEndpoint(
            '/register/reset-password',
            [
                'input' => $input
            ]
        );

        $decodedData = json_decode(
            (string)$response->getBody(),
            true,
            JSON_THROW_ON_ERROR
        );
        return new Response(
            (int)$decodedData['responseCode']
        );
    }

    /**
     * @param string $hash
     * @param string $password
     * @return void
     * @throws GuzzleException
     */
    public function resetPasswordConfirm(
        string $hash,
        string $password
    ): void
    {
        $this->keestashClient->postPublicEndpoint(
            '/register/reset-password/confirm',
            [
                'hash' => $hash,
                'password' => $password
            ]
        );
    }

    /**
     * @param string $hash
     * @return Entity\User
     * @throws GuzzleException
     */
    public function resetPasswordRetrieve(string $hash): Entity\User
    {
        $response = $this->keestashClient->getPublicEndpoint(
            sprintf(
                '/register/reset-password/retrieve/%s',
                $hash
            )
        );

        $decoded = (array)json_decode(
            (string)$response->getBody(),
            true,
            JSON_THROW_ON_ERROR
        );
        return new Entity\User(
            (string)$decoded['user']
        );
    }
}
