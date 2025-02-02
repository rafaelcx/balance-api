<?php

declare(strict_types=1);

namespace App\Services\AccountService;

use App\Services\AccountService\Exception\AccountNotFoundException;
use App\Services\AccountService\Repository\AccountRepository;
use App\Services\AccountService\Repository\AccountRepositoryException;

class AccountService {

	public function getBalance(string $account_id): string {
		try {
			$account = (new AccountRepository())->getAccount($account_id);
		} catch(AccountRepositoryException $e) {
			throw new AccountNotFoundException($e->getMessage());
		}
		return $account->amount;
	}

	public function deposit(string $account_id, string $amount): void {
		try {
			(new AccountRepository())->depositToAccount($account_id, $amount);
		} catch(AccountRepositoryException $e) {
			throw new AccountNotFoundException($e->getMessage());
		}
	}

	public function withdraw(string $account_id, string $amount): void {
		try {
			(new AccountRepository())->withdrawFromAccount($account_id, $amount);
		} catch(AccountRepositoryException $e) {
			throw new AccountNotFoundException($e->getMessage());
		}
	}

	public function transfer(string $origin_account_id, string $destination_account_id, string $amount): void {
		try {
			(new AccountRepository())->transferBetweenAccounts($origin_account_id, $destination_account_id, $amount);
		} catch(AccountRepositoryException $e) {
			throw new AccountNotFoundException($e->getMessage());
		}
	}

}
