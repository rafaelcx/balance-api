<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Test\Support\RequestSimulator;

class CustomTestCase extends TestCase {

	public RequestSimulator $request_simulator;

	public function __construct() {
		$this->request_simulator = new RequestSimulator();
		parent::__construct();
	}

}
