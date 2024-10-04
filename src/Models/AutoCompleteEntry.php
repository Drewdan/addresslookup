<?php

namespace Drewdan\UkAddressLookup\Models;

class AutoCompleteEntry {

	public function __construct(
		public string $address,
		public string $id,
		public string $link,
		public float $relevance,
	) {
	}

	public static function fromArray(array $data): self {
		return new self(
			address: $data['address'],
			id: $data['id'],
			link: $data['link'],
			relevance: $data['relevance'],
		);
	}

}
