<div class="um-admin-metabox">

	<?php $role = $object['data'];

    UM()->admin_forms( array(
        'class'		=> 'um-role-delete um-half-column',
        'prefix_id'	=> 'role',
        'fields' => array(
            array(
                'id'		    => '_um_after_delete',
                'type'		    => 'select',
                'name'		    => '_um_after_delete',
                'label'    		=> __( 'Action to be taken after account is deleted', 'ultimatemember' ),
                'description' 	=> __( 'Select what happens when a user with this role deletes their own account', 'ultimatemember' ),
                'value' 		=> ! empty( $role['_um_after_delete'] ) ? $role['_um_after_delete'] : array(),
                'options'		=> array(
                    'redirect_home' => __( 'Go to Homepage', 'ultimatemember' ),
                    'redirect_url'	=> __( 'Go to Custom URL', 'ultimatemember' ),
                )
            ),
            array(
                'id'		=> '_um_delete_redirect_url',
                'type'		=> 'text',
                'name'		=> '_um_delete_redirect_url',
                'label'    		=> __( 'Set Custom Redirect URL', 'ultimatemember' ),
                'description' 	=> __( 'Set a url to redirect this user role to after they delete account', 'ultimatemember' ),
                'value' 		=> ! empty( $role['_um_delete_redirect_url'] ) ? $role['_um_delete_redirect_url'] : '',
                'conditional'	=> array( '_um_after_delete', '=', 'redirect_url' )
            )
        )
    ) )->render_form(); ?>
	
</div>