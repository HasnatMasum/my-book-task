<?php
//Create metabox
function mbt_book_metabox() {
    add_meta_box(
        'mbt_book_met', // Id
        __( 'Book Information', 'my-book-task' ), // Title
        'mbt_book_metabox_callback', // Callback
        'book', // Screen
        'normal', // Context
        'default' // Priority

    );
}

// Callback for meta
function mbt_book_metabox_callback( $book_id ) {

    // Add nonce for security and authentication.
    wp_nonce_field( 'mbt_book_meta_action', 'mbt_book_meta_nonce' );
    $author_name = get_post_meta( $book_id->ID, 'author_name', true );
    $edition     = get_post_meta( $book_id->ID, 'edition', true );
    $publisher   = get_post_meta( $book_id->ID, 'publisher', true );
    $year        = get_post_meta( $book_id->ID, 'year', true );
    $price       = get_post_meta( $book_id->ID, 'price', true );
    $url         = get_post_meta( $book_id->ID, 'url', true );

    ?>
<p>
    <label for="author_name"><?php _e( 'Author Name', 'my-book-task' );?></label>
    <input class="widefat" type="text" name="author_name" id="author_name"
        value="<?php echo esc_attr( $author_name ); ?>">
</p>
<p>
    <label for="edition"><?php _e( 'Edition', 'my-book-task' );?></label>
    <input class="widefat" type="text" name="edition" id="edition" value="<?php echo esc_attr( $edition ); ?>">
</p>
<p>
    <label for="publisher"><?php _e( 'Publisher', 'my-book-task' );?></label>
    <input class="widefat" type="text" name="publisher" id="publisher" value="<?php echo esc_attr( $publisher ); ?>">
</p>

<p>
    <label for="year"><?php _e( 'Year', 'my-book-task' );?></label>
    <input class="widefat" type="text" name="year" id="year" value="<?php echo esc_attr( $year ); ?>">
</p>
<p>
    <label for="price"><?php _e( 'Price', 'my-book-task' );?></label>
    <input class="widefat" type="text" name="price" id="price" value="<?php echo esc_attr( $price ); ?>">
</p>
<p>
    <label for="url"><?php _e( 'URL', 'my-book-task' );?></label>
    <input class="widefat" type="text" name="url" id="url" value="<?php echo esc_url( $url ); ?>">
</p>
<?php
}

// Save book meta information
function mbt_save_book_metabox( $book_id ) {

    //check if nonce is set
    if ( !isset( $_POST['mbt_book_meta_nonce'] ) ) {
        return;
    }

    //check if nonce is valid
    if ( !wp_verify_nonce( $_POST['mbt_book_meta_nonce'], 'mbt_book_meta_action' ) ) {
        return;
    }

    //if input is not set
    if ( !isset( $_POST['author_name'] ) || !isset( $_POST['edition'] ) || !isset( $_POST['publisher'] ) || !isset( $_POST['year'] ) || !isset( $_POST['price'] ) || !isset( $_POST['url'] ) ) {
        return;
    }

    if ( isset( $_POST['post_type'] ) && 'book' === $_POST['post_type'] ) {

        $author_name = sanitize_text_field( $_POST['author_name'] );
        $edition     = sanitize_text_field( $_POST['edition'] );
        $publisher   = sanitize_text_field( $_POST['publisher'] );
        $year        = sanitize_text_field( $_POST['year'] );
        $price       = sanitize_text_field( $_POST['price'] );
        $url         = sanitize_text_field( $_POST['url'] );

        // update information
        update_post_meta( $book_id, 'author_name', $author_name );
        update_post_meta( $book_id, 'edition', $edition );
        update_post_meta( $book_id, 'publisher', $publisher );
        update_post_meta( $book_id, 'year', $year );
        update_post_meta( $book_id, 'price', $price );
        update_post_meta( $book_id, 'url', $url );
    }
}
