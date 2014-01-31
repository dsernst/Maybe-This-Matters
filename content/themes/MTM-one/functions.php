<?php

function my_custom_roles( $role, $user_id, $user_role ) {
	if( $role == 'Keymaster' )
		return 'Forum Admin';
 
	return $role;
}
 
add_filter( 'bbp_get_user_display_role', 'my_custom_roles', 10, 3 );


?>