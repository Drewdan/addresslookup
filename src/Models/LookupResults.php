<?php

namespace Drewdan\UkAddressLookup\Models;

use Illuminate\Support\Collection;
use Drewdan\UkAddressLookup\Enums\LookupStatusEnum;

class LookupResults {

	public function __construct(
		public Collection $data,
		public int $count,
		public LookupStatusEnum $status,
	) {
	}

}
