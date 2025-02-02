<?php

declare(strict_types=1);

namespace Test\Http;

use Test\CustomTestCase;

class EventControllerTest extends CustomTestCase {

	public function testController_WhenDepositEvent_WhenSuccessful(): void {
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody(['type' => 'deposit'])
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
	}

	public function testController_WhenWithdrawEvent_WhenSuccessful(): void {
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody(['type' => 'withdraw'])
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
	}

	public function testController_WhenTransferEvent_WhenSuccessful(): void {
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody(['type' => 'transfer'])
			->withPath('/event')
			->dispatch();

		$this->assertSame(200, $result->getStatusCode());
	}

	public function testController_WhenUnknownEvent(): void {
		$result = $this->request_simulator
			->withMethod('POST')
			->withBody(['type' => 'unknown_event'])
			->withPath('/event')
			->dispatch();

		$this->assertSame(400, $result->getStatusCode());
	}

}
