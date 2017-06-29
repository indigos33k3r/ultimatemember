<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

wp_enqueue_script( 'postbox' );
wp_enqueue_media ();

do_action( 'um_roles_add_meta_boxes', 'um_role_meta', '' );
do_action( 'um_roles_add_meta_boxes_um_role_meta' , '' );

$data = array();
$option = array();
global $wp_roles;

if ( ! empty( $_GET['id'] ) ) {
    $data = get_option( "um_role_{$_GET['id']}_meta" );

    if ( empty( $data['_um_is_custom'] ) )
        $data['name'] = $wp_roles->roles[ $_GET['id'] ]['name'];
}


if ( ! empty( $_POST['role'] ) ) {

    $data = $_POST['role'];

    $id = '';
    $redirect = '';
    $error = '';

    if ( empty( $data['name'] ) ) {

        $error .= __( 'Title is empty!', 'ultimatemember' ) . '<br />';

    } else {

        if ( 'add' == $_GET['tab'] ) {
            $id = sanitize_title( $data['name'] );
            $redirect = add_query_arg( array( 'page'=>'um_roles', 'msg'=>'a' ), admin_url( 'admin.php' ) );
        } elseif ( 'edit' == $_GET['tab'] && ! empty( $_GET['id'] ) ) {
            $id = $_GET['id'];
            $redirect = add_query_arg( array( 'page' => 'um_roles', 'msg'=>'u' ), admin_url( 'admin.php' ) );
        }

    }

    $all_roles = array_keys( get_editable_roles() );
    if ( 'add' == $_GET['tab'] ) {
        if ( in_array( 'um_' . $id, $all_roles ) )
            $error .= __( 'Role already exists!', 'ultimatemember' ) . '<br />';
    }

    if ( '' == $error ) {

        if ( 'add' == $_GET['tab'] ) {
            $roles = get_option( 'um_roles' );
            $roles[] = $id;

            update_option( 'um_roles', $roles );
        }

        $role_meta = $data;
        unset( $role_meta['id'] );

        update_option( "um_role_{$id}_meta", $role_meta );

        um_js_redirect( $redirect );
    }
}

global $current_screen;
$screen_id = $current_screen->id; ?>

<script type="text/javascript">
    jQuery( document ).ready( function() {
        postboxes.add_postbox_toggles( '<?php echo $screen_id; ?>' );
    });
</script>

<div class="wrap">
    <h2>
        <?php echo ( 'add' == $_GET['tab'] ) ? __( 'Add New Role', 'ultimatemember' ) : __( 'Edit Role', 'ultimatemember' ) ?>
        <?php if ( 'edit' == $_GET['tab'] ) { ?>
            <a class="add-new-h2" href="<?php echo add_query_arg( array( 'page' => 'um_roles', 'tab' => 'add' ), admin_url( 'admin.php' ) ) ?>"><?php _e( 'Add New', 'ultimatemember' ) ?></a>
        <?php } ?>
    </h2>

    <?php if ( ! empty( $error ) ) { ?>
        <div id="message" class="error fade">
            <p><?php echo $error ?></p>
        </div>
    <?php } ?>

    <form id="um_edit_role" action="" method="post">
        <input type="hidden" name="role[id]" value="<?php echo isset( $_GET['id'] ) ? $_GET['id'] : '' ?>" />
        <?php if ( 'add' == $_GET['tab'] ) { ?>
            <input type="hidden" name="role[_um_is_custom]" value="1" />
        <?php } else { ?>
            <input type="hidden" name="role[_um_is_custom]" value="<?php echo ! empty( $data['_um_is_custom'] ) ? 1 : 0 ?>" />
        <?php } ?>
        <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <div id="titlediv">
                        <div id="titlewrap">
                            <?php if ( 'add' == $_GET['tab'] ) { ?>
                                <label for="title" class="screen-reader-text"><?php _e( 'Title', 'ultimatemember' ) ?></label>
                                <span>UM&nbsp;</span><input type="text" name="role[name]" placeholder="<?php _e( 'Enter Title Here', 'ultimatemember' ) ?>" id="title" value="<?php echo isset( $data['name'] ) ? $data['name'] : '' ?>" />
                            <?php } else { ?>
                                <input type="hidden" name="role[name]" value="<?php echo isset( $data['name'] ) ? $data['name'] : '' ?>" />
                                <span style="float: left;width:100%;"><?php if ( ! empty( $data['_um_is_custom'] ) ) { ?>UM&nbsp;<?php } ?><?php echo isset( $data['name'] ) ? $data['name'] : '' ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div id="postbox-container-1" class="postbox-container">
                    <?php do_meta_boxes( 'um_role_meta', 'side', array( 'data' => $data, 'option' => $option ) ); ?>
                </div>
                <div id="postbox-container-2" class="postbox-container">
                    <?php do_meta_boxes( 'um_role_meta', 'normal', array( 'data' => $data, 'option' => $option ) ); ?>
                </div>
            </div>
        </div>
    </form>
</div>