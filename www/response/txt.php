<?php

namespace Response;

class TXT
{
    public function exec($content)
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo $content;
    }
}
