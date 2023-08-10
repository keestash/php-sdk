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

namespace Keestash\Sdk\PasswordManager\Folder;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Keestash\Sdk\Client\KeestashClient;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;
use Keestash\Sdk\PasswordManager\Entity\Folder as FolderEntity;

class Folder
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param FolderEntity $folder
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function create(
        ApiCredentialsInterface $apiCredentials,
        FolderEntity $folder
    ): array {
        $response = $this->keestashClient->post(
            '/password_manager/node/folder/create',
            $apiCredentials,
            [
                'name' => $folder->getName(),
                'node_id' => $folder->getParent()
            ],
        );

        return json_decode(
            (string)$response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $parentNodeId
     * @param bool $forceCreate
     * @param ApiCredentialsInterface $apiCredentials
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function createByPath(
        string $path,
        string $delimiter,
        string $parentNodeId,
        bool $forceCreate,
        ApiCredentialsInterface $apiCredentials
    ): array {
        $response = $this->keestashClient->post(
            '/password_manager/node/folder/create/path',
            $apiCredentials,
            [
                'path' => $path,
                'delimiter' => $delimiter,
                'parentNodeId' => $parentNodeId,
                'forceCreate' => $forceCreate
            ]
        );

        return json_decode(
            (string)$response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    public function update(
        ApiCredentialsInterface $apiCredentials,
        string $nodeId,
        string $name
    ): void {
        $this->keestashClient->post(
            '/password_manager/node/folder/update',
            $apiCredentials,
            [
                'node_id' => $nodeId,
                'name' => $name
            ]
        );
    }
}
