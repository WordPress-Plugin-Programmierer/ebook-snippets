<?php
/*
Plugin Name: Übersetzungsbeispiel
*/

$trans = esc_html_x( '<i>Stop & Send</i>', 'Label of the Stop-Button in the Meta-Box', 'mm_trans' );
echo '<button>' . $trans . '</button>';
// gibt <button>&lt;i&gt;Stop &amp; Send&lt;/i&gt;</button> aus
