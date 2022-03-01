<?php

namespace SmartSolucoes\Core;

use SmartSolucoes\Libs\Helper;

class Route
{
    public $url;
    public $param;
    public $route;

    function __construct($url)
    {
        $this->prefix($url);
    }

    function prefix($array) {

        // PHP 7.0
            // if (count($array)) {
            //     $this->route = $array[0];
            //     unset($array[0]);
            //     $this->param = array_values($array);
            // } else {
            //     $this->route = $this->param[0] = '';
            // }
     
        // PHP 7.2.X
        if (is_array($array) && count($array)) {
                $this->route = $array[0];
                unset($array[0]);
                $this->param = array_values($array);
            } else {
                $this->route = $this->param[0] = '';
            }
    
        }

    function route($route) {
        if(strpos($route,'{') !== false) {
            $routeParts = explode('{', $route);
            if (COUNT($routeParts) > 0) {
                foreach ($routeParts as $routePart) {
                    $routePart = str_replace(['}', '/'], '', $routePart);
                    if($routePart == @$this->param[0]) {
                        $this->route = $route = $routePart;
                        unset($this->param[0]);
                        $combine = 1;
                    } elseif($routePart == '' && COUNT(@$routeParts) > COUNT($this->param)) {
                        $this->route = $route = $routePart;
                        $combine = 1;
                    } else {
                        $index[] = $routePart;
                    }
                }
                if (@$combine && COUNT(@$index) == COUNT($this->param)) {
                    $this->param = array_combine($index, $this->param);
                }
            }
        } elseif(@$this->param[0] && $route && $this->route && $route == @$this->param[0]){
            $this->route = $route;
        }
        return $route;
    }

    function group($route,$function)
    {
        if($route == $this->route) {
            $this->prefix($this->param);
            $function($this);
            exit();
        }
    }

    function group2($route,$function)
    {
        if($route == $this->route) {
            $function($this);
            exit();
        }
    }

    function view($route,$view)
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET' && $route == $this->route) {
            \SmartSolucoes\Libs\Helper::view($view);
            exit();
        }
    }

    function get($route,$action,$param=false)
    {
        $route = $this->route($route);
        if($_SERVER['REQUEST_METHOD'] == 'GET' && $route == $this->route) {
            $this->run($action,$param);
            exit();
        }
    }

    function post($route,$action,$param=false)
    {
        $route = $this->route($route);
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $route == $this->route) {
            $this->run($action,$param);
            exit();
        }
    }

    function crud($controller) {
        switch ($this->route) {
            case '':
                $this->get('',ucfirst($controller).'Controller@index');
                break;
            case 'novo':
                $this->get('novo',ucfirst($controller).'Controller@viewNew');
                break;
            case 'editar':
                $this->get('editar',ucfirst($controller).'Controller@viewEdit','id');
                break;
            case 'salvar':
                $this->post('salvar',ucfirst($controller).'Controller@update');
                break;
            case 'cadastrar':
                $this->post('cadastrar',ucfirst($controller).'Controller@create');
                break;
            case 'remover':
                $this->get('remover',ucfirst($controller).'Controller@delete','id');
                break;
            case 'ativar':
                $this->get('ativar',ucfirst($controller).'Controller@enable','id');
                break;
            case 'inativar':
                $this->get('inativar',ucfirst($controller).'Controller@disable','id');
                break;
        }
    }

    private function run($action,$param) {
        $parts = explode(',',$param);
        if($param && is_array($parts) && count($parts) == count($this->param)) {
            $this->param = array_combine($parts,$this->param);
        }
        $action = explode('@',$action);
        $controller = '\SmartSolucoes\Controller\\' . $action[0];
        $method = $action[1];
        $class = New $controller();
        $class->{$method}($this->param);
        exit();
    }

}