<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking\ObjectValue;

final class Tracking
{
    public string $id;

    public string $source;

    public string $sourceId;

    public ?array $meta;

    public string $shortUrl;

    public ?string $type;

    public function __construct(
        string $id,
        string $source,
        string $sourceId,
        string $shortUrl,
        ?array $meta = null,
        ?string $type = null
    ) {
        $this->id = $id;
        $this->meta = $meta;
        $this->sourceId = $sourceId;
        $this->source = $source;
        $this->shortUrl = $shortUrl;
        $this->type = $type;
    }

    public static function fromArray(array $data): self
    {
        $type = \array_key_exists('type', $data) ? $data['type'] : null;

        return new self(
            $data['id'],
            $data['source'],
            $data['source_id'],
            $data['short_url'],
            $data['meta'],
            $type
        );
    }
}
