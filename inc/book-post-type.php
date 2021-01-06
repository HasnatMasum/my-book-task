<?php
function mbt_register_post_type_book() {

    /**
     * Post Type: Books.
     */

    $labels = [
        "name"               => __( "Books", "my-book-task" ),
        "singular_name"      => __( "Book", "my-book-task" ),
        "menu_name"          => __( "My Books", "my-book-task" ),
        "all_items"          => __( "All Books", "my-book-task" ),
        "add_new_item"       => __( "Add New Book", "my-book-task" ),
        "edit_item"          => __( "Edit Book", "my-book-task" ),
        "new_item"           => __( "New Book", "my-book-task" ),
        "view_item"          => __( "View Book", "my-book-task" ),
        "view_items"         => __( "View Books", "my-book-task" ),
        "search_items"       => __( "Search Books", "my-book-task" ),
        "not_found"          => __( "No Books Found", "my-book-task" ),
        "not_found_in_trash" => __( "No Books Found in Trash", "my-book-task" ),
        "featured_image"     => __( "Book Cover", "my-book-task" ),
        "set_featured_image" => __( "Set Book Cover", "my-book-task" ),
    ];

    $args = [
        "label"                 => __( "Books", "my-book-task" ),
        "labels"                => $labels,
        "description"           => "",
        "public"                => true,
        "publicly_queryable"    => true,
        "show_ui"               => true,
        "show_in_rest"          => true,
        "rest_base"             => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive"           => true,
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "delete_with_user"      => false,
        "exclude_from_search"   => false,
        "capability_type"       => "post",
        "map_meta_cap"          => true,
        "hierarchical"          => true,
        "rewrite"               => ["slug" => "book", "with_front" => true],
        "query_var"             => true,
        "menu_position"         => 5,
        "menu_icon"             => "dashicons-book-alt",
        "supports"              => ["title", "editor", "thumbnail", "page-attributes"],
    ];

    register_post_type( "book", $args );

    /**
     * Taxonomy: Book Categories.
     */

    $labels = [
        "name"          => __( "Book Categories", "my-book-task" ),
        "singular_name" => __( "Book Categorie", "my-book-task" ),
        "menu_name"     => __( "Book Categories", "my-book-task" ),
        "all_items"     => __( "All Book Categories", "my-book-task" ),
        "edit_item"     => __( "Edit Book Categorie", "my-book-task" ),
        "view_item"     => __( "View Book Categorie", "my-book-task" ),
        "add_new_item"  => __( "Add New Book Categorie", "my-book-task" ),
    ];

    $args = [
        "label"                 => __( "Book Categories", "my-book-task" ),
        "labels"                => $labels,
        "public"                => true,
        "publicly_queryable"    => true,
        "hierarchical"          => true,
        "show_ui"               => true,
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "query_var"             => true,
        "rewrite"               => ['slug' => 'book_category', 'with_front' => true],
        "show_admin_column"     => false,
        "show_in_rest"          => true,
        "rest_base"             => "book_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit"    => false,
    ];
    register_taxonomy( "book_cat", ["book"], $args );

    /**
     * Taxonomy: Languages.
     */

    $labels = [
        "name"          => __( "Languages", "my-book-task" ),
        "singular_name" => __( "Language", "my-book-task" ),
        "menu_name"     => __( "Languages", "my-book-task" ),
        "all_items"     => __( "All Languages", "my-book-task" ),
        "edit_item"     => __( "Edit Language", "my-book-task" ),
        "view_item"     => __( "View Language", "my-book-task" ),
        "add_new_item"  => __( "Add New Language", "my-book-task" ),
    ];

    $args = [
        "label"                 => __( "Languages", "my-book-task" ),
        "labels"                => $labels,
        "public"                => true,
        "publicly_queryable"    => true,
        "hierarchical"          => false,
        "show_ui"               => true,
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "query_var"             => true,
        "rewrite"               => ['slug' => 'language', 'with_front' => true],
        "show_admin_column"     => false,
        "show_in_rest"          => true,
        "rest_base"             => "language",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit"    => false,
    ];
    register_taxonomy( "language", ["book"], $args );
}
