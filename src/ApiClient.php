<?php

namespace Drewdan\UkAddressLookup;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Drewdan\UkAddressLookup\Models\Address;
use Drewdan\UkAddressLookup\Models\LookupResults;
use Drewdan\UkAddressLookup\Models\PostcodeResults;
use Drewdan\UkAddressLookup\Models\AutoCompleteResults;
use Drewdan\UkAddressLookup\Exceptions\CreditExhaustedException;
use Drewdan\UkAddressLookup\Exceptions\RateLimitExceededException;

class ApiClient {

	private readonly PendingRequest $client;

	public function __construct() {
		$this->client = Http::baseUrl('https://ukaddresslookup.co.uk/api/v1/')
			->withToken(config('ukaddresslookup.api_key'))
			->asJson()
			->throw();
	}

	public function postcode(string $postcode): LookupResults {
		try {
			$response = $this->client->get('postcode/' . $postcode)->json();
		} catch (\Exception $e) {
			match ($e->getCode()) {
				402 => throw new CreditExhaustedException(),
				429 => throw new RateLimitExceededException(),
				default => throw $e,
			};
		}

		return PostcodeResults::fromArray($response);
	}

	public function address(string $search): Address {
		$address = $this->client->get('address/' . $search)->json();

		return Address::fromArray($address);
	}

	public function autocomplete(string $search): LookupResults {
		$results = $this->client->get('autocomplete/' . $search)->json();

		return AutoCompleteResults::fromArray($results);
	}

}
