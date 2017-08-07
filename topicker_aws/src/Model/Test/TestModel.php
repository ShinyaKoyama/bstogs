<?php
namespace App\Model;

use App\Model\AppModel;

class TestModel extends AppModel {
    function insert($post) {
        $this->save($post);
    }
}