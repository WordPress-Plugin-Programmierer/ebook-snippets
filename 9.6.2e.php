<?php
$current_plugins = array(
	'abc-plugin/abc-plugin.php' => array(
		'id'             => '',
		'slug'           => 'abc-plugin',
		'plugin'         => 'abc-plugin/abc-plugin.php',
		'new_version'    => '1.2.0',
		'url'            => 'http://my-website.com/abc-plugin/',
		'package'        => 'http://localhost/abc-plugin-1-2-0.zip',
		'upgrade_notice' => 'PLEASE BACKUP YOUR DATABASE BEFORE UPGRADING.',
		'name'           => 'ABC Plugin',
		'version'        => '1.2.0',
		'author'         => 'Max Mustermann',
		'requires'       => '3.6',
		'homepage'       => 'http://my-website.com/abc-plugin/',
		'downloaded'     => 999,
		'download_link'  => 'http://localhost/abc-plugin-1-2-0.zip',
		'external'       => true,
		'mm'             => true,
		'sections'       => array(
			'description'  => 'A plugin that updates itself.',
			'installation' => 'Please follow the instructions found in the documentation. Thanks!',
			'faq'          => '<h3>Question 1</h3><p>Answer 1</p><h3>Question 2</h3><p>Answer 2</p>',
			'screenshots'  => '',
			'changelog'    => '<ul><li>1.2.0<ul><li>Allows to show more plugin information.</li></ul></li><li>1.1.0<ul><li>Allows to update itself</li></ul></li><li>1.0.0<ul><li>Initial commit</li></ul></li></ul>',
			'other_notes'  => ''
		),
		'compatibility'  => array(
			'3.9.0' => array(
				'1.2.0' => array(
					0 => 99, // Kompatibilitätsangabe in Prozent
					1 => 100, // "Total" votes
					2 => 99 // "Works" votes
				)
			),
			'3.9.1' => array(
				'1.2.0' => array(
					0 => 99, // Kompatibilitätsangabe in Prozent
					1 => 200, // "Total" votes
					2 => 198 // "Works" votes
				)
			),
		)
	),
);
