<?php

namespace Drewdan\UkAddressLookup\Enums;

enum LookupStatusEnum: string {

	case SUCCESS = 'success';
	case NO_RESULTS = 'no results';

	case UNKNOWN = 'unknown';

}
