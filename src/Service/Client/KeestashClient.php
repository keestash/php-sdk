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

namespace Keestash\Sdk\Service\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Keestash\Sdk\Service\Api\ApiCredentialsInterface;
use Psr\Http\Message\ResponseInterface;

class KeestashClient
{
    private ClientInterface $guzzleClient;
    private ApiCredentialsInterface $apiCredentials;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function __construct(
        ClientInterface         $guzzleClient,
        ApiCredentialsInterface $envService
    )
    {
        $this->guzzleClient = $guzzleClient;
        $this->apiCredentials = $envService;
    }

    /**
     * @param $path
     * @param $body
     * @param array $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function post($path, $body, array $headers = []): ResponseInterface
    {
        $headers['x-keestash-token'] = $this->apiCredentials->getUserToken();
        $headers['x-keestash-user'] = $this->apiCredentials->getUserHash();
        return $this->guzzleClient->post(
            $this->apiCredentials->getApiUrl() . $path,
            [
                RequestOptions::JSON => $body,
                RequestOptions::HEADERS => $headers
            ]
        );
    }

    /**
     * @param $path
     * @param $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function postPublicEndpoint($path, $body): ResponseInterface
    {
        return $this->guzzleClient->post(
            $this->apiCredentials->getApiUrl() . $path,
            [RequestOptions::JSON => $body]
        );
    }
}