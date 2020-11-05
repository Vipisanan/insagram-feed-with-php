<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>
    <style>
        body {
            /*padding: 2em;*/
        }
        .card {
            border: none;
        }
        img,
        .card-img-top {
            border-radius: 0em;
        }

        @media (min-width: 576px) {
            .card-columns {
                column-count: 2;
            }
        }

        @media (min-width: 768px) {
            .card-columns {
                column-count: 3;
            }
        }

        @media (min-width: 992px) {
            .card-columns {
                column-count: 4;
            }
        }

        @media (min-width: 1200px) {
            .card-columns {
                column-count: 5;
            }
        }

    </style>
<?php

$json_feed_url = "https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
$json_feed = @file_get_contents($json_feed_url);
$json_instagram_feeds =json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);

function get_insta_feed($url)
{
    $json_feed = @file_get_contents($url);
    return json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);
}

?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php
                while (have_posts()) :
                    the_post();

                    get_template_part('template-parts/page/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                endwhile; // End the loop.
                echo '<script language="javascript">';
                echo 'console.log(' . get_insta_feed($json_feed_url) . ')';
                echo '</script>';

                ?>
                <div>
                    Impossible is just a big word thrown around by small men who find it easier to live in the world they’ve been given than to explore the power they have to change it.                    <br>
                    <br>
                    <br>
                </div>

<!--                <div class="row">-->
<!--                    --><?php
//                    foreach (get_insta_feed($json_feed_url)['data'] as $node) {
//                        ?>
<!--                        <div class="col col-4">-->
<!--                            <div class="front alert ">-->
<!--                                --><?php
//                                $img = $node['media_url'];
//                                echo "<img src='$img' width='180px' height='200px'>";
//                                ?>
<!--                            </div>-->
<!--                        </div>-->
<!--                        --><?php
//                    }
//                    ?>
<!--                </div>-->

                <div class="container">
                    <div class="card-columns">
                        <?php
                        foreach ($json_instagram_feeds['data'] as $node) {
                            ?>
                            <div class="card ">
                                <?php
                                $img = $node['media_url'];
                                echo "<img class=\"card-img-top\"
                                                    src='$img'
                                                    >"
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>


            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->

<?php
get_footer();
