<?php get_header() ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php increaseViews();
                if(get_post_format($post->ID) == 'image') {
                    get_template_part('game_review');
                } else {
                    get_template_part('default_post');
                }?>
                <input type="hidden" id="post_id" value="<?php echo get_the_ID() ?>">
            <?php endwhile; ?>
            <?php endif; ?>

            <div class="random-games complete-block">
                <div class="blue-head-block">Случайные игры</div>
                <div class="block-content">
                    <table class="game-grid">
                        <thead></thead>
                        <tbody>
                        <tr>
                            <?php $counter = 1; $arg = array(
                            'post_type'=> 'post',
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'orderby' => 'rand',
                            'posts_per_page' => 4,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'post_format',
                                    'field' => 'slug',
                                    'terms' => array( 'post-format-image' )
                                )
                            ));?>
                            <?php query_posts($arg); ?>
                            <?php while (have_posts()) : the_post(); ?>
                            <td>
                                <div class="game-item">
                                    <div class="head-orange">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php contentPart('url'); ?>" alt="<?php contentPart('alt'); ?>" width="176" height="120">
                                            </a>
                                        </div>
                                        <div class="item-decription">
                                            <p><?php contentPart('rev'); ?></p>
                                        </div>
                                        <div class="item-info">
                                            <span class="item-genre">
                                                <p>Жанр:
                                                    <?php $categories = get_the_category(); ?>
                                                    <a href="<?php echo get_category_link($categories[0]->cat_ID); ?>"><?php echo $categories[0]->name; ?></a>
                                                </p>
                                            </span>
                                            <span class="item-rating">
                                                <span class="item-rating-icon"></span>
                                                <p>8.8</p>
                                            </span>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </td>
                            <?php
                            if($counter == 4) {
                                echo '</tr><tr>';
                            }
                            $counter++;
                            ?>
                            <?php endwhile; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="clear-both"></div>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<?php get_footer() ?>