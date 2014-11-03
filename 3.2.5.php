<?php
/*
Plugin Name: Remove Actions
*/


# Entfernt alle Funktionen der Action 'wp_head' mit der Priorität 10
remove_all_actions( 'wp_head', 10 );