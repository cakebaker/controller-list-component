<?php

class ControllerListComponent extends Component {

    public function getList(Array $controllersToExclude = array('PagesController')) {
        $controllersToExclude[] = 'AppController';
        $controllerClasses = array_filter(App::objects('Controller'), function ($controller) use ($controllersToExclude) {
            return !in_array($controller, $controllersToExclude);
        });
        $appControllerMethods = get_class_methods('AppController');
        $controllers = array();

        foreach($controllerClasses as $controller) {
            App::uses($controller, 'Controller');
            $methods = get_class_methods($controller);
            foreach($methods as $k => $v) {
                if ($v{0} == '_') {
                    unset($methods[$k]);
                }
            }
            $controllers[$controller] = array_diff($methods, $appControllerMethods);
        }

        return $controllers;
    }
}
