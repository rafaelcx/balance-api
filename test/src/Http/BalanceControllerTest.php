<?php

declare(strict_types=1);

namespace Test\Http;

use Test\CustomTestCase;

class BalanceControllerTest extends CustomTestCase {

	public function testController_WhenSuccessful(): void {
		$result = $this->request_simulator
			->withMethod('GET')
			->withBody([])
			->withPath('/balance')
			->withQueryParam(name: 'id', value: '1')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
		$this->assertSame('Balance 1', (string) $result->getBody());
	}

}
