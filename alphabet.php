<div class="alphabet-block white-block">
    <? $curTag = get_query_var('tag');?>
    <?$lang = ((strpos($curTag,'dendy-en') === false) ? 'ru' : 'en')?>

    <!-- alphabets -->
    <ul class="english-alphabet alphabet <?if($lang == 'ru') echo 'hidden'?>"  data-alphabet="en">
        <li><a href="/all/" class="<?if(empty($curTag) && !is_single()) echo 'active'?>">Все</a></li>
        <?foreach (getEnAlphabet() as $v):?>
            <? $link = 'dendy-en-letter-' .$v; ?>
            <li><a href="/tag/<?=$link?>" class="<?if($curTag === $link ) echo 'active'?>"><?=$v?></a></li>
        <?endforeach?>
        <li class="helper"></li>
    </ul>

    <ul class="russian-alphabet alphabet <?if($lang == 'en') echo 'hidden'?>" data-alphabet="ru">
        <li><a href="/all/" class="<?if(empty($curTag) && !is_single()) echo 'active'?>">Все</a></li>
        <?foreach (getRuAlphabet() as $k => $v):?>
            <? $link = 'dendy-ru-letter-' .$v; ?>
            <li><a href="/tag/<?=$link?>" class="<?if($curTag === $link ) echo 'active'?>"><?=$k?></a></li>
        <?endforeach?>
        <li class="helper"></li>
    </ul>

    <!-- alphabet switcher -->
    <div class="switch-alphabet">
        <a class="switcher" data-switch-alphabet="ru">
            <span class="lang-icon-ru icon <?=($lang == 'en') ? 'disabled' : '' ?>"></span>
        </a>
        <a class="switcher" data-switch-alphabet="en">
            <span class="lang-icon-en icon <?=($lang == 'ru') ? 'disabled' : '' ?>"></span>
        </a>
    </div>
    <div style="clear: both;"></div>
</div>