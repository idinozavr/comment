$(window).load(function () {

    /**
     * Открытие поля "Добавление ответа к комментарию"
     * Отслеживаем клик по .comments, чтобы работал на добавленных посредством Js объектах
     */
    $('.comments').on('click', '.add-reply', function ( event ) {
        event.preventDefault();

        if (!$(this).hasClass("active")){

            var form = '<div class="add-answer"> <div class="clearfix"></div><div class="row comment-item">'+
                '<div class="col-xs-3"><input type="text" class="form-control" placeholder="Ваше имя" name="name"></div>'+
                '<div class="col-xs-9"><textarea class="form-control" placeholder="Ваш ответ" name="comment"></textarea></div>'+
                '</div><div class="clearfix"></div>'+
                '<div class="row comment-item">'+
                '<div class="col-xs-12 text-right"><a class="btn btn-info answer-submit">Ответить</a>'+
                '<a class="btn btn-default cancel">Отменить</a></div></div>'+
                '</div></div>';

            $(this).addClass('active');
            $(this).parents('.comment-item').after(form);
        };
    });

    /**
     * Скрыть поле "Добавление ответа к комментарию"
     * Отслеживаем клик по .comments, чтобы работал на добавленных посредством Js объектах
     */

    $('.comments').on('click', '.cancel', function ( event ) {
        event.preventDefault();

        var comment = $(this).parents('.comment');

        comment.find('.add-answer').remove();
        comment.find('.add-reply').removeClass('active');

    });

    /**
     * Добавление комментария через нижнюю форму
     */

    $('#add-comments-form').on('submit', function ( event ) {
        event.preventDefault();

        var error = false;
        var name = $(this).find('input[name=name]');
        var text = $(this).find('textarea[name=comment]');

        $('.answer-error').remove();

        if(name.val() == ''){
            var nameError = '<span class ="answer-error">Необходимо указать имя</span>';
            name.after(nameError);
            error = true;
        }

        if(text.val() == ''){
            var textError = '<span class ="answer-error">Необходимо написать комментарий</span>';
            text.after(textError);
            error = true;
        }

        if(error){
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/add/",
            data:{name:name.val(), text:text.val(), parent:0},
            success: function(resultJson){

                var result = $.parseJSON(resultJson);
                var newComment = "<div class=\"comment-group\">" +
                    "<div class=\"comment encloshure-0\" data-id=\""+result.id+"\" data-enc=\"0\">" +
                    "<div class=\"row comment-item\"><div class=\"col-md-2 img\">" +
                    "<img src=\"/views/img/noavatar.png\" class=\"img-responsive\"/></div>" +
                    "<div class=\"col-md-10 content\"><div class=\"top-line\"><div class=\"name\">" +
                    result.name + "</div>" +
                    "<div class=\"date\">" + result.date + "</div></div>" +
                    "<div class=\"text\">" + result.content + "</div>" +
                    "<div class=\"under-line\">"+
                    "<div class=\"reply\"><a href=\"#\" class=\"add-reply\">Ответить</a></div>"+
                    "<div class=\"delete\"><a href=\"#\" class=\"delete-reply\">&nbsp;Удалить</a></div></div></div>" +
                    "<div class=\"clearfix\"></div></div></div>"

                $('.comments').append(newComment);
                name.val('');
                text.val('');
            }
        });

    });

    /**
     * Добавление ответа к комментарию
     * Отслеживаем клик по .comments, чтобы работал на добавленных посредством Js объектах
     */

    $('.comments').on('click', '.answer-submit', function ( event ) {
        event.preventDefault();

        var error = false;
        var comment = $(this).parents('.comment');
        var id = comment.attr('data-id');
        var enc = +comment.attr('data-enc') + 1;
        var name = comment.find('input[name=name]');
        var text = comment.find('textarea[name=comment]');

        $('.answer-error').remove();

        if(name.val() == ''){
            var nameError = '<span class ="answer-error">Необходимо указать имя</span>';
            name.after(nameError);
            error = true;
        }

        if(text.val() == ''){
            var textError = '<span class ="answer-error">Необходимо написать ответ</span>';
            text.after(textError);
            error = true;
        }

        if(error){
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/add/",
            data:{name:name.val(), text:text.val(), parent:id},
            success: function(resultJson){

                var result = $.parseJSON(resultJson);
                var newComment = "<div class=\"comment-group\">"+
                    "<div class=\"comment encloshure-" + enc + "\" data-id=\""+result.id+"\" data-enc=\""+enc+"\">" +
                    "<div class=\"row comment-item\"><div class=\"col-md-2 img\">" +
                    "<img src=\"/views/img/noavatar.png\" class=\"img-responsive\"/></div>" +
                    "<div class=\"col-md-10 content\"><div class=\"top-line\"><div class=\"name\">" +
                    result.name + "</div>" +
                    "<div class=\"date\">" + result.date + "</div></div>" +
                    "<div class=\"text\">" + result.content + "</div>" +
                    "<div class=\"under-line\">";
                if(enc < 5){
                    newComment += "<div class=\"reply\"><a href=\"#\" class=\"add-reply\">Ответить</a></div>";
                };
                newComment += "<div class=\"delete\"><a href=\"#\" class=\"delete-reply\">&nbsp;Удалить</a></div></div>" +
                    "</div></div>" +
                    "<div class=\"clearfix\"></div></div></div>"

                comment.parent(".comment-group").append(newComment);
                comment.find('.add-answer').remove();
                comment.find('.add-reply').removeClass('active');
            }
        });
    })

    /**
     * Удаление комментария вместе с группой зависимых комментариев
     * Отслеживаем клик по .comments, чтобы работал на добавленных посредством Js объектах
     */
    $('.comments').on('click', '.delete-reply', function ( event ){

        event.preventDefault();
        var comment = $(this).parents('.comment');
        var id = comment.attr('data-id');

        $.ajax({
            type: "POST",
            url: "/delete/",
            data:{id:id},
            success: function(){
                comment.parent('.comment-group').hide(300);
                setTimeout(function () {
                    comment.parent('.comment-group').remove();
                }, 600);
            }
        });
    });
})