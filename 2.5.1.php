<?php
/*
Plugin Name: Mein erstes Plugin
*/

$url = 'http://beispiel.de';

// B1: Nicht empfohlen:
echo "<a href='$url'>Dies ist eine URL</a>";

// B2: Nicht empfohlen:
echo "<a href="\$url\">Dies ist eine URL</a>";

// B3: Empfohlen:
echo '<a href="' . $url . '">Dies ist eine URL</a>';
