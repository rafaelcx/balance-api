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

	public function depositToAccount(string $account_id, string $amount): void {
		$account = self::$account_list[$account_id] 
			?? throw new AccountRepositoryException('Account not found');
		
		$new_amount = $account->amount + $amount;
		$account->amount = (string) $new_amount;
		self::$account_list[$account_id] = $account;
	}

	public function withdrawFromAccount(string $account_id, string $amount): void {
		$account = self::$account_list[$account_id] 
			?? throw new AccountRepositoryException('Account not found');

		$new_amount = $account->amount - $amount;
		$account->amount = (string) $new_amount;
		self::$account_list[$account_id] = $account;
	}

	public function transferBetweenAccounts(string $origin_acc_id, string $destination_acc_id, string $amount): void {
		$this->withdrawFromAccount($origin_acc_id, $amount);
		$this->depositToAccount($destination_acc_id, $amount);
	}

}
