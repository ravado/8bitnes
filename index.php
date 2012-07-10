<?php get_header(); ?>
<div id="content">
<!--  Путь к директории с темой  -->
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">
            <div id="container">
                <div id="example">
                    <img src="<?php echo $theme_dir; ?>/img/new-ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">

                    <div id="slides">
                        <div class="slide-border">

                            <div class="slides_container">
                                <?php query_posts('cat=10'); ?>
                                <?php while (have_posts()) : the_post(); ?>
                                <div class="slide">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
                                        <img src="<?php echo getTopGames(3); ?>" width="700" height="380" alt="Slide 1">
                                    </a>
                                    <div class="caption" style="bottom:0">
                                        <p><?php the_title(); ?></p>
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
                        <?php $popular_game = getPopularGames('popular',8); for( $i = 0; $i < 2;  $i++ ): ?>
                        <tr>
                            <?php for($k = $i*4; $k < 4+$i*4; $k++): ?>
                            <td>
                                <div class="game-item">
                                    <div class="head-orange">
                                        <h3><a href="<?php echo $popular_game[$k]['permalink']; ?>"><?php echo $popular_game[$k]['title']; ?></a></h3>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-image">
                                            <img src="<?php echo $popular_game[$k]['img_url']; ?>" alt="" width="176">
                                        </div>
                                        <div class="item-decription">
                                            <p><?php echo $popular_game[$k]['review']; ?></p>
                                        </div>
                                        <div class="item-info">
                                            <span class="item-genre">
                                                <p>Жанр:
                                                    <a href="<?php echo $popular_game[$k]['cat_lnk']; ?>"><?php echo $popular_game[$k]['cat_name']; ?></a>
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
                            <?php endfor; ?>
                        </tr>
                        <?php endfor; ?>
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
<?php $popular_game = getPopularGames('random',8); for( $i = 0; $i < 2;  $i++ ): ?>
<tr>
    <?php for($k = $i*4; $k < 4+$i*4; $k++): ?>
    <td>
        <div class="game-item">
            <div class="head-orange">
                <h3><a href="<?php echo $popular_game[$k]['permalink']; ?>"><?php echo $popular_game[$k]['title']; ?></a></h3>
            </div>
            <div class="item-content">
                <div class="item-image">
                    <img src="<?php echo $popular_game[$k]['img_url']; ?>" alt="" width="176">
                </div>
                <div class="item-decription">
                    <p><?php echo $popular_game[$k]['review']; ?></p>
                </div>
                <div class="item-info">
                    <span class="item-genre">
                        <p>Жанр:
                            <a href="<?php echo $popular_game[$k]['cat_lnk']; ?>"><?php echo $popular_game[$k]['cat_name']; ?></a>
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
    <?php endfor; ?>
</tr>
    <?php endfor; ?>
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