<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking\Tests;

use PHPUnit\Framework\TestCase;
use Inisiatif\Package\Tracking\Credentials;
use Inisiatif\Package\Tracking\TrackingClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Inisiatif\Package\Tracking\Input\CreateEventInput;
use Symfony\Component\HttpClient\Response\MockResponse;
use Inisiatif\Package\Tracking\Input\CreateTrackingInput;

final class TrackingClientTest extends TestCase
{
    public function testCanCreateTracking(): void
    {
        $httpClient = new MockHttpClient([
            new MockResponse(
                <<<JSON
{
    "success": true,
    "message": "Create tracking success",
    "data": {
        "id": "f860e4e9-d287-11eb-bad0-028b676a2ef0",
        "type": "QURBAN",
        "source": "testing",
        "source_id": "995025aa-d286-11eb-b8bc-0242ac130003",
        "meta": null,
        "short_url": "https://izi.fyi/9f4bPm"
    }
}
JSON
            ),
        ], 'https://trackingapi.inisiatif.id');

        $input = CreateTrackingInput::createQurban(
            [],
            'testing',
            '995025aa-d286-11eb-b8bc-0242ac130003'
        );

        $client = new TrackingClient(new Credentials('admin@izi.or.id', 'password'), $httpClient);
        $result = $client->createTracking($input);

        $this->assertSame('f860e4e9-d287-11eb-bad0-028b676a2ef0', $result->id);
        $this->assertSame('995025aa-d286-11eb-b8bc-0242ac130003', $result->sourceId);
    }

    public function testCanCreateEvent(): void
    {
        $httpClient = new MockHttpClient([
            new MockResponse(
                <<<JSON
{
    "success": true,
    "message": "Create tracking success",
    "data": {
        "id": "f860e4e9-d287-11eb-bad0-028b676a2ef0",
        "type": "QURBAN",
        "source": "testing",
        "source_id": "995025aa-d286-11eb-b8bc-0242ac130003",
        "meta": null,
        "short_url": "https://izi.fyi/9f4bPm"
    }
}
JSON
            ),
            new MockResponse(
                <<<JSON
{
    "success": true,
    "message": "Create event success"
}
JSON
            ),
        ], 'https://trackingapi.inisiatif.id');
        $input = CreateTrackingInput::createQurban(
            [],
            'testing',
            '995025aa-d286-11eb-b8bc-0242ac130003'
        );

        $client = new TrackingClient(new Credentials('admin@izi.or.id', 'password'), $httpClient);
        $result = $client->createTracking($input);

        $client->createEvent(new CreateEventInput(
            $result->id,
            'TESTING',
            'Testing event',
            new \DateTime(),
            []
        ));
        $this->assertTrue(true);
    }
}
