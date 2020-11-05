<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>




<div class="wrap">



    <?php
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.instagram.com/vipisanan/?__a=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "x-rapidapi-host: hashtagy-generate-hashtags.p.rapidapi.com",
            "x-rapidapi-key: SIGN-UP-FOR-KEY"
        ),
    ));


    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $object = $response;
        $json_data = json_decode($response , true);
        echo '<script language="javascript">';
        echo 'console.log('. json_encode( $json_data['graphql']['user']['edge_owner_to_timeline_media']['edges']) .')';
        echo '</script>';
?>
    <div class="row">
    <?php
        foreach ($json_data['graphql']['user']['edge_owner_to_timeline_media']['edges'] as $node){
            ?>
                <div class="col col-3">
                    <div class="front alert ">
                        <?php
                        $img = $node['node']['thumbnail_src'];
                        echo "<img src='$img' width='180px' height='200px'>";
                         ?>
                    </div>
                </div>
                <?php
        }
        ?>
    </div>
        <?php
    }
    ?>

	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : ?>
	<header class="page-header">
		<h2 class="page-title"><?php _e( 'Posts', 'twentyseventeen' ); ?></h2>
	</header>
	<?php endif; ?>



	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


			<?php
			if ( have_posts() ) :

				// Start the Loop.
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that
					 * will be used instead.
					 */
//					get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile;

				the_posts_pagination(
					array(
						'prev_text'          => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
						'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
					)
				);

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<!--	--><?php //get_sidebar(); ?>
</div><!-- .wrap -->

<?php
get_footer();
