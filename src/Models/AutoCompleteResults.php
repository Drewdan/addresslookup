<?php

namespace Drewdan\UkAddressLookup\Models;

use Drewdan\UkAddressLookup\Models\LookupResults;
use Drewdan\UkAddressLookup\Enums\LookupStatusEnum;

class AutoCompleteResults extends LookupResults {

	public static function fromArray(array $data): self {
		return new self(
			data: collect($data['data'])->map(fn ($address) => AutoCompleteEntry::fromArray($address)),
			count: $data['count'],
			status: LookupStatusEnum::tryFrom($data['status']) ?? LookupStatusEnum::UNKNOWN,
		);
	}

}
