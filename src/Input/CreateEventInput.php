<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking\Input;

use DateTimeInterface;
use Inisiatif\Package\Tracking\Request;

final class CreateEventInput extends Input
{
    private array $params;

    public function __construct(
        string $trackingId,
        string $type,
        string $description,
        DateTimeInterface $date,
        array $meta = []
    ) {
        $this->params = [
            'tracking_id' => $trackingId,
            'type' => $type,
            'description' => $description,
            'date' => $date->format('Y-m-d'),
            'meta' => $meta,
        ];
    }

    public function request(): Request
    {
        return Request::create('POST', '/event', $this->params);
    }
}
