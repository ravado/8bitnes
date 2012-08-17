<?php get_header(); ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left">
            <?php get_sidebar(); ?>
        </section>
dddd
        <section id="main-content">
            <div class="random-games complete-block">
                <div class="blue-head-block">Все игры</div>
                <div class="block-content">
                    <table class="game-grid">
                        <thead></thead>
                        <tbody>
                        <tr>
                            <?php $counter = 1; ?>
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
                                $counter = 0;
                            }
                            $counter++;
                            ?>
                            <?php endwhile; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <div class="clear-both"></div>
        </section>
        <div class="clear-both"></div>
            <?php if (function_exists('wp_corenavi')) wp_corenavi(); ?>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<?php get_footer(); ?>