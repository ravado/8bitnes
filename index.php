<?php get_header(); ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">
            <div id="container">
                <div id="example">
                    <div id="slides">
                        <div class="slide-border">
                            <div class="slides_container">
                                <?php foreach (getTopGames(5) as $top_game ):?>
                                <div class="slide">
                                    <a href="<?php echo get_permalink($top_game->ID); ?>" title="<?php echo $top_game->post_title; ?>" >
                                        <img src="<?php contentPart('url',$top_game->post_content) ?>" width="700" height="380" alt="<?php contentPart('alt',$top_game->post_content); ?>">
                                    </a>
                                    <div class="caption">
                                        <a href="<?php echo get_permalink($top_game->ID); ?>">
                                            <p><?php echo $top_game->post_title; ?></p>
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <a href="#" class="prev"></a>
                        <a href="#" class="next"></a>
                    </div>
                </div>

            </div>
        <div class="popular-games complete-block">
            <div class="blue-head-block">Популярные игры</div>
            <div class="block-content">
                <table class="game-grid">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <?php $counter = 1; ?>
                            <?php foreach(getPopularGames(8) as $popular_game): ?>
                            <td>
                                <div class="game-item">
                                    <div class="head-orange">
                                        <h3>
                                            <a href="<?php echo get_permalink($popular_game->ID); ?>"><?php echo $popular_game->post_title; ?></a>
                                        </h3>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-image">
                                            <a href="<?php echo get_permalink($popular_game->ID); ?>">
                                                <img src="<?php contentPart('url',$popular_game->post_content); ?>" alt="<?php contentPart('alt',$popular_game->post_content); ?>" width="176" height="120">
                                            </a>
                                        </div>
                                        <div class="item-decription">
                                            <p><?php contentPart('rev',$popular_game->post_content); ?></p>
                                        </div>
                                        <div class="item-info">
                                            <span class="item-genre">
                                                <p>Жанр:
                                                    <?php $categories = get_the_category($popular_game->ID); ?>
                                                    <a href="<?php echo get_category_link($categories[0]->cat_ID); ?>"><?php echo $categories[0]->name; ?></a>
                                                </p>
                                            </span>
                                            <span class="item-rating">
                                                <span class="item-rating-icon"></span>
                                                <p><?php echo $popular_game->post_rating ?></p>
                                            </span>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </td>
                            <?php
                                if($counter == 4) {
                                    echo '</tr><tr>';
                                    $counter = 0;

                                }
                                $counter++;
                            ?>
                            <?php endforeach; ?>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="random-games complete-block">
            <div class="blue-head-block">Случайные игры</div>
            <div class="block-content">
                <table class="game-grid">
                    <thead></thead>
                    <tbody>
                    <tr>
                        <?php $counter = 1;
                        $arg = array(
                            'post_type'=> 'post',
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'orderby' => 'rand',
                            'posts_per_page' => 8,
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
                                                <p><?php echo $post->post_rating; ?></p>
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
            <div class="">
                <a href="/category/games" class="btn-all-games">Все игры</a>
            </div>

            <div class="clear-both"></div>
        </div>
        <div class="clear-both"></div>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<?php get_footer(); ?>