<?php

namespace Drewdan\UkAddressLookup\Tests;

use Spatie\LaravelRay\RayServiceProvider;
use Drewdan\UkAddressLookup\UkAddressLookupServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

class TestCase extends \Orchestra\Testbench\TestCase {

	public function setUp(): void {
		parent::setUp();
		// additional setup
	}

	protected function getPackageProviders($app): array {
		$app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

		return [
			UkAddressLookupServiceProvider::class,
			RayServiceProvider::class,
		];
	}

}
