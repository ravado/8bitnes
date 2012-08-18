<!-- Шаблон для вывода игрового обзора, с рейтингом и сбором всех картинок поста в слайдер -->
<div class="single-game complete-block">
    <div class="blue-head-block"><?php the_title() ?></div>
    <div class="block-content">
        <?
        $img_data = getPostImages();
        if (!empty($img_data)) : ?>
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

        <div id="raiting_star" itemscope itemtype="http://schema.org/Product">
            <meta itemprop="name" content="<?php the_title() ?>">
            <div id="raiting_info" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                <img src="<?php echo get_template_directory_uri() ?>/img/load.gif" />
                <h5>Рейтинг:
                    <meta itemprop="bestRating" content="10">
                    <meta itemprop="ratingCount" content="<?=getRatingCount()?>">
                    <span class="rating-value" itemprop="ratingValue"><?= getPostRating(); ?> </span>
                    <span class="already-voted" style="display: none;">Вы уже голосовали!</span>
                </h5>
            </div>
            <div id="raiting">
                <div id="raiting_blank"></div>
                <div id="raiting_hover"></div>
                <div id="raiting_votes"></div>
            </div>
        </div>
        <?php postWithoutImages(); ?>
    </div>
</div>