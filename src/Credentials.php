<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking;

final class Credentials
{
    private string $key;

    private string $secret;

    public function __construct(string $key, string $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
