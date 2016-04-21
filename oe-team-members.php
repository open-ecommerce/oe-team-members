<?php
/*
  Plugin Name: OE Team Members
  Plugin URI: http://open-ecommerce.org/
  Description: Declares a plugin that will create a custom post type team members.
  Version: 1.0
  Author: Eduardo G. Silva
  Author URI: http://open-ecommerce.org/
  License: GPLv2
 */

add_action('init', 'create_team_members');
function create_team_members() {
    register_post_type('team_members', array(
        'labels' => array(
            'name' => 'Team Members',
            'singular_name' => 'Team Member',
            'add_new' => 'Add New Member',
            'add_new_item' => 'Add New Member',
            'edit' => 'Edit',
            'edit_item' => 'Edit Members',
            'new_item' => 'New Member',
            'view' => 'View',
            'view_item' => 'View Member',
            'search_items' => 'Search Member',
            'not_found' => 'No Member found',
            'not_found_in_trash' => 'No Member found in Trash',
            'parent' => 'Parent Member'
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('category'),
        'menu_icon' => plugins_url('images/oe-team-members.png', __FILE__),
        'query_var' => true,
        'rewrite' => array('slug' => 'member'),
        'has_archive' => true,
        'captability_type' => 'post',
        'hierarchical' => 'false'
            )
    );
}

add_action('admin_init', 'my_admin');
function my_admin() {
    add_meta_box('team_members_meta_box', 'Member Details', 'display_team_members_meta_box', 'team_members', 'normal', 'high');
}

function display_team_members_meta_box($team_members) {
    $team_members_order = get_post_meta($team_members->ID, 'team_members_order', true);
    $team_members_title = get_post_meta($team_members->ID, 'team_members_title', true);
    ?>
    <div class="small-12 large-8 columns">
        <table>
            <tr>
                <td style="width: 70px">Order</td>
                <td>
                    <input type="text" size="1"
                        name="team_members_order"
                        value="<?php echo $team_members_order; ?>" />
                </td>
            </tr>
            <tr>
                <td style="width: 70px">Org. Title</td>
                <td>
                    <input type="text" size="40"
                        name="team_members_title"
                        value="<?php echo $team_members_title; ?>" />
                </td>
            </tr>
    </table>
    </div>
    <?php
}


add_action('save_post', 'add_team_members_fields', 10, 2);
function add_team_members_fields($team_members_id, $team_members) {
    if ($team_members->post_type == 'team_members_order') {
        if (isset($_POST['team_members_order']) &&
                $_POST['team_members_order'] != '') {
            update_post_meta($team_members_id, 'team_members_order', esc_html($_POST['team_members_order']));
        }
        if (isset($_POST['team_members_title']) &&
                $_POST['team_members_title'] != '') {
            update_post_meta($team_members_id, 'team_members_title', sanitize_text_field($_POST['team_members_title']));
        }
    }
}



add_filter('manage_team_members_posts_columns' , 'add_team_members_columns');
function add_team_members_columns($columns) {
    return array_merge($columns,
              array('team_members_title' => __('Org. Title'),
                    'team_members_order' =>__( 'Order')));
}


add_action( 'manage_team_members_posts_custom_column' , 'my_custom_team_members_column' );
function my_custom_team_members_column( $column, $post_id ) {
    global $post;

    switch ( $column ) {
      case 'team_members_title':
        $orgtitle = get_post_meta( $post->ID , 'team_members_title' , true );
        if ( empty( $orgtitle ) )
            echo __( 'Not Set' );
            echo $orgtitle;
          break;
        case 'team_members_order':
            $order = get_post_meta( $post->ID, 'team_members_order', true );
            if ( empty( $order ) )
              echo __( 'Not Set' );
              echo $order;
            break;
    }
}














add_filter( 'manage_edit-team_members_sortable_columns', 'team_register_sortable_columns' );
function team_register_sortable_columns( $columns ) {
    $columns['team_members_order'] = 'Order';
    return $columns;
}


add_filter('template_include', 'include_template_function', 1);
function include_template_function($template_path) {
    if (get_post_type() == 'team_members') {
        if (is_single()) {
            if ($theme_file = locate_template(array
                ('single-team_members.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/single-team_members.php';
            }
        }
    }
    return $template_path;
}

function my_rewrite_flush() {
    create_team_members();
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'my_rewrite_flush')
?>
