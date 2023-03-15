<?php

namespace Psixoz\Todo;

class App
{
    private $full_url = null;
    private $url_id = null;
    private $url_controller = null;
    private $url_action = null;
    private $url_parameter_1 = null;
    private $url_parameter_2 = null;
    private $url_parameter_3 = null;

    public function __construct(){
        session_start();

        $this->splitUrl();

        try {
            $this->url_controller = new $this->url_controller();
        }catch (\Throwable $e){
            header("HTTP/1.1 404 Not Found");
            exit();
        }

        if ($this->url_action && method_exists($this->url_controller, $this->url_action)) {
            if (isset($this->url_parameter_3)) {
                $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
            } elseif (isset($this->url_parameter_2)) {
                $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
            } elseif (isset($this->url_parameter_1)) {
                $this->url_controller->{$this->url_action}($this->url_parameter_1);
            } else {
                $this->url_controller->{$this->url_action}();
            }
        } else {
            $this->url_controller->index();
        }

    }

    private function splitUrl()
    {
        $controller_path  = '\Psixoz\Todo\Controllers\\';
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $this->full_url = $url;
            $url = explode('/', $url);

            $this->url_controller = (isset($url[0]) ? $controller_path.ucfirst(strtolower($url[0])) : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
            $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);
        }else{
            $this->url_controller = $controller_path.'Todo';
        }
    }
}