<?php
/**
 * A simple CakePHP component that returns a list of controllers.
 *
 * Copyright (c) by Daniel Hofstetter (daniel.hofstetter@42dh.com, http://cakebaker.42dh.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ControllerListComponent extends Component {
    public $parentControllers = array('AppController');
    public $includePlugins = false;

    public function getList(Array $controllersToExclude = array('PagesController')) {
        foreach($this->parentControllers as $parentController) {
            $controllersToExclude[] = $parentController;
        }

        $results = array();
        $results += $this->getControllers($controllersToExclude);

        if ($this->includePlugins) {
            foreach (CakePlugin::loaded() as $plugin) {
                $controllersToExclude[] = $plugin . 'AppController';
                App::uses($plugin . 'AppController', $plugin . '.Controller');
                $results += $this->getControllers($controllersToExclude, $plugin);
            }
        }

        return $results;
    }

    private function getControllers($controllersToExclude, $plugin = '') {
        $pluginPrefix = $plugin == '' ? '' : $plugin . '.';
        $package = $pluginPrefix . 'Controller';
        $controllerClasses = array_filter(App::objects($package), function ($controller) use ($controllersToExclude) {
            return !in_array($controller, $controllersToExclude);
        });

        $result = array();

        foreach($controllerClasses as $controller) {
            $controllerName = str_replace('Controller', '', $controller);
            $result[$pluginPrefix . $controller]['name'] = $controllerName;
            $result[$pluginPrefix . $controller]['displayName'] = Inflector::humanize(Inflector::underscore($controllerName));
            $result[$pluginPrefix . $controller]['actions'] = $this->getActions($controller, $package);
        }

        return $result;
    }

    private function getActions($controller, $package) {
        App::uses($controller, $package);
        $methods = get_class_methods($controller);
        $methods = $this->removeParentMethods($controller, $methods);
        $methods = $this->removePrivateActions($methods);

        return $methods;
    }

    private function removeParentMethods($controller, Array $methods) {
        foreach($this->parentControllers as $parentController) {
            if (is_subclass_of($controller, $parentController)) {
                $parentMethods = get_class_methods($parentController);
                $methods = array_diff($methods, $parentMethods);
            }
        }

        return $methods;
    }

    private function removePrivateActions(Array $methods) {
        return array_filter($methods, function ($method) {
            return $method{0} != '_';
        });
    }
}
