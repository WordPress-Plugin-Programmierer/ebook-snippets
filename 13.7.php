<?php
/*
Plugin Name: Überprüfung auf Eltern-Term
*/

// Ist ID 18 (Krimi) ein Kindelement von 20 (Belletristik)?
var_dump( term_is_ancestor_of( 20, 18, 'category' ) ); // gibt true

// Ist ID 20 (Belletristik) ein Kindelement von ID 18 (Krimi)
var_dump( term_is_ancestor_of( 18, 20, 'category' ) ); // gibt false

// Ist ID 21 (Klassiker) ein Kindelement von ID 20 (Belletristik)?
var_dump( term_is_ancestor_of( 20, 21, 'category' ) ); // gibt true
