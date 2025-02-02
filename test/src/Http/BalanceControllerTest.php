<?php

declare(strict_types=1);

namespace Test\Http;

use App\Services\AccountService\Repository\Account;
use App\Services\AccountService\Repository\AccountRepository;
use Test\CustomTestCase;
use Test\Support\Services\AccountService\Repository\AccountRepositoryForTests;

class BalanceControllerTest extends CustomTestCase {

	/** @before */
	public function resetAccountRepository(): void {
		AccountRepositoryForTests::reset();
	}
	
	public function testController_WhenSuccessful(): void {
		$this->simulateAccountWithAmount('1', '10');
		
		$result = $this->request_simulator
			->withMethod('GET')
			->withBody([])
			->withPath('/balance')
			->withQueryParam(name: 'id', value: '1')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
		$this->assertJson('{"amount": "10"}', (string) $result->getBody());
	}

	public function testController_WhenAccountDoesNotExist(): void {
		$result = $this->request_simulator
			->withMethod('GET')
			->withBody([])
			->withPath('/balance')
			->withQueryParam(name: 'id', value: '1')
			->dispatch();

			$this->assertSame(404, $result->getStatusCode());
	}

	private function simulateAccountWithAmount(string $id, string $amount): void {
		$account = new Account($id, $amount);
		$account_repository = new AccountRepository();
		$account_repository->createAccount($account);
	}

}
