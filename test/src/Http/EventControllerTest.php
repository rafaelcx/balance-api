<?php

declare(strict_types=1);

namespace Test\Http;

use App\Services\AccountService\Repository\Account;
use App\Services\AccountService\Repository\AccountRepository;
use Test\CustomTestCase;
use Test\Support\Services\AccountService\Repository\AccountRepositoryForTests;

class EventControllerTest extends CustomTestCase {

	/** @before */
	public function resetAccountRepository(): void {
		AccountRepositoryForTests::reset();
	}
	
	public function testController_WhenDepositEvent_WhenSuccessful(): void {
		$this->simulateAccountWithAmount('1', '10');

		$request_body = [
			'type' => 'deposit',
			'destination' => '1',
			'amount' => '10',
		];
		
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody($request_body)
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
		$this->assertJsonStringEqualsJsonString('{"destination": {"id":"1", "balance":"20"}}', $result->getBody()->getContents());
	}

	public function testController_WhenWithdrawEvent_WhenSuccessful(): void {
		$this->simulateAccountWithAmount('1', '10');

		$request_body = [
			'type' => 'withdraw',
			'origin' => '1',
			'amount' => '10',
		];

		$result = $this->request_simulator
			->withMethod('POST')
			->withBody($request_body)
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
		$this->assertJsonStringEqualsJsonString('{"origin": {"id":"1", "balance":"0"}}', $result->getBody()->getContents());
	}

	public function testController_WhenTransferEvent_WhenSuccessful(): void {
		$this->simulateAccountWithAmount('1', '10');
		$this->simulateAccountWithAmount('2', '10');
		
		$request_body = [
			'type' => 'transfer',
			'origin' => '1',
			'destination' => '2',
			'amount' => '5',
		];
		
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody($request_body)
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
		$this->assertJsonStringEqualsJsonString('{"origin": {"id":"1", "balance":"5"}, "destination": {"id":"2", "balance":"15"}}', $result->getBody()->getContents());
	}

	public function testController_WhenUnknownEvent(): void {
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody(['type' => 'unknown_event'])
			->withPath('/event')
			->dispatch();

		$this->assertSame(400, $result->getStatusCode());
	}

	private function simulateAccountWithAmount(string $id, string $amount): void {
		$account = new Account($id, $amount);
		$account_repository = new AccountRepository();
		$account_repository->createAccount($account);
	}

}
