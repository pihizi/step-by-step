<?php

final class Request
{
    private $_path = '';
    private $_fulL_request = [];
    private $_class_name = '';
    private $_method_name = '__index';
    private $_params = [];
    private $_content = null;
    private $_response_type = '';
    private $_response_code = 0;

    public static function exec($path)
    {
        $request = new self($path);
        $request->run();
        return $request;
    }

    public function __construct($path='')
    {
        if ($pos = stripos($path, '.')) {
            $this->_response_type = substr($path, $pos+1) ?: $this->_response_type;
            $path = substr($path, 0, $pos);
        }
        else {
            $this->_response_type = DEFAULT_RESPONSE_TYPE;
        }
        $this->_path = trim($path, '/');
        $data = explode('/', $this->_path);
        array_unshift($data, CONTROLLER_DIR);
        $this->_full_class_path = $data;
        $params = [];

        while (true) {
            if (empty($data)) break;
            $className = implode(NS_SEPARATOR, $data);
            if (class_exists($className)) {
                $this->_class_name = $className;
                break;
            }
            array_unshift($params, array_pop($data));
        }

        if (count($params)) {
            $method = "action{$params[0]}";
            if (is_callable([$this->_class_name, $method])) {
                $this->_method_name = $method;
                array_shift($params);
            }
        }

        $this->_params = $params;
    }

    public function run()
    {
        $class = $this->_class_name;
        $class= new $class;
        $params = $this->_params;
        try {
            $this->_content = call_user_func([$class, $this->_method_name], $params, $this->_response_type);
        }
        catch (\Exception\Response $e) {
            $code = $e->getCode();
            if ($code) {
                $this->_content = $e->getMessage();
                $this->_response_code = $code;
            }
        }
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function response()
    {
        if (is_null($this->_content)) return;

        $className = NS_SEPARATOR . implode(NS_SEPARATOR, [
            RESPONSE_DIR, $this->_response_type
        ]);
        if (!class_exists($className)) {
            $className = NS_SEPARATOR . implode(NS_SEPARATOR, [
                RESPONSE_DIR, DEFAULT_RESPONSE_TYPE
            ]);
        }

        if ($this->_response_code) {
            header("Status: {$this->_response_code}");
        }
        $response = new $className();
        $response->exec($this->_content);
    }
}
