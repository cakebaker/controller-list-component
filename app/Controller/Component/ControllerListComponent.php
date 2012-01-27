<?php
class ControllerListComponent extends Component {

	private $_excludedControllers = array( 'AppController', 'PagesController' );
	
	public function getList() {
		
		$controllerClasses = App::objects( 'Controller' );
		$appControllerMethods = get_class_methods( 'AppController' );
		$controllers = array();

		foreach( $controllerClasses as $controller ) { 
			if ( !in_array( $controller, $this->_excludedControllers ) ) { 
				App::uses( $controller, 'Controller' );
				$methods = get_class_methods( $controller );
				foreach( $methods as $k => $v ) {
					if ( $v{ 0 } == '_' ) {
						unset( $methods[ $k ] );
					}
				}
				$controllers[ $controller ] = array_diff( $methods, $appControllerMethods );
			}
		}
	
		debug( $controllers );
	}
}
?>