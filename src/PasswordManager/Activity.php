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

namespace Keestash\Sdk\PasswordManager;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Keestash\Sdk\Client\KeestashClient;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;

class Activity
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param string $referenceKey
     * @param string $appId
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function get(
        ApiCredentialsInterface $apiCredentials,
        string $referenceKey,
        string $appId
    ): array {
        $response = $this->keestashClient->get(
            sprintf(
                '/password_manager/credential/additional_data/get/%s/%s',
                $referenceKey,
                $appId
            ),
            $apiCredentials
        );
        $decoded = json_decode(
            (string)$response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        return $decoded['activityList'];
    }
}
