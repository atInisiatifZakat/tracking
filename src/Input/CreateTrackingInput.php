<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking\Input;

use Inisiatif\Package\Tracking\Request;

final class CreateTrackingInput extends Input
{
    private array $params;

    public function __construct(
        string $type,
        array $meta,
        string $source,
        string $sourceId
    ) {
        $this->params = [
            'type' => $type,
            'mete' => $meta,
            'source' => $source,
            'source_id' => $sourceId,
        ];
    }

    public static function createQurban(array $meta, string $source, string $sourceId): self
    {
        return new self('QURBAN', $meta, $source, $sourceId);
    }

    public function request(): Request
    {
        return Request::create('POST', '/tracking', $this->params);
    }
}
