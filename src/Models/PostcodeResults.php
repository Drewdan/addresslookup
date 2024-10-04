<?php

namespace Drewdan\UkAddressLookup\Models;

use Drewdan\UkAddressLookup\Enums\LookupStatusEnum;

class PostcodeResults extends LookupResults {

	public static function fromArray(array $data): self {
		return new self(
			data: collect($data['data'])->map(fn ($address) => Address::fromArray($address)),
			count: $data['count'],
			status: LookupStatusEnum::tryFrom($data['status']) ?? LookupStatusEnum::UNKNOWN,
		);
	}

}
