<?php

declare(strict_types=1);

namespace Test\Services\AccountService;

use App\Services\AccountService\AccountService;
use App\Services\AccountService\Exception\AccountNotFoundException;
use App\Services\AccountService\Repository\Account;
use App\Services\AccountService\Repository\AccountRepository;
use Test\CustomTestCase;
use Test\Support\Services\AccountService\Repository\AccountRepositoryForTests;

class AccountServiceTest extends CustomTestCase {

	private AccountService $account_service;

	/** @before */
	public function setUpAccountServiceForTests(): void {
		$this->account_service = new AccountService();
	}

	/** @before */
	public function resetAccountRepository(): void {
		AccountRepositoryForTests::reset();
	}
	
	public function testGetBalance_WhenSuccessful(): void {
		$this->simulateAccountWithAmount(id: '1', amount: '10');
		$result = $this->account_service->getBalance(account_id: '1');
		$this->assertSame('10', $result);
	}

	public function testGetBalance_WhenAccountDoesNotExist(): void {
		$this->expectException(AccountNotFoundException::class);
		$this->expectExceptionMessage('Account not found');
		$this->account_service->getBalance(account_id: '2');
	}

	private function simulateAccountWithAmount(string $id, string $amount): void {
		$account = new Account($id, $amount);
		$account_repository = new AccountRepository();
		$account_repository->createAccount($account);
	}

}
