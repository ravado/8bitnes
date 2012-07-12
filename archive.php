<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 10.07.12
 * Time: 19:13
 * To change this template use File | Settings | File Templates.
 */
?>
<?php get_header() ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">
            <?php if (is_category());
                $cat_id = get_query_var('cat');
                $cat = get_category($cat_id);
            ?>
            <div class="random-games complete-block">
                <div class="blue-head-block"><?php echo $cat->cat_name; ?></div>
                <div class="block-content">
                    <table class="game-grid">
                        <thead></thead>
                        <tbody>
                        <tr>
                            <?php $counter = 1;
                            ?>
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