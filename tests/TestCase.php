<?php

namespace tests;

use UkAddressLookupServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase {

	public function setUp(): void {
		parent::setUp();
		// additional setup
	}

	protected function getPackageProviders($app): array {
		return [
			UkAddressLookupServiceProvider::class,
		];
	}

	protected function getEnvironmentSetUp($app) {
		// perform environment setup
	}

}
