<?php get_header() ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="single-game complete-block">
                <div class="blue-head-block"><?php the_title() ?></div>
                <div class="block-content">
                    <?php
                    $img_data = getPostImages();
                    if (!empty($img_data)) :
                        ?>
                        <div id="example" class="simple-slider">
                            <div id="slides">
                                <div class="slide-border">
                                    <div class="slides_container">
                                    <?php foreach($img_data as $img) : ?>
                                    <div class="slide">
                                        <img src="<?php echo $img['url']?>" alt="<?php echo $img['alt'] ?>" width="760" height="450">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php endif; ?>
                    <div id="raiting_star">
                        <div id="raiting_info">  <img src="<?php echo get_template_directory_uri() ?>/img/load.gif" /> <h5>Рейтинг: </h5></div>
                        <div id="raiting">
                            <div id="raiting_blank"></div>
                            <div id="raiting_hover"></div>
                            <div id="raiting_votes"></div>
                        </div>
                    </div>
                    <?php postWithoutImages(); ?>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>

            <div class="random-games complete-block">
                <div class="blue-head-block">Случайные игры</div>
                <div class="block-content">
                    <table class="game-grid">
                        <thead></thead>
                        <tbody>
                        <tr>
                            <?php $counter = 1; ?>
                            <?php query_posts('posts_per_page=4 & orderby=rand'); ?>
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