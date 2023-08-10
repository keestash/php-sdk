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

namespace Keestash\Sdk\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Keestash\Sdk\Login\Entity\ApiCredentialsInterface;
use Psr\Http\Message\ResponseInterface;

class KeestashClient
{
    private ClientInterface $guzzleClient;
    private string $url;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function __construct(
        ClientInterface $guzzleClient,
        string $url
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->url = $url;
    }

    /**
     * @param string $path
     * @param ApiCredentialsInterface $apiCredentials
     * @param array $body
     * @param array $multiPart
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function post(
        string $path,
        ApiCredentialsInterface $apiCredentials,
        array $body = [],
        array $multiPart = []
    ): ResponseInterface {
        $headers['x-keestash-token'] = $apiCredentials->getUserToken();
        $headers['x-keestash-user'] = $apiCredentials->getUserHash();
        return $this->guzzleClient->post(
            $this->url . $path,
            [
                RequestOptions::JSON => $body,
                RequestOptions::HEADERS => $headers,
                RequestOptions::MULTIPART => $multiPart
            ]
        );
    }

    /**
     * @param string $path
     * @param ApiCredentialsInterface $apiCredentials
     * @param array $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function delete(
        string $path,
        ApiCredentialsInterface $apiCredentials,
        array $body = []
    ): ResponseInterface {
        $headers['x-keestash-token'] = $apiCredentials->getUserToken();
        $headers['x-keestash-user'] = $apiCredentials->getUserHash();
        return $this->guzzleClient->delete(
            $this->url . $path,
            [
                RequestOptions::JSON => $body,
                RequestOptions::HEADERS => $headers,
            ]
        );
    }

    /**
     * @param string $path
     * @param ApiCredentialsInterface $apiCredentials
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(
        string $path,
        ApiCredentialsInterface $apiCredentials
    ): ResponseInterface {
        $headers['x-keestash-token'] = $apiCredentials->getUserToken();
        $headers['x-keestash-user'] = $apiCredentials->getUserHash();
        return $this->guzzleClient->post(
            $this->url . $path,
            [
                RequestOptions::HEADERS => $headers,
            ]
        );
    }

    /**
     * @param string $path
     * @param array $body
     * @param array $multiPart
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function postPublicEndpoint(
        string $path,
        array $body = [],
        array $multiPart = []
    ): ResponseInterface {
        return $this->guzzleClient->post(
            $this->url . $path,
            [
                RequestOptions::JSON => $body,
                RequestOptions::MULTIPART => $multiPart
            ]
        );
    }

    /**
     * @param string $path
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getPublicEndpoint(string $path): ResponseInterface
    {
        return $this->guzzleClient->request(
            'GET',
            $this->url . $path
        );
    }
}
