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
                                <?php query_posts('posts_per_page=5 & orderby=rand'); ?>
                                <?php while (have_posts()) : the_post(); ?>
                                <div class="slide">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
                                        <img src="<?php contentPart('url'); ?>" width="700" height="380" alt="<?php contentPart('alt'); ?>">
                                    </a>
                                    <div class="caption">
                                        <a href="<?php the_permalink(); ?>">
                                            <p><?php the_title(); ?></p>
                                        </a>
                                    </div>
                                </div>
                                <?php endwhile;?>
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
                            <?php query_posts('posts_per_page=8 & orderby=rand'); ?>
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
        <div class="random-games complete-block">
            <div class="blue-head-block">Случайные игры</div>
            <div class="block-content">
<table class="game-grid">
<thead></thead>
<tbody>
<tr>
    <?php $counter = 1; ?>
    <?php query_posts('posts_per_page=8 & orderby=rand'); ?>
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
     <div style="width:100%;">Все игры
</div>
<div class="clear-both"></div>
</div>
<div class="clear-both"></div>
</div>
<div class="empty"></div>
<div class="clear-both"></div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>