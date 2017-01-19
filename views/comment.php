<div class="comment encloshure-<?=$encloshure?>" data-id="<?=$value['id']?>" data-enc="<?=$encloshure?>">
    <div class="row comment-item">
        <div class="col-md-2 img">
            <img src="/views/img/noavatar.png" class="img-responsive"/>
        </div>
        <div class="col-md-10 content">
            <div class="top-line">
                <div class="name">
                    <?=$value['name']?>
                </div>
                <div class="date">
                    <?=$value['date']?>
                </div>
            </div>
            <div class="text">
                <?=$value['content']?>
            </div>
            <div class="under-line">
                <? if($encloshure < 5):?>
                <div class="reply">
                    <a href="#" class="add-reply">Ответить</a>
                </div>
                <? endif;?>
                <div class="delete">
                    <a href="#" class="delete-reply">Удалить</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>