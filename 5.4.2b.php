<?php
$age    = isset( $_POST['age'] ) ? abs( $_POST['age'] ) : 0;
$gender = '';

if ( isset( $_POST['gender'] ) && in_array( $_POST['gender'], array( 'm', 'w' ) ) ) {
	$gender = $_POST['gender'];
}

speichere( $age, $gender );