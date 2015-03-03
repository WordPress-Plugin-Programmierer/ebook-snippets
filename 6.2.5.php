<?php
/*
Plugin Name: Übersetzungsbeispiel
*/
$title = esc_attr__( 'Butter & Toast', 'mm_trans' );
echo '<a href="#" title="' . $title . '">' . __( 'Butter und Toast', 'mm_trans' ) . '</a>';
// gibt "Butter &amp; Toast" zurück