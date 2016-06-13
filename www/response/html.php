<?php

namespace Response;

class HTML
{
    public function exec($content)
    {
        header('Content-type: text/html; charset=utf-8');
        echo $content;
    }
}
