<?php
return array(
	"title" => __("Contact Info", "striking_admin"),
	"shortcode" => 'contact_info',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Color (optional)",'striking_admin'),
			"id" => "color",
			"default" => "",
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"black" => 'Black',
				"gray" => 'Gray',
				"red" => 'Red',
				"yellow" => 'Yellow',
				"blue" => 'Blue',
				"pink" => 'Pink',
				"green" => 'Green',
				"rosy" => 'Rosy',
				"orange" => 'Orange',
				"magenta" => 'Magenta',
			),
			"type" => "select",
		),
		array(
			"name" => __("Phone",'striking_admin'),
			"id" => "phone",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("Cell Phone",'striking_admin'),
			"id" => "cellphone",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("Fax",'striking_admin'),
			"id" => "fax",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("email",'striking_admin'),
			"id" => "email",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("link",'striking_admin'),
			"id" => "link",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Address",'striking_admin'),
			"id" => "address",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("City",'striking_admin'),
			"id" => "city",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("State",'striking_admin'),
			"id" => "state",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("Zip",'striking_admin'),
			"id" => "zip",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
		array(
			"name" => __("Name",'striking_admin'),
			"id" => "name",
			"default" => "",
			"size" => 30,
			"type" => "text"
		),
	),
);
