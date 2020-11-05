<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'twentyseventeen-panel ' ); ?> >

	<?php
	if ( has_post_thumbnail() ) :
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'twentyseventeen-featured-image' );

		// Calculate aspect ratio: h / w * 100%.
		$ratio = $thumbnail[2] / $thumbnail[1] * 100;
		?>

		<div class="panel-image" style="background-image: url(<?php echo esc_url( $thumbnail[0] ); ?>);">
			<div class="panel-image-prop" style="padding-top: <?php echo esc_attr( $ratio ); ?>%"></div>
		</div><!-- .panel-image -->

	<?php endif; ?>

	<div class="panel-content">
		<div class="wrap">
			<header class="entry-header">
 				<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

				<?php twentyseventeen_edit_link( get_the_ID() ); ?>

			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
					the_content(
						sprintf(
							/* translators: %s: Post title. */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
							get_the_title()
						)
					);
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
							'after'  => '</div>',
						)
					);
					?>
			</div><!-- .entry-content -->

		</div><!-- .wrap -->
	</div><!-- .panel-content -->

</article><!-- #post-<?php the_ID(); ?> -->
<!--  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

<?php 
// query the user media
$fields = "id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username";
$token = "27c50a0a301fc6ba88d7a27e5784a2de";
$limit = 10;
 
// $json_feed_url="https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
$json_feed_url='https://graph.instagram.com/access_token?grant_type=ig_exchange_token&&client_secret=eb87G...&access_token={$token}';

$json_feed = @file_get_contents($json_feed_url);
$contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);
//  $contents = [{
// 	 id:"hi vipisanan",
// 	 caption:"hi vipisanan",
// 	 media_type:"hi vipisanan",
// 	 media_url:"hi vipisanan",
// 	 permalink:"hi vipisanan",
// 	 thumbnail_url:"hi vipisanan",
// 	 timestamp:"hi vipisanan",
// 	 username:"hi vipisanan",
//  }];
//
$contents = array(
    array(
        "region" => "valore",
        "price" => "valore2"
    ),
    array(
        "region" => "valore",
        "price" => "valore2"
    ),
    array(
        "region" => "valore",
        "price" => "valore2"
    )
);

echo "<div class='ig_feed_container'>";
print $contents;

    foreach($contents as $post){
         
        $username = isset($post["username"]) ? $post["username"] : "";
        $caption = isset($post["caption"]) ? $post["caption"] : "";
        $media_url = isset($post["media_url"]) ? $post["media_url"] : "";
        $permalink = isset($post["permalink"]) ? $post["permalink"] : "";
        $media_type = isset($post["media_type"]) ? $post["media_type"] : "";
         
        echo "
            <div class='ig_post_container'>
                <div>";
 
                    if($media_type=="VIDEO"){
                        echo "<video controls style='width:100%; display: block !important;'>
                            <source src='{$media_url}' type='video/mp4'>
                            Your browser does not support the video tag.
                        </video>";
                    }
 
                    else{
                        echo "<img src='{$media_url}' />";
                    }
                 
                echo "</div>
                <div class='ig_post_details'>
                    <div>
                        <strong>@{$username}</strong> {$caption}
                    </div>
                    <div class='ig_view_link'>
                        <a href='{$permalink}' target='_blank'>View on Instagram</a>
                    </div>
                </div>
            </div>
        ";
    }
echo "</div>"
?>
