<?php

declare(strict_types=1);

namespace App\Http;

use App\Services\AccountService\AccountService;
use App\Services\AccountService\Exception\AccountNotFoundException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BalanceController {

	public function handle(ServerRequestInterface $request): ResponseInterface {
		$account_id = $request->getQueryParams()['id'];
		
		try {
			$result = (new AccountService())->getBalance($account_id);
		} catch (AccountNotFoundException $_) {
			return new Response(404);
		}

		$response_body = json_encode(['amount' => $result]);
		return new Response(200, [], $response_body);
	}

}
