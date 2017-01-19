<?php

class Comment
{
    /**
     * Имя таблицы с которой работает модель
     * @var string
     */
    protected $table = 'comments';

    /**
     * Метод получения массива всех комментариев.
     * @return array - массив всех комментариев
     */
    public function getAllComment()
    {
        $resultArr = [];

        $db = (new Db)->getConnection();
        $query = "SELECT * FROM $this->table";
        $result = $db->query($query);

        for($i =0; $row = $result->fetch(); ++$i)
        {
            $resultArr[$i]['id'] = $row['id'];
            $resultArr[$i]['name'] = $row['name'];
            $resultArr[$i]['content'] = $row['content'];
            $resultArr[$i]['parents'] = $row['parents'];
            $resultArr[$i]['encloshure'] = $row['encloshure'];
            $resultArr[$i]['date'] = (new DateTime($row['date']))->format('d-m-Y');
        }

        return $resultArr;
    }

    /**
     * Метод получения комментария по его id
     * @param $id - id комментария
     * @return array - массив данных комментария
     */
    public function getCommentById($id)
    {
        $id = intval($id);
        $resultArr = [];

        $db = (new Db)->getConnection();
        $query = "SELECT * FROM $this->table WHERE `id` = $id";
        $result = $db->query($query);

        while($row = $result->fetch())
        {
            $resultArr['id'] = $row['id'];
            $resultArr['name'] = $row['name'];
            $resultArr['content'] = $row['content'];
            $resultArr['parents'] = $row['parents'];
            $resultArr['encloshure'] = $row['encloshure'];
            $resultArr['date'] = (new DateTime($row['date']))->format('d-m-Y');
        }

        return $resultArr;

    }

    /**
     * Метод добавления комментария в БД
     * @param $param - данные добавляемого комментария
     * @return bool|string - возвращает или id или false
     */
    public function addComment($param)
    {
        $name = $param['name'];
        $text = $param['text'];
        $parent = $param['parent'];

        $db = (new Db)->getConnection();
        $query = "INSERT INTO $this->table (`name`, `content`, `parents`) "
                ."VALUES ('$name', '$text', '$parent')";
        $db->query($query);
        $id = $db->lastInsertId();

        if($id){
            return $id;
        } else {
            return false;
        }

    }

    /**
     * Метод удаления комментария и всех вложенных комментариев
     * @param $id - id комментария
     */
    public function deleteComment($id)
    {
        $id = intval($id);

        $db = (new Db)->getConnection();
        $query = "SELECT id FROM $this->table WHERE `parents` = '$id'";
        $result = $db->query($query);

        while ($row = $result->fetch()){
            $idArray[] = $row['id'];
            if($row['id']){
                $query2 = "SELECT id FROM $this->table WHERE `parents` = '$row[id]'";
                $result2 = $db->query($query2);

                while ($row2 = $result2->fetch()){
                    $idArray[] = $row2['id'];

                    if($row2['id']){
                        $query3 = "SELECT id FROM $this->table WHERE `parents` = '$row2[id]'";
                        $result3 = $db->query($query3);

                        while ($row3 = $result3->fetch()){
                            $idArray[] = $row3['id'];

                            if($row3['id']){
                                $query4 = "SELECT id FROM $this->table WHERE `parents` = '$row3[id]'";
                                $result4 = $db->query($query4);

                                while ($row4 = $result4->fetch()){
                                    $idArray[] = $row4['id'];

                                    if($row4['id']){
                                        $query5 = "SELECT id FROM $this->table WHERE `parents` = '$row4[id]'";
                                        $result5 = $db->query($query5);

                                        while ($row5 = $result5->fetch()){
                                            $idArray[] = $row5['id'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $idArray[] = $id;

        if(isset($idArray[0])){

            $query = "DELETE FROM $this->table WHERE ";

            foreach ($idArray as $value){
                $query .= "`id` = $value OR ";
            }

            $query = substr($query, 0, -4);

            $result = $db->query($query);
        }
    }

    /**
     * Метод преобразования простого массива с комментариями во вложенный массив
     * для создания связей вложенных комментариев с родительскими
     * @param $content - массив комментариев
     * @return array - измененный массив
     */
    public function transform($content)
    {
        foreach ($content as $key => $value){
            if ($value['parents'] != 0){

                if(!empty($resultArr)){
                    foreach ($resultArr as $key2 => $value2){
                        if($value2['id'] == $value['parents']){
                            $resultArr[$key2]['daughter'][] = $value;
                        } else {
                            if(!empty($resultArr[$key2]['daughter'])) {
                                foreach ($resultArr[$key2]['daughter'] as $key3 => $value3) {
                                    if ($value3['id'] == $value['parents']) {
                                        $resultArr[$key2]['daughter'][$key3]['daughter'][] = $value;
                                    } else {
                                        if(!empty($resultArr[$key2]['daughter'][$key3]['daughter'])) {
                                            foreach ($resultArr[$key2]['daughter'][$key3]['daughter'] as $key4 => $value4) {
                                                if ($value4['id'] == $value['parents']) {
                                                    $resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'][] = $value;
                                                } else {
                                                    if(!empty($resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'])){
                                                        foreach ($resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'] as $key5 => $value5) {
                                                            if ($value5['id'] == $value['parents']) {
                                                                $resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'][$key5]['daughter'][] = $value;
                                                            } else {
                                                                if(!empty($resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'][$key5]['daughter'])) {
                                                                    foreach ($resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'][$key5]['daughter'] as $key6 => $value6) {
                                                                        if ($value6['id'] == $value['parents']) {
                                                                            $resultArr[$key2]['daughter'][$key3]['daughter'][$key4]['daughter'][$key5]['daughter'][$key6]['daughter'][] = $value;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $resultArr[$key] = $value;
            };
        }

        return $resultArr;
    }
}