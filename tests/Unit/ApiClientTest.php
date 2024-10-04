<?php

namespace Drewdan\UkAddressLookup\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Drewdan\UkAddressLookup\ApiClient;
use Drewdan\UkAddressLookup\Tests\TestCase;

class ApiClientTest extends TestCase {

	public function testCanRetrievePostcode() {
		$propertyData = [
			'id' => 'some-uuid-here',
			'property' => [
				'organisation_name' => 'some org name',
				'sub_property_name' => 'some sub prop name',
				'sub_property_number' => 'some sub prop number',
				'property_name' => 'some prop name',
				'property_number' => 'some prop number',
			],
			'full_address' => 'some full address',
			'address_line_1' => 'some address line 1',
			'address_line_2' => 'some address line 2',
			'locality' => 'some locality',
			'district' => 'some district',
			'city' => 'some city',
			'county' => 'some county',
			'country' => 'some country',
			'postcode' => 'NP10 9BS',
			'language_code' => 'en',
		];

		Http::fake([
			'https://ukaddresslookup.co.uk/api/v1/postcode/NP10%209BS' => Http::response([
				'status' => 'success',
				'data' => [$propertyData],
				'count' => 1,
			]),
		]);

		$client = new ApiClient();

		$results = $client->postcode('NP10 9BS');

		$this->assertNotEmpty($results);

		$this->assertEquals($results->data->first()->toArray(), $propertyData);
	}

	public function testRunningOutOfCreditThrowsNoCreditException() {
		Http::fake([
			'https://ukaddresslookup.co.uk/api/v1/postcode/NP10%209BS' => Http::response([
				'status' => 'error',
				'message' => 'No credit',
			], 402),
		]);

		$this->expectException(\Drewdan\UkAddressLookup\Exceptions\CreditExhaustedException::class);

		$client = new ApiClient();

		$client->postcode('NP10 9BS');
	}

	public function testRateLimitResponseThrowsRateLimitException() {
		Http::fake([
			'https://ukaddresslookup.co.uk/api/v1/postcode/NP10%209BS' => Http::response([
				'status' => 'error',
				'message' => 'Rate limit exceeded',
			], 429),
		]);

		$this->expectException(\Drewdan\UkAddressLookup\Exceptions\RateLimitExceededException::class);

		$client = new ApiClient();

		$client->postcode('NP10 9BS');
	}

	public function testGenericErrorResponseThrowsGenericException() {
		Http::fake([
			'https://ukaddresslookup.co.uk/api/v1/postcode/NP10%209BS' => Http::response([
				'status' => 'error',
				'message' => 'Something went wrong',
			], 500),
		]);

		$this->expectException(\Exception::class);

		$client = new ApiClient();

		$client->postcode('NP10 9BS');
	}

	public function testCanReturnAddressFromUuid() {
		$addressData = [
			'id' => '579fc246-37f1-4386-8a5b-93aa73bf72c2',
			'property' => [
				'organisation_name' => 'some org name',
				'sub_property_name' => 'some sub prop name',
				'sub_property_number' => 'some sub prop number',
				'property_name' => 'some prop name',
				'property_number' => 'some prop number',
			],
			'full_address' => 'some full address',
			'address_line_1' => 'some address line 1',
			'address_line_2' => 'some address line 2',
			'locality' => 'some locality',
			'district' => 'some district',
			'city' => 'some city',
			'county' => 'some county',
			'country' => 'some country',
			'postcode' => 'NP10 9BS',
			'language_code' => 'en',
		];

		Http::fake([
			'https://ukaddresslookup.co.uk/api/v1/address/579fc246-37f1-4386-8a5b-93aa73bf72c2' => Http::response($addressData),
		]);

		$client = new ApiClient();

		$address = $client->address('579fc246-37f1-4386-8a5b-93aa73bf72c2');

		$this->assertNotEmpty($address);

		$this->assertEquals($address->toArray(), $addressData);
	}

	public function testAutoCompleteReturnsResults() {
		$autoCompleteData = [
			'status' => 'success',
			'data' => [
				[
					'address' => 'some address',
					'id' => 'some-uuid',
					'link' => 'some link',
					'relevance' => 0.5,
				],
			],
			'count' => 1,
		];

		Http::fake([
			'https://ukaddresslookup.co.uk/api/v1/autocomplete/some%20search' => Http::response($autoCompleteData),
		]);

		$client = new ApiClient();

		$results = $client->autocomplete('some search');

		$this->assertNotEmpty($results);

		$this->assertEquals($results->data->first()->address, $autoCompleteData['data'][0]['address']);
	}

}
