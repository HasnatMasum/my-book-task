<?php
function mbt_dashboard_widget() {
    if ( current_user_can( 'manage_options' ) ) {
        wp_add_dashboard_widget(
            'mbt-dashboard-widget',
            __( 'Book Categoris', 'my-book-task' ),
            'mbt_dashboard_widget_callback'
        );
    }
}

function mbt_dashboard_widget_callback() {

    wp_list_categories( array(
        'taxonomy'         => 'book_cat',
        'orderby'          => 'count',
        'order'            => 'DESC',
        'style'            => '',
        'show_count'       => 1,
        'number'           => 5,
        'show_option_none' => __( 'Book Categories Not Found', 'my-book-task' ),
    ) );

}
