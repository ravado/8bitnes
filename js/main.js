
// Слайдер
$(function(){
    $('#slides').slides({
        preload: true,
        preloadImage: 'img/loading.gif',
        play: 5000,
        pause: 2500,
        hoverPause: true,
        generateNextPrev: false,
        animationStart: function(current){
            $('.caption').animate({bottom:-35},100);
            if (window.console && console.log) {
                // example return of current slide number
                console.log('animationStart on slide: ', current);
            }
        },
        animationComplete: function(current){
            $('.caption').animate({bottom:0},200);
            if (window.console && console.log) {
                // example return of current slide number
                console.log('animationComplete on slide: ', current);
            }
        },
        slidesLoaded: function() {
            $('.caption').animate({bottom:0},200);
        }
    });
});

$(document).ready(function() {




    total_raiting = $("#raiting_info h5 span").text(); // итоговый ретинг
    id_arc = 55; // id статьи
    var star_widht = Math.ceil(total_raiting*30);
    $('#raiting_votes').width(star_widht);
//    he_voted = $.cookies.get('article'+id_arc); // проверяем есть ли кука?
    he_voted = null;
    if(he_voted == null){
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
                $("#raiting_info h5 span").html(data.rating);
                $('#raiting_votes').width(Math.ceil((data.rating*30)));
                $('#raiting_votes').show();
                $('#raiting_info h5, #raiting_info img').toggle();
//                    $.cookies.set('article'+id_arc, 123, {hoursToLive: 1}); // создаем куку
                $("#raiting").unbind();
                $('#raiting_hover').hide();
            },"json");
            /*$('#raiting_info h5, #raiting_info img').toggle();
            $.get(
                "raiting.php",
                {id_arc: id_arc, user_votes: user_votes},
                function(data){
                    $('#raiting').css('cursor','default');
                    $("#raiting_info h5").html(data);
                    $('#raiting_votes').width((total_raiting + user_votes)*30/2);
                    $('#raiting_info h5, #raiting_info img').toggle();
//                    $.cookies.set('article'+id_arc, 123, {hoursToLive: 1}); // создаем куку
                    $("#raiting").unbind();
                    $('#raiting_hover').hide();
                }
            )*/
        });
    }
    else {
        console.log('already voted');
    }
});