<?php

declare(strict_types=1);

namespace App\Http;

use App\Services\AccountService\AccountService;
use App\Services\AccountService\Exception\AccountNotFoundException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController {

	public function handle(ServerRequestInterface $request): ResponseInterface {
		$request_dto = json_decode($request->getBody()->getContents());

		return match ($request_dto->type ?? '') {
			'deposit'  => $this->handleDepositEvent($request_dto),
			'withdraw' => $this->handleWithdrawEvent($request_dto),
			'transfer' => $this->handleTransferEvent($request_dto),
			default    => $this->handleUnknownEvent(),
		};
	}

	private function handleDepositEvent(\stdClass $request_dto): ResponseInterface {
		$account_id = $request_dto->destination ?? '';
		$amount = $request_dto->amount ?? '';

		$account_service = new AccountService();
		
		try {
			$account_service->deposit($account_id, $amount);
			$updated_amount = $account_service->getBalance($account_id);
		} catch(AccountNotFoundException $_) {
			return new Response(400);
		}

		$response_body = json_encode([
			'destination' => [
				'id' => $account_id,
				'balance' => $updated_amount,
			],
		]);

		return new Response(200, [], $response_body);
	}

	private function handleWithdrawEvent(\stdClass $request_dto): ResponseInterface {
		$account_id = $request_dto->origin ?? '';
		$amount = $request_dto->amount ?? '';

		$account_service = new AccountService();

		try {
			$account_service->withdraw($account_id, $amount);
			$updated_amount = $account_service->getBalance($account_id);
		} catch(AccountNotFoundException $_) {
			return new Response(400);
		}

		$response_body = json_encode([
			'origin' => [
				'id' => $account_id,
				'balance' => $updated_amount,
			],
		]);
		return new Response(200, [], $response_body);
	}

	private function handleTransferEvent(\stdClass $request_dto): ResponseInterface {
		$origin_account_id = $request_dto->origin ?? '';
		$destination_account_id = $request_dto->destination ?? '';
		$amount = $request_dto->amount ?? '';

		$account_service = new AccountService();
		
		try {
			$account_service->transfer($origin_account_id, $destination_account_id, $amount);
			$updated_ori_amount = $account_service->getBalance($origin_account_id);
			$updated_dst_amount = $account_service->getBalance($destination_account_id);
		} catch(AccountNotFoundException $_) {
			return new Response(400);
		}

		$response_body = json_encode([
			'origin' => [
				'id' => $origin_account_id,
				'balance' => $updated_ori_amount,
			],
			'destination' => [
				'id' => $destination_account_id,
				'balance' => $updated_dst_amount,
			],
		]);
		return new Response(200, [], $response_body);
	}

	private function handleUnknownEvent(): ResponseInterface {
		return new Response(400);	
	}

}
