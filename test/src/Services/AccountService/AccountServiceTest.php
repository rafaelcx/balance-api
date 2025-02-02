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

	public function testDeposit_WhenSuccessful(): void {
		$this->simulateAccountWithAmount(id: '1', amount: '10');
		$this->account_service->deposit(account_id: '1', amount: '10');
		$updated_balance = $this->account_service->getBalance(account_id: '1');
		$this->assertSame('20', $updated_balance);
	}

	public function testWithdraw_WhenSuccessful(): void {
		$this->simulateAccountWithAmount(id: '1', amount: '10');
		$this->account_service->withdraw(account_id: '1', amount: '5');
		$updated_balance = $this->account_service->getBalance(account_id: '1');
		$this->assertSame('5', $updated_balance);
	}

	public function testTransfer_WhenSuccessful(): void {
		$this->simulateAccountWithAmount(id: '1', amount: '10');
		$this->simulateAccountWithAmount(id: '2', amount: '10');
		
		$this->account_service->transfer(origin_account_id: '1', destination_account_id: '2', amount: '5');

		$updated_ori_balance = $this->account_service->getBalance(account_id: '1');
		$updated_dst_balance = $this->account_service->getBalance(account_id: '2');

		$this->assertSame('5', $updated_ori_balance);
		$this->assertSame('15', $updated_dst_balance);
	}

	public function testGetBalance_WhenAccountDoesNotExist(): void {
		$this->expectException(AccountNotFoundException::class);
		$this->expectExceptionMessage('Account not found');
		$this->account_service->getBalance(account_id: '2');
	}

	public function testDeposit_WhenAccountDoesNotExist(): void {
		$this->expectException(AccountNotFoundException::class);
		$this->expectExceptionMessage('Account not found');
		$this->account_service->deposit(account_id: '2', amount: '10');
	}

	public function testWithdraw_WhenAccountDoesNotExist(): void {
		$this->expectException(AccountNotFoundException::class);
		$this->expectExceptionMessage('Account not found');
		$this->account_service->withdraw(account_id: '2', amount: '10');
	}

	public function testTransfer_WhenOriginAccountDoesNotExist(): void {
		$this->simulateAccountWithAmount(id: '2', amount: '10');
		$this->expectException(AccountNotFoundException::class);
		$this->expectExceptionMessage('Account not found');
		$this->account_service->transfer(origin_account_id: '1', destination_account_id: '2', amount: '5');
	}

	public function testTransfer_WhenDestinationAccountDoesNotExist(): void {
		$this->simulateAccountWithAmount(id: '1', amount: '10');
		$this->expectException(AccountNotFoundException::class);
		$this->expectExceptionMessage('Account not found');
		$this->account_service->transfer(origin_account_id: '1', destination_account_id: '2', amount: '5');
	}

	private function simulateAccountWithAmount(string $id, string $amount): void {
		$account = new Account($id, $amount);
		$account_repository = new AccountRepository();
		$account_repository->createAccount($account);
	}

}
