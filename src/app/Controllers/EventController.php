<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\EventModel;

final class EventController extends Controller
{
    private EventModel $events;

    public function __construct()
    {
        $this->events = new EventModel();
    }

    public function feed(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $events = $this->events->findPublicFeed(6);
        foreach ($events as &$event) {
            $event['image_url'] = app_asset_url((string) ($event['image_url'] ?? ''));
        }
        unset($event);

        echo json_encode([
            'events' => $events,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
