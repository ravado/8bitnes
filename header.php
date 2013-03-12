<!DOCTYPE html>
<html <?language_attributes();?> >
    <head>
        <?php $theme_dir = get_template_directory_uri();?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php bloginfo( 'name' ); ?><?php wp_title(); ?></title>
        <link href='http://fonts.googleapis.com/css?family=Russo+One|Press+Start+2P|Play&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?= $theme_dir; ?>/css/reset.css">
        <link rel="stylesheet" href="<?=$theme_dir; ?>/style.css">
        <link rel="stylesheet" href="<?= $theme_dir; ?>/css/global.css">
        <!--[if lt IE 10]>
           <link href="/wp-content/themes/8bitnes/css/ie.css" rel="stylesheet" type="text/css">
        <![endif]-->
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
        
<script type="text/javascript" src="<?= $theme_dir; ?>/js/jquery.js"></script>
        <script type="text/javascript" src="<?= $theme_dir; ?>/js/jquery.cookies.js"></script>        
        <script type="text/javascript" src="<?= $theme_dir; ?>/js/slides.js"></script>
<script type="text/javascript" src="<?= $theme_dir; ?>/js/main.js"></script>

<!--<script type="text/javascript">
            var reformalOptions = {
                project_id: 70108,
                project_host: "emulroom.reformal.ru",
                tab_orientation: "left",
                tab_indent: "50%",
                tab_bg_color: "#F05A00",
                tab_border_color: "#FFFFFF",
                tab_image_url: "http://tab.reformal.ru/T9GC0LfRi9Cy0Ysg0Lgg0L%252FRgNC10LTQu9C%252B0LbQtdC90LjRjw==/FFFFFF/2a94cfe6511106e7a48d0af3904e3090/left/1/tab.png",
                tab_border_width: 2
            };

            (function() {
                var script = document.createElement('script');
                script.type = 'text/javascript'; script.async = true;
                script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
                document.getElementsByTagName('head')[0].appendChild(script);
            })();
        </script><noscript><a href="http://reformal.ru"><img src="http://media.reformal.ru/reformal.png" /></a><a href="http://emulroom.reformal.ru">Oтзывы и предложения для Emulroom</a></noscript>-->

        <?php wp_head(); ?>
    </head>
<body>
    <div id="main-container">
        <header id="header">
            <div id="wide-header">
                <div id="fixed-header">
                    <div class="logo">
                        <a href="/" title="Перейти на главную"><img src="<?= $theme_dir; ?>/img/logo.png" alt="logo" width="350"></a>
                    </div>
                    <div class="social">
<!--                        <a href><img src="--><?//= $theme_dir; ?><!--/img/social/facebook.png"></a>-->
<!--                        <a href><img src="--><?//= $theme_dir; ?><!--/img/social/twitter.png"></a>-->
<!--                        <a href><img src="--><?//= $theme_dir; ?><!--/img/social/google.png"></a>-->
                        <a href="/rss" title="Подписаться на обновления"><img src="<?= $theme_dir; ?>/img/social/rss.png" alt="подписаться на обновления"></a>
                    </div>
                </div>
            </div>
        </header><!--close header-->

        <div id="menu">
            <nav id="fixed-menu">
                <?php
                $walker = new mainMenuWalker ();
                wp_nav_menu ( array (
                    'menu_id'=>'main-menu',
                    'theme_location'=>'top',
                    'container'=>'','walker' => $walker ) );
                ?>
                <div class="search-bar">
                    <form action="<?= esc_url( home_url( '/search' ) ); ?>" id="frm-search" method="post">
                        <fieldset>
                            <input type="text" placeholder="Поиск" name="s" id="s" class="search-input">
                            <input type="submit" value="search" class="btn-search">
                        </fieldset>
                    </form>
                </div>
            </nav><!-- close fixed menu -->
        </div><!-- close main menu -->