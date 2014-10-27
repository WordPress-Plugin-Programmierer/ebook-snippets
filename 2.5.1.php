<?php
/*
Plugin Name: Mein erstes Plugin
*/

$url = 'http://beispiel.de';

// Nicht empfohlen:
echo "<a href='$url'>Dies ist eine URL</a>";

// Empfohlen:
echo '<a href="' . $url . '">Dies ist eine URL</a>';
