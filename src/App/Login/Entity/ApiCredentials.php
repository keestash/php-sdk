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

namespace Keestash\Sdk\App\Login\Entity;

use Keestash\Sdk\Service\Api\ApiCredentialsInterface;

class ApiCredentials implements ApiCredentialsInterface
{

    private string $userToken;
    private string $userHash;

    public function __construct(
        string $userHash,
        string $userToken
    )
    {
        $this->userHash = $userHash;
        $this->userToken = $userToken;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }

    public function getUserHash(): string
    {
        return $this->userHash;
    }
}