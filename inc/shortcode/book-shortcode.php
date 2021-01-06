<?php
function mbt_book_shortcode() {
    add_shortcode( 'book', 'mbt_book_shortcode_register' );
}

function mbt_book_shortcode_register( $atts,$content=null) {
    
    $atts = shortcode_atts( array(
        'type'      => 'book',
        'count'     => ( isset( $atts['count'] ) ) ? $atts['count'] : '-1',
        'cat'       => ( isset( $atts['cat'] ) ) ? $atts['cat'] : '',
        'author'    => ( isset( $atts['author'] ) ) ? $atts['author'] : '',
        'publisher' => ( isset( $atts['publisher'] ) ) ? $atts['publisher'] : '',
    ), $atts );

    if(!empty($atts['cat'] )){
        $args = array(
            'post_type'      => $atts['type'],
            'posts_per_page' => $atts['count'],
            'tax_query'      => array(
                array(
                    'taxonomy' => 'book_cat',
                    'field'    => 'slug',
                    'terms'    => $atts['cat'],
                ),
    
            ),
    
            'meta_query'     => array(
                'relation' => 'AND',
    
                array(
                    'key'     => 'author_name',
                    'value'   => strtolower($atts['author']),
                    'compare' => '=',
                ),
                array(
                    'key'     => 'publisher',
                    'value'   => strtolower($atts['publisher']),
                    'compare' => '=',
                ),
    
            ),
        );
        $books = new WP_Query( $args );
    }else{
        $args = array(
            'post_type'      => $atts['type'],
            'posts_per_page' => $atts['count'],
        );
        $books = new WP_Query( $args );
    }
    
    if ( !$books->have_posts() ) {
        return '<h2>There is no post what you search.</h2>';
    }
    while ( $books->have_posts() ) {
        $books->the_post();
        $meta = get_post_meta( get_the_ID() );
        $post_thum = get_the_post_thumbnail(get_the_ID(), 'large' );
        $mbt_title = get_the_title();
        $mbt_content = wp_trim_words( get_the_content(), 20 );
        $read_more = __('Read More >>','my-book-task');
        $permalink = get_the_permalink();
        $mbt_author = $meta['author_name'][0];
        $mbt_edition = $meta['edition'][0];
        $mbt_publisher = $meta['publisher'][0];
        $mbt_year = $meta['year'][0];
        $mbt_url = $meta['url'][0];
        $mbt_price = $meta['price'][0];

        $content = <<<EOT
        <div class="shortcode-content-wrap>
            <div class="stc-thumb>{$post_thum}</div>
            <h2>{$mbt_title}</h2>
            <p class="stc-content">{$mbt_content}</p>
            <p class="stc-readmore"><a href="{$permalink}">{$read_more}</a></p>
            <div class="stc-book-info"> 
                <p class="stc-author">Author: <strong>{$mbt_author}</strong></p>
                <p class="stc-edition">Edition: <strong>{$mbt_edition}</strong></p>
                <p class="stc-publisher">Publisher: <strong>{$mbt_publisher}</strong></p>
                <p class="stc-year">Year: <strong>{$mbt_year}</strong></p>
                <p class="stc-url">Url: <strong>{$mbt_url}</strong></p>
                <p class="stc-price">Price: <strong>{$mbt_price}</strong></p>
            </div>
        </div>
EOT;

 return $content;

    }
    
    wp_reset_query();
    
}

// Display Shortcode in Column
function mbt_shortcode_column($columns){
    print_r($columns);
    unset($columns['date']);
    $columns['shortcode'] = __('Shortcode: [book]  <strong>default count="-1"</strong>','my-book-task');
    $columns['date'] = __('Date','my-book-task');
    return $columns;
}
add_filter('manage_book_posts_columns', 'mbt_shortcode_column');

// Shortcode Display for every column
function mbt_shortcode_every_column($column,$post_id){
    $s_meta = get_post_meta($post_id);
    $mbt_tax = get_the_terms( $post_id, 'book_cat' );
    echo '[book cat="'.$mbt_tax[0]->slug.'" author="'.$s_meta['author_name'][0].'" publisher="'.$s_meta['publisher'][0].'"] <strong>Use One cat name</strong>';
}
add_action('manage_book_posts_custom_column','mbt_shortcode_every_column',10,2);