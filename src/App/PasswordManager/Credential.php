<?php
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

namespace Keestash\Sdk\App\PasswordManager;

use doganoo\DI\HTTP\IStatus;
use Keestash\Sdk\Exception\SdkException;
use Keestash\Sdk\Service\Client\KeestashClient;

class Credential
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }


    public function create(Entity\Credential $credential): array
    {
        $response = $this->keestashClient->post(
            '/password_manager/node/credential/create',
            [
                'name' => $credential->getName(),
                'username' => $credential->getUsername(),
                'password' => [
                    "value" => $credential->getPassword(),
                ],
                'parent' => $credential->getParent(),
                'url' => $credential->getUrl()
            ]
        );

        if ($response->getStatusCode() !== IStatus::OK) {
            throw new SdkException();
        }
        return json_decode(
            (string)$response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}