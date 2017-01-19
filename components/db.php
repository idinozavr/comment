<?php

class Db
{
    public function getConnection()
    {
        $dbConfig = ROOT.'/config/dbconfig.php';
        $parems = include ($dbConfig);

        $db = new PDO("mysql:host=$parems[host];dbname=$parems[dbname]", $parems['dbuser'], $parems['dbpass']);
        return $db;
    }
}