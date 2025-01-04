<?php

declare(strict_types=1);

namespace Test\Services\AccountService\Repository;

use App\Services\AccountService\Repository\Account;
use App\Services\AccountService\Repository\AccountRepository;
use App\Services\AccountService\Repository\AccountRepositoryException;
use Test\CustomTestCase;
use Test\Support\Services\AccountService\Repository\AccountRepositoryForTests;

class AccountRepositoryTest extends CustomTestCase {

	/** @before */
	public function resetAccountRepository(): void {
		AccountRepositoryForTests::reset();
	}
	
	public function testCreateAndGetAccount(): void {
		$repository = new AccountRepository;
		$account = new Account(id: '1', amount: '10');
		
		$repository->createAccount($account);
		$result = $repository->getAccount($account->id);

		$this->assertSame($account->id, $result->id);
		$this->assertSame($account->amount, $result->amount);
	}

	public function testGetAccount_WhenAccountIsNotFound_ShouldThrow(): void {
		$this->expectException(AccountRepositoryException::class);
		$this->expectExceptionMessage('Account not found');
		$repository = (new AccountRepository)->getAccount('1');
	}

}
