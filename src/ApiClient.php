<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class ApiClient {

	private readonly PendingRequest $client;

	public function __construct() {
		$this->client = Http::baseUrl('https://ukaddresslookup.co.uk/api/v1/')
			->withToken(config('ukaddresslookup.api_key'))
			->asJson()
			->throw();
	}

	public function postcode(string $postcode): Collection {
		$addresses = $this->client->get('postcode/' . $postcode)->json();

		if ($addresses['status'] === 'no results') {
			return collect();
		}

		return collect($addresses['data']);

	}

	public function address(string $search) {
		return $this->client->get('address', ['search' => $search]);
	}

}
