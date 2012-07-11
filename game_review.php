
<div class="single-game complete-block">
    <div class="blue-head-block"><?php the_title() ?></div>
    <div class="block-content">
        <?php
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
        <div id="raiting_star">
            <div id="raiting_info">
                <img src="<?php echo get_template_directory_uri() ?>/img/load.gif" />
                <h5>Рейтинг:
                    <span class="rating-value"><?php echo getPostRating(); ?> </span>
                    <span class="already-voted" style="display: none;">Вы уже голосовали!</span>
                </h5>
            </div>
            <div id="raiting">
                <div id="raiting_blank" data-original-title="Пользователь создавшый тест"></div>
                <div id="raiting_hover" data-original-title="Пользователь создавшый тест"></div>
                <div id="raiting_votes" data-original-title="Пользователь создавшый тест"></div>
            </div>
        </div>
        <?php postWithoutImages(); ?>
    </div>
</div>