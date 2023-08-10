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

namespace Keestash\Sdk\PasswordManager\Credential;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Keestash\Sdk\Client\KeestashClient;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;
use Keestash\Sdk\PasswordManager\Entity\HealthCheck as HealthCheckEntity;

class HealthCheck
{
    private KeestashClient $keestashClient;

    public function __construct(
        KeestashClient $keestashClient
    ) {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param bool $activate
     * @return HealthCheckEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function changeState(ApiCredentialsInterface $apiCredentials, bool $activate): HealthCheckEntity
    {
        $response = $this->keestashClient
            ->post(
                '/password_manager/node/pwned/change_state',
                $apiCredentials,
                [
                    'activate' => $activate
                ]
            );
        $decoded = json_decode(
            (string)$response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        return new HealthCheckEntity(
            $decoded['active']
        );
    }
}
