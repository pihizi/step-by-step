<?php

class Controller
{
    public function __construct()
    {
    }

    public function __index(array $params=[], $responseType='html')
    {
        throw new \Exception\Response('404 Not Found', 404);
    }
}
