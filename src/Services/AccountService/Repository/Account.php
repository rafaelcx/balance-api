<?php

declare(strict_types=1);

namespace App\Services\AccountService\Repository;

class Account {

	public function __construct(
		public string $id,
		public string $amount,
	) {}

}
