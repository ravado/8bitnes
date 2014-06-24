// Хак для ИЕ (новые html5 теги)
document.createElement('header');
document.createElement('hgroup');
document.createElement('nav');
document.createElement('menu');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('footer');

var URL_TO_DOWNLOAD_BANNER = 'http://www.st.emulroom.com/images/banners/banner-download.png';
var URL_ADVERTISING = 'http://56004.getfl.net/?id=t2db1&sub=&url=&name=';
var USE_DOWNLOAD_BANNERS = true;

var timer_id;
function some() {
    $("input.gsc-input").focus();
    $("input.gsc-input").attr('placeholder','Введиде поисковую фразу');
    var search_query = $("#search-query").val();
    clearInterval(timer_id);
    if(search_query != '') {
        $(".gsc-input input").val(search_query);
        $("input.gsc-search-button").click();
    }
    $(".gsc-tabHeader").each(function(e) {
        if($(this).text() == 'Интернет') {
            $(this).text('По записям');
        } else if($(this).text() == 'Картинка') {
            $(this).text('По картинкам');
        }
    });
    $(".gsc-orderby-label").text('Сортировать по:');
}

// инициация функции после отработки конструктора audiojs
function initTitles() {setTimeout(placeTitles, 1000);}

// подгружаем значение в тегах audio в специальное место для вывода пользователю название трека
function placeTitles() {
    var audioBlock = $(".audiojs");
//    alert(audioBlock.length);
    audioBlock.each(function(index, el) {
        var title, titlePlace;
        title = $(el).find('audio').text();
        titlePlace = $(el).find('.title');
        titlePlace.text(title);
        //alert(title);
    });
}

// Добавление на страницу емулятора с загруженой игрой
function renderEmulator(zip_game_url) {
    var game = zip_game_url.substring(0, zip_game_url.length - 3) + 'nes';
    console.log('game ' + game);
    $(".gameDownload").after(
        '<div id="emulator-box">' +
            '<div class="emulator">' +
            '<applet archive="/wp-content/resources/vNES_211.jar" code="vNES.class" width="520" height="475">' +
            '<param name="rom" value="/' + game + '" />' +
            '<param name="sound" value="on" />' +
            '<param name="scanlines" value="off" />' +
            '<param name="scale" value="on" />' +
            '<param name="fps" value="on" />' +
            '</applet>' +
            '</div>' +
            '<div class="emulator-how-to">' +
            '<img src="/wp-content/themes/8bitnes/img/emulator-tutorial.png">' +
            '</div>' +
            '</div>' +
            '<div style="clear: both"></div>');
}


// Поиск
google.load('search', '1', {language : 'ru', style : google.loader.themes.V2_DEFAULT});
google.setOnLoadCallback(function() {
    var customSearchOptions = {};
    var orderByOptions = {};
    orderByOptions['keys'] = [{label: 'Релевантность', key: ''},{label: 'Дата', key: 'date'}];
    customSearchOptions['enableOrderBy'] = true;
    customSearchOptions['orderByOptions'] = orderByOptions;
    var imageSearchOptions = {};
    imageSearchOptions['layout'] = google.search.ImageSearch.LAYOUT_CLASSIC;
    customSearchOptions['enableImageSearch'] = true;
    customSearchOptions['imageSearchOptions'] = imageSearchOptions;  var customSearchControl = new google.search.CustomSearchControl(
        '017974249376903738753:fqunvspraoe', customSearchOptions);
    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    customSearchControl.draw('search-box');
    timer_id = setInterval('some()', 10);
}, true);



// Слайдер
$(function(){
    $('#slides').slides({
        preload: false,
        preloadImage: 'img/loading.gif',
        play: 5000,
        pause: 2500,
        hoverPause: true,
        generateNextPrev: false,
        animationStart: function(current){
            $('.caption').animate({bottom:-35},100);
//            if (window.console && //console.log) {
//                // example return of current slide number
//                //console.log('animationStart on slide: ', current);
//            }
        },
        animationComplete: function(current){
            $('.caption').animate({bottom:0},200);
//            if (window.console && //console.log) {
//                // example return of current slide number
//                //console.log('animationComplete on slide: ', current);
//            }
        },
        slidesLoaded: function() {
            $('.caption').animate({bottom:0},200);
        }
    });
});

