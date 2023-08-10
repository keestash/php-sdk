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

namespace Keestash\Sdk\Register\Entity;

class Configuration
{
    private array $phoneConfig;
    private bool $registerEnabled;
    private bool $resetEnabled;
    private bool $isSaas;

    public function __construct(
        array $phoneConfig,
        bool $registerEnabled,
        bool $resetEnabled,
        bool $isSaas
    ) {
        $this->phoneConfig = $phoneConfig;
        $this->registerEnabled = $registerEnabled;
        $this->resetEnabled = $resetEnabled;
        $this->isSaas = $isSaas;
    }

    public function getPhoneConfig(): array
    {
        return $this->phoneConfig;
    }

    public function isRegisterEnabled(): bool
    {
        return $this->registerEnabled;
    }

    public function isResetEnabled(): bool
    {
        return $this->resetEnabled;
    }

    public function isSaas(): bool
    {
        return $this->isSaas;
    }
}
