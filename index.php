<?php

/**
 * Создаем константу ROOT для подключения файлов
 */

define('ROOT', dirname(__FILE__));

/**
 * Подключаем БД
 */

require_once ROOT."\\components\\db.php";

/**
 * Подключаем маршрутизатор.
 */
require_once ROOT."\\components\\router.php";

(new Router)->run();
