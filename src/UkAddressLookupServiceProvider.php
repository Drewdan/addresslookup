<?php

namespace Drewdan\UkAddressLookup;

use Illuminate\Support\ServiceProvider;

class UkAddressLookupServiceProvider extends ServiceProvider {

	public function register(): void {
		$this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ukaddresslookup');
	}

	public function boot() {

	}

}
