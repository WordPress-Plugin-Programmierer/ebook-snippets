<?php
/*
Plugin Name: Klammern
*/
// Nicht empfohlen:
if( $c1 )
{
	action1();
}
elseif( $c2 )
{
	action2();
}
elseif( $c3 )
{
	action3();
}
else
{
	action4();
}

// Empfohlen:
if ( $c1 ){
	action1();
} elseif ( $c2 ) {
	action2();
} elseif ( $c3 ) {
	action3();
} else {
	action4();
} // End of condition check
