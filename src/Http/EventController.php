<?php

declare(strict_types=1);

namespace App\Http;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController {

	public function handle(ServerRequestInterface $request): ResponseInterface {
		$event_type = json_decode($request->getBody()->getContents())->type;

		return match ($event_type) {
			'deposit'  => $this->handleDepositEvent(),
			'withdraw' => $this->handleWithdrawEvent(),
			'transfer' => $this->handleTransferEvent(),
			default    => $this->handleUnknownEvent(),
		};
	}

	private function handleDepositEvent(): ResponseInterface {
		return new Response(200);	
	}

	private function handleWithdrawEvent(): ResponseInterface {
		return new Response(200);	
	}

	private function handleTransferEvent(): ResponseInterface {
		return new Response(200);	
	}

	private function handleUnknownEvent(): ResponseInterface {
		return new Response(400);	
	}

}