function setRatingBar() {
    var total_raiting, star_widht;
    total_raiting = $("#raiting_info h5 .rating-value").text(); // итоговый ретинг
    star_widht = Math.ceil(total_raiting*30);
    $('#raiting_votes').width(star_widht);
}

function fuckOffTarget() {
    $(".gsc-results.gsc-webResult a").removeAttr('target');
    $(".gs-image-box a").removeAttr('target');
    clearInterval(timer_id);
}

function initializeBanners() {
    try {
        var $downloadBox = $('.gameDownload');
        var $originLink = $downloadBox.find('.icon-download');
        if($originLink) {
            var linkToDownload = encodeURIComponent($originLink.attr('href')); console.log('link: ' + linkToDownload);
            var fileName = encodeURIComponent($originLink.text().substr(8)); console.log('name: ' + fileName);
            var url = URL_ADVERTISING.replace('&url=', '&url=' + linkToDownload).replace('&name=','&name=' + fileName); console.log('replaced: ' + url);
            var urlToDownload = url;
            if($downloadBox.length > 0 && USE_DOWNLOAD_BANNERS) {
                var $banner = $('<div style="float: right;"><a href="' + urlToDownload + '"><img style="height: 50px" src="' + URL_TO_DOWNLOAD_BANNER + '"></a></div>');
                $downloadBox.css('float','left').css('width','62%');
                $downloadBox.after('<div style="clear:both"></div>');
                $downloadBox.after($banner);
            }
        }
    } catch (ex) {

    }
}

