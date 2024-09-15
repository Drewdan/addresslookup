<?php

namespace Models;

class Address {

	public function __construct(
		public string $uuid,
		public string $organisation_name,
		public string $sub_property_name,
		public string $sub_property_number,
		public string $property_name,
		public string $property_number,
		public string $full_address,
		public string $address_line_1,
		public string $address_line_2,
		public string $locality,
		public string $district,
		public string $town_or_city,
		public string $county,
		public string $country,
		public string $postcode,
		public string $language_code,
	) {
	}

	public static function fromArray(array $data): self {
		return new self(
			uuid: $data['uuid'],
			organisation_name: $data['property']['organisation_name'],
			sub_property_name: $data['property']['sub_property_name'],
			sub_property_number: $data['property']['sub_property_number'],
			property_name: $data['property']['property_name'],
			property_number: $data['property']['property_number'],
			full_address: $data['full_address'],
			address_line_1: $data['address_line_1'],
			address_line_2: $data['address_line_2'],
			locality: $data['locality'],
			district: $data['district'],
			town_or_city: $data['city'],
			county: $data['county'],
			country: $data['country'],
			postcode: $data['postcode'],
			language_code: $data['language_code'],
		);
	}

	public function toArray(): array {
       return [
		   'id' => $this->uuid,
		   'property' => [
			   'organisation_name' => $this->organisation_name === '' ? null : $this->organisation_name,
			   'sub_property_name' => $this->sub_property_name,
			   'sub_property_number' => $this->sub_property_number,
			   'property_name' => $this->property_name === '' ? null : $this->property_name,
			   'property_number' => $this->property_number,
		   ],
		   'full_address' => $this->full_address,
		   'address_line_1' => $this->line_1,
		   'address_line_2' => $this->line_2,
		   'locality' => $this->locality,
		   'district' => $this->district,
		   'city' => $this->town_or_city,
		   'county' => $this->county,
		   'country' => $this->country,
		   'postcode' => $this->postcode,
		   'language_code' => $this->language_code ?? 'en',
	   ];
	}

}
