<?php

namespace Drewdan\UkAddressLookup\Tests\Unit;

use Drewdan\UkAddressLookup\ApiClient;
use Drewdan\UkAddressLookup\Tests\TestCase;

class ApiClientTest extends TestCase {

	public function testCanRetrievePostcode() {
		$client = new ApiClient();

		$results = $client->postcode('NP10 9BS');

	}
}