$(document).ready(function() {

    initializeBanners();

    // нажатие на кнопку 'play' аудиоплеера
    // для отслеживани и запрета игры сразу нескольких потоков
    $('body').on('click', '.play-pause', function(){
        var audioBlock, thisIndex = $(this).parents('.audiojs').index('.audiojs');
        $.each(aujs, function(index,val){
            if ( index != thisIndex && aujs[index].playing ) {
                aujs[index].pause();
            }
        });
        // скрываем все часы, а затем показываем только текущие
        audioBlock = $(this).closest('.audiojs');
        $('.time').css('display','none');
        audioBlock.find('.time').css('display','block');
    });


    $("input.search-input").live('keyup',function(e) {
        if(e.keyCode == 13){
            $("#frm-search").submit();
        }
    });

    // Перехват сабмита формы поиска
    $("#frm-search").submit(function() {
        if($(".search-input").val() == '') {
            //console.log('Пустое значение');
            $(".search-input").focus();
            return false;
        } else {
            return true;
        }
    });


    try {
        VK.init({apiId: 3033594, onlyWidgets: true});
        VK.Widgets.Comments("vk_comments", {limit: 10, width: "791", attach: "*"});
    } catch(error) {
        //console.log('Не удалось подключить коменты ВК');
    }


    $(".to-search").click(function() {
        $(".search-input").focus();
    });

    $(".search-input").focus(function(){
        $(this).animate({width:150},200).css('opacity','1');
        $(this).parent().animate({width:185},200).css('opacity','1');
    });
    $(".search-input").focusout(function(){
        $(this).animate({width:100},200).css('opacity','0.7');
        $(this).parent().animate({width:135},200).css('opacity','0.7');
    });



    $("input.gsc-search-button").live('click', function() {

    });
    $("input.gsc-input").live('keyup',function(e) {
        if(e.keyCode == 13){
            if($("input.gsc-input").val() != '') {
                timer_id = setInterval('fuckOffTarget()', 700);
//                $(".search-logo").animate({paddingTop:"0", opacity: "0"},800, "swing");
            }
        }
    });

    $(".gsc-tabHeader").live('click', function() {
        timer_id = setInterval('fuckOffTarget()', 700);
    });

    // Выставление правильного колчества сердечек рейтинга
    setRatingBar();
    // Проверка куков голосовал ли человек за этот пост уже
    if(($.cookies.get('article'+$("#post_id").val())) == null){
        $('#raiting').hover(function() {
                $('#raiting_votes, #raiting_hover').toggle();
            },
            function() {
                $('#raiting_votes, #raiting_hover').toggle();
            });
        var margin_doc = $("#raiting").offset();
        $("#raiting").mousemove(function(e){
            var widht_votes = e.pageX - margin_doc.left;
            if (widht_votes == 0) widht_votes = 1 ;
            user_votes = Math.ceil(widht_votes/30);
            // обратите внимание переменная  user_votes должна задаваться без var, т.к. в этом случае она будет глобальной и мы сможем к ней обратиться из другой ф-ции (нужна будет при клике на оценке.
            $('#raiting_hover').width(user_votes*30);
        });

        // отправка
        $('#raiting').click(function(){
            $('#raiting_info h5, #raiting_info img').toggle();
            $.post('/wp-admin/admin-ajax.php', {
                action: 'change_rating',
                post_id: $("#post_id").val(),
                mark: user_votes
            }, function(data) {
                $('#raiting').css('cursor','default');
                $("#raiting_info h5 .rating-value").html(data.rating);
                //console.log("votes " + data.votes_count);
                $("#raiting_info .votes-count").html(data.votes_count);
                $('#raiting_votes').width(Math.ceil((data.rating*30)));
                $('#raiting_votes').show();
                $('#raiting_info h5, #raiting_info img').toggle();
                $.cookies.set('article'+$("#post_id").val(), 123, {expires: 7}); // создаем куку
                $("#raiting").unbind();
                $('#raiting_hover').hide();
            },"json");
        });
    }
    else {
        $("#raiting").live('click', function() {
            var alreadyVoted = $("#raiting_info h5 .already-voted");
            alreadyVoted.text('Вы уже голосовали!');
            alreadyVoted.fadeIn(500).delay(2000).fadeOut(1000, function() {
                alreadyVoted.text('');
            });
        });
        //console.log('already voted');
    }

    // Нажатие на кнопку смены алфавита
    $(".switch-alphabet a").click(function() {
        var currentBtn = $(this), otherBtns = $(".switch-alphabet a").not(currentBtn);
        if (currentBtn.hasClass('switcher') && !currentBtn.hasClass('lock')) {
            var alphabetToSwitch, alphabetItem;
            alphabetToSwitch = currentBtn.attr("data-switch-alphabet");
            //console.log("Alphabet to switch is: " + alphabetToSwitch);
            alphabetItem = $("ul[data-alphabet='" + alphabetToSwitch + "']");
            //console.log("Finded " + alphabetItem.length + " alphabet items to switch");
            otherBtns.addClass('lock');
            //console.log("lock buttons");

            $(".alphabet").not(alphabetItem).fadeOut(100, 'swing', function() {
                //console.log('fade outed');
                alphabetItem.fadeIn(100, 'swing', function() {
                    //console.log('fade inned');
                    otherBtns.removeClass('lock');
                    //console.log("unlock buttons");
                });
            });

            currentBtn.find(".icon").removeClass('disabled');
            otherBtns.find(".icon").addClass('disabled');
        }
    });


    // нажатие на кнопку "Играть в игру"
    $('.btn-play-game').click(function() {
        var game_url = $('.icon-download').attr('href'),
            emulator = $('#emulator-box');

        if(emulator.length == 0) {
            console.log('try to render emulator');
            renderEmulator(game_url);
        }
    });


    // Нажатие на букву алфавита (временно)
    $(".alphabet li a").click(function() {
        var currentLetter = $(this), othersLetter;
        othersLetter = currentLetter.closest('.alphabet').find('li a').not(currentLetter);
        othersLetter.removeClass('active');
        currentLetter.addClass('active');
    });
});