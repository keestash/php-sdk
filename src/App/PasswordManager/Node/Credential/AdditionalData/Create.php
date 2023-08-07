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

namespace Keestash\Sdk\App\PasswordManager\Node\Credential\AdditionalData;

use doganoo\DI\HTTP\IStatus;
use Keestash\Sdk\Exception\SdkException;
use Keestash\Sdk\Service\Api\ApiCredentialsInterface;
use Keestash\Sdk\Service\Client\KeestashClient;

class Create
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }

    public function create(
        int                     $credentialId,
        string                  $key,
        string                  $value,
        ApiCredentialsInterface $apiCredentials
    ): void
    {
        $response = $this->keestashClient->post(
            '/password_manager/credential/additional_data/add',
            $apiCredentials,
            [
                'credentialId' => $credentialId,
                'key' => $key,
                'value' => $value
            ],
        );

        if ($response->getStatusCode() !== IStatus::OK) {
            throw new SdkException();
        }
    }

}