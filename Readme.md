# ControllerList component for CakePHP

## Purpose

A simple component for CakePHP 2.x which returns a list of controllers and the corresponding action names.

## Installation

Copy the file `app/Controller/Component/ControllerListComponent.php` to the `Controller/Component` folder of your application.

## Usage

First, you have to add the component to the `$components` array of your controller(s): `public $components = array('ControllerList');`.

Then you can use the component in your action(s) with: `$this->ControllerList->getList()`. You can also specify the controllers which should be excluded from the returned list: `$this->Controller->getList(array('UsersController'))`. Please note that without this parameter, the `PagesController` is automatically excluded.

The structure of the returned array is like:
```php
<?php
array(
  'ExampleController' => array(
    'name' => 'Example',
    'displayName' => 'Example',
    'actions' => array(
      (int) 0 => 'index',
      (int) 1 => 'show'
    )
  ),
  'VendorExampleController' => array(
    'name' => 'VendorExample',
    'displayName' => 'Vendor Example',
    'actions' => array(
      (int) 0 => 'index',
      (int) 1 => 'callback',
      (int) 2 => 'api'
    )
  )
)
```

## Changes

### v2.0.0 (2012-07-30)

* Added parameter `$controllersToExclude` to the `getList()` method
* Changed the structure of the returned array by including the keys `name`, `displayName` and `actions`. Thanks to [Charles A. Beasley](https://github.com/carmelchas)!

### v1.0.0 (2012-01-29)

* Adapted for CakePHP 2.x. Thanks to [Paolo Iulita](https://github.com/paoloiulita)!

### 2010-06-29

* Initial release

## Contact

If you have questions or feedback, feel free to contact me via Twitter ([@dhofstet](https://twitter.com/dhofstet)) or by email (daniel.hofstetter@42dh.com).

## License

The ControllerList component is licensed under the MIT license.
