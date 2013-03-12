<!-- vk comments -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?56"></script>
<script type="text/javascript">VK.init({apiId: 3033594, onlyWidgets: true});</script>
<? if(is_user_logged_in()): ?>
    <script type="text/javascript">
        function changeVotingResult() {
            $.post('/wp-admin/admin-ajax.php', {
                action: 'change_voting_result',
                post_id: $("#post_id").val(),
                votes_count:$("#vote_count").val(),
                rating:$("#rate_count").val()
            }, function(data) {
                if(data.status == "ok") {
                    $("#rating_update").append('<span style="color: green;">ok</span>');
                }
                console.log(data);
            },"json");
        }
    </script>
<? endif; ?>
<!-- Шаблон для вывода игрового обзора, с рейтингом и сбором всех картинок поста в слайдер -->
<div class="single-game complete-block">
    <div class="blue-head-block">
        <h1><?php the_title() ?></h1>
    </div>
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
                                    <img src="<?php echo $img['url']?>" alt="<?php echo $img['alt'] ?>" width="760" height="460">
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
        <? if(is_user_logged_in()): ?>
        <div id="rating_update">
            Голосов: <input type="text" id="vote_count">
            Рейтинг: <input type="text" id="rate_count">
            <button onclick="changeVotingResult()">Отправить</button>
        </div>
        <? endif; ?>
        <?php postWithoutImages(); ?>
    </div>
</div>