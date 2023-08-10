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
use Psr\Http\Message\ResponseInterface;

class Node
{
    private KeestashClient $keestashClient;

    public function __construct(KeestashClient $keestashClient)
    {
        $this->keestashClient = $keestashClient;
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param string $nodeId
     * @param string $targetNodeId
     * @return void
     * @throws GuzzleException
     */
    public function move(
        ApiCredentialsInterface $apiCredentials,
        string $nodeId,
        string $targetNodeId
    ): void {
        $this->keestashClient->post(
            '/password_manager/node/move',
            $apiCredentials,
            [
                'node_id' => $nodeId,
                'target_node_id' => $targetNodeId
            ]
        );
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param string $nodeId
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(
        ApiCredentialsInterface $apiCredentials,
        string $nodeId
    ): ResponseInterface {
        return $this->keestashClient->get(
            sprintf(
                '/password_manager/node/get/%s',
                $nodeId
            ),
            $apiCredentials
        );
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param string $name
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getByName(
        ApiCredentialsInterface $apiCredentials,
        string $name
    ): array {
        $response = $this->keestashClient->get(
            sprintf(
                '/password_manager/node/name/%s',
                $name
            ),
            $apiCredentials
        );
        $decoded = json_decode(
            (string)$response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return $decoded['message'];
    }

    /**
     * @param ApiCredentialsInterface $apiCredentials
     * @param string $nodeId
     * @return void
     * @throws GuzzleException
     */
    public function delete(
        ApiCredentialsInterface $apiCredentials,
        string $nodeId
    ): void {
        $this->keestashClient->delete(
            '/password_manager/node/delete',
            $apiCredentials,
            [
                'node_id' => $nodeId
            ]
        );
    }
}
