<?php

declare(strict_types=1);

namespace App\Http;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BalanceController {

	public function handle(ServerRequestInterface $request): ResponseInterface {
		$account_id = $request->getQueryParams()['id'];
		return new Response(200, [], 'Balance ' . $account_id);
	}

}
