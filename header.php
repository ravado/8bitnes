<!DOCTYPE html>
<html <?language_attributes();?> >
    <head>
        <?php $theme_dir = get_template_directory_uri();?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php bloginfo( 'name' ); ?><?php wp_title(); ?></title>
        <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico" />
        <link href='http://fonts.googleapis.com/css?family=Russo+One|Press+Start+2P|Play&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<!--        <link rel="stylesheet/less" href="--><?//= $theme_dir; ?><!--/style.css">-->

        <link rel="stylesheet" href="<?= $theme_dir; ?>/css/reset.css">
        <link rel="stylesheet" href="<?=$theme_dir; ?>/style.css">
        <link rel="stylesheet" href="<?= $theme_dir; ?>/css/global.css">
        <script type="text/javascript" src="<?= $theme_dir; ?>/js/jquery.js"></script>
        <script type="text/javascript" src="<?= $theme_dir; ?>/js/jquery.cookies.js"></script>
        <script src="http://www.google.com/jsapi" type="text/javascript"></script>
        <script type="text/javascript" src="<?= $theme_dir; ?>/js/slides.js"></script>
        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
        <script type="text/javascript" src="<?= $theme_dir; ?>/js/main.js"></script>
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
