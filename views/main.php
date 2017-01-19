<!DOCTYPE html>
<html lang="ru">

<head>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Тестовое задание</title>

    <!-- Bootstrap Core CSS -->
    <link href="/views/css/bootstrap.css" rel="stylesheet">
    <link href="/views/css/main.css" rel="stylesheet">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>

<body>
<section id="comments">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-xs-12 comments">
                <div class="row">
                    <h1 class="title">Коментарии</h1>
                </div>
                <div class="clearfix"></div>
                <? if($resultArr):?>
                <? foreach ($resultArr as $value): ?>
                <div class="comment-group">
                    <? $encloshure = 0 ?>
                    <? include "comment.php"?>
                    <? if(!empty($value['daughter'])):?>
                    <? foreach ($value['daughter'] as $value): ?>
                    <div class="comment-group">
                        <? $encloshure = 1 ?>
                        <? include "comment.php"?>
                        <? if(!empty($value['daughter'])):?>
                        <? foreach ($value['daughter'] as $value): ?>
                        <div class="comment-group">
                            <? $encloshure = 2 ?>
                            <? include "comment.php"?>
                            <? if(!empty($value['daughter'])):?>
                            <? foreach ($value['daughter'] as $value): ?>
                            <div class="comment-group">
                                <? $encloshure = 3 ?>
                                <? include "comment.php"?>
                                <? if(!empty($value['daughter'])):?>
                                <? foreach ($value['daughter'] as $value): ?>
                                <div class="comment-group">
                                    <? $encloshure = 4 ?>
                                    <? include "comment.php"?>
                                    <? if(!empty($value['daughter'])):?>
                                    <? foreach ($value['daughter'] as $value): ?>
                                    <div class="comment-group">
                                        <? $encloshure = 5 ?>
                                        <? include "comment.php"?>
                                    </div>
                                    <? endforeach;?>
                                    <? endif;?>
                                </div>
                                <? endforeach;?>
                                <? endif;?>
                            </div>
                            <? endforeach;?>
                            <? endif;?>
                        </div>
                        <? endforeach;?>
                        <? endif;?>
                    </div>
                    <? endforeach;?>
                    <? endif;?>
                </div>
                <? endforeach;?>
                <? endif;?>
            </div>
        </div>
    </div>
</section>

<section id="add-comments">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-xs-12 add-comments">
                <div class="col-xs-offset-3 col-xs-9">
                    <h4 class="title">Добавить комментарий</h4>
                </div>
                <form id="add-comments-form" class="form-horizontal" method="POST" action="">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-3 control-label">Имя:</label>
                        <div class="col-md-5 col-xs-9">
                            <input type="text" class="form-control" placeholder="Ваше имя" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Комментарий:</label>
                        <div class="col-xs-9">
                            <textarea type="text" class="form-control" placeholder="Введите комментарий" name="comment" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-3 col-xs-9">
                            <button type="submit" class="btn btn-info">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="/views/js/jquery.js"></script>

<!-- Main -->
<script src="/views/js/main.js"></script>

</body>