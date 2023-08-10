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

namespace Keestash\Sdk\Login;

use GuzzleHttp\Exception\GuzzleException;
use Keestash\Sdk\Client\KeestashClient;
use Keestash\Sdk\Login\Entity\ApiCredentials;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;

class Login
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @param string $username
     * @param string $password
     * @return ApiCredentialsInterface
     * @throws GuzzleException
     */
    public function login(string $username, string $password): ApiCredentialsInterface
    {
        $response = $this->keestashClient->postPublicEndpoint(
            '/login/submit',
            ['user' => $username, 'password' => $password]
        );

        return new ApiCredentials(
            $response->getHeader('x-keestash-user')[0],
            $response->getHeader('x-keestash-token')[0]
        );
    }
}
