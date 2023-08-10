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

namespace Keestash\Sdk\Settings\User;

use GuzzleHttp\Exception\GuzzleException;
use Keestash\Sdk\Client\KeestashClient;
use Keestash\Sdk\Exception\SdkException;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;
use Keestash\Sdk\Settings\Entity\User\Configuration as ConfigurationEntity;

class Configuration
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @return ConfigurationEntity
     * @throws GuzzleException
     */
    public function getConfiguration(): ConfigurationEntity
    {
        $response = $this->keestashClient->getPublicEndpoint(
            '/users/profile/configuration'
        );
        $decoded = (array)json_decode(
            (string)$response->getBody(),
            true,
            JSON_THROW_ON_ERROR
        );
        return new ConfigurationEntity(
            (int)$decoded['uploadMaxFilesize']
        );
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param int $userId
     * @param string $oldPassword
     * @param string $password
     * @return void
     * @throws GuzzleException
     */
    public function updatePassword(
        ApiCredentialsInterface $apiCredentials,
        int                     $userId,
        string                  $oldPassword,
        string                  $password
    ): void
    {
        $this->keestashClient->post(
            '/users/update-password',
            $apiCredentials,
            [
                'userId' => $userId,
                'oldPassword' => $oldPassword,
                'password' => $password
            ]
        );
    }

    /**
     * @return void
     * @throws SdkException
     */
    public function uploadProfileImage(): void
    {
        throw new SdkException('implement me');
    }
}
