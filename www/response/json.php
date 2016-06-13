<?php

namespace Response;

class JSON
{
    public function exec($content)
    {
        header('Content-type: application/json; charset:utf-8');
        echo json_encode($content);
    }
}
