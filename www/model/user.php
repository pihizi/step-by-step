<?php

namespace Model;

class User
{
    public function verify($name, $password)
    {
        if ($name=='pihizi' && $password=='83719730') {
            return true;
        }
        return false;
    }
}
