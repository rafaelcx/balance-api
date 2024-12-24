<?php

declare(strict_types=1);

namespace App\Http;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController {

	public function handle(ServerRequestInterface $request): ResponseInterface {
		$event_type = json_decode($request->getBody()->getContents())->type;
		return new Response(200, [], 'Event of type ' . $event_type);
	}

}
