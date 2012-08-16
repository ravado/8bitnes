<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!--  Путь к директории с темой  -->
    <?php $theme_dir = get_template_directory_uri();?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title(); ?></title>
    <link href='http://fonts.googleapis.com/css?family=Russo+One|Press+Start+2P|Play&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet/less" href="<?php echo $theme_dir; ?>/style.css">
    <link rel="stylesheet" href="<?php echo $theme_dir; ?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo $theme_dir; ?>/css/global.css">
<!--    <link rel="stylesheet" href="--><?php //echo $theme_dir; ?><!--/css/bootstrap.css">-->
    <script type="text/javascript" src="<?php echo $theme_dir; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $theme_dir; ?>/js/jquery.cookies.js"></script>
    <script src="http://www.google.com/jsapi" type="text/javascript"></script>
<!--    <script type="text/javascript" src="--><?php //echo $theme_dir; ?><!--/js/bootstrap.js"></script>-->
<!--    <script type="text/javascript" src="--><?php //echo $theme_dir; ?><!--/js/less.js"></script>-->
    <script type="text/javascript" src="<?php echo $theme_dir; ?>/js/slides.js"></script>
    <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
<script type="text/javascript" src="<?php echo $theme_dir; ?>/js/main.js"></script>
    <script type="text/javascript"></script>
    <?php wp_head(); ?>
</head>

<body>
<div id="main-container">
    <div id="header">
        <div id="wide-header">
            <div id="fixed-header">
                <a href="/" class="logo"><img src="<?php echo $theme_dir; ?>/img/logo.png" alt="logo" width="350"></a>
            </div>
            <div class="cats-nav">

            </div>
        </div>
    </div><!-- close header -–>

    <!-- start main menu -->
    <div id="menu">
        <!-- start fixed menu -->
        <div id="fixed-menu">
            <?php
            $walker = new mainMenuWalker ();
            wp_nav_menu ( array (
                'menu_id'=>'main-menu',
                'theme_location'=>'top',
                'container'=>'','walker' => $walker ) );
            ?>

            <div class="search-bar">
                <form action="<?php echo esc_url( home_url( '/search' ) ); ?>" id="frm-search" method="post">
                    <fieldset>
                        <input type="text" placeholder="Поиск" name="s" id="s" class="search-input">
                        <input type="button" value="" class="btn-search">
                    </fieldset>
                </form>
            </div>
        </div><!-- close fixed menu -->
    </div><!-- close main menu -->
