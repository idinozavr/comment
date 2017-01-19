<?php

require_once ROOT."/models/Comment.php";

class MainController
{

    /**
     * Метод вывода главной страницы
     */
    public function index()
    {
        # Создаем массив вывода
        $resultArr = [];

        # Получаем массив всех комментариев
        $comment = new Comment;
        $content = $comment->getAllComment();

        # Делаем вложенный массив (для реализации вложенных комментариев)
        $resultArr = $comment->transform($content);

        # Подключаем главный шаблон
        require_once ROOT."/views/main.php";
    }

    /**
     * Метод добавления комментария при помощи Ajax
     */
    public function addComment()
    {
        # Создаем массив вывода
        $resultArr = [];

        # Добавляем комментарий в БД
        $comment = new Comment;
        $resultId = $comment->addComment($_POST);

        # Получаем все данные добавленного комментария
        $resultArr = $comment->getCommentById($resultId);

        # Возвращаем эти данные в main.js
        echo json_encode($resultArr);

    }

    /**
     * Метод удаления комментариев
     */
    public function deleteComment()
    {

        # Получаем id удаляемого комментария
        $id = intval($_POST['id']);

        # Удаляем комментарий и все дочерние комментарии
        $comment = new Comment;
        $comment->deleteComment($id);

    }
}