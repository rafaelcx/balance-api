<?php

declare(strict_types=1);

namespace Test\Support\Services\AccountService\Repository;

use App\Services\AccountService\Repository\AccountRepository;

class AccountRepositoryForTests extends AccountRepository {

	public static function reset(): void {
		self::$account_list = [];
	}

}
