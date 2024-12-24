<?php

declare(strict_types=1);

namespace Test\Http;

use Test\CustomTestCase;

class EventControllerTest extends CustomTestCase {

	public function testController_WhenSuccessful(): void {
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody(['type' => 'deposit'])
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
		$this->assertSame('Event of type deposit', (string) $result->getBody());
	}

}
