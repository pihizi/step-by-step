<?php

class View 
{
    private $_path;
    private $_content;
    private $_vars = [];
    public function __construct($path, array $vars=[])
    {
        $this->_path = implode('/', [
            ROOT,
            VIEW_DIR,
            $path.'.html'
        ]);
        $this->_vars = $vars;
    }

    public function content()
    {
        ob_start();
        extract($this->_vars);
        include($this->_path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function __toString()
    {
        return (string)$this->content();
    }
}

