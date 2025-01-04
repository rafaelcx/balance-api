<?php

declare(strict_types=1);

namespace App\Services\AccountService\Repository;

class AccountRepository {

	protected static array $account_list = [];

	public function createAccount(Account $account): void {
		self::$account_list[$account->id] = $account;
	}
	
	public function getAccount(string $account_id): Account {
		return self::$account_list[$account_id] 
			?? throw new AccountRepositoryException('Account not found');
	}

}
