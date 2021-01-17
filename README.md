# Laravel Nova Boolean multi status Field

This field allows to display (and store/edit) multiple boolean values within 1 field as array or object.
Usually it is stored as json (but that depends purely on an Eloquent model implementation). 

Field accepts both array and object values.
If the data is an object, keys will be editable and will be displayed as tooltips (on hover)

[repository on github](https://github.com/jankapusta/nova-boolean-multi-status-field)

Posibility to edit boolean vaules (checkboxes) with string keys:

![Screenshot Form](screenshot-form.png)

Display boolean values using standard Nova icons. Showing keys on hover:

![Screenshot Index](screenshot-index.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require jankapusta/nova-boolean-multi-status-field
```

## Usage

Laravel migration example:

```php
$table->json('car_multi_status');
```


Laravel model example

```php
class Car extends Model {
    protected $casts = [
        'car_multi_status' => 'array',
    ];
    // ....
}

Car::create([
    'car_multi_status' => [
      'break_check' => true,
      'windows_check' => false,
      'engine_check' => true,
    ],
]);

```

Then add a field into Nova Resource

```php
BooleanMultiStatus::make('Car checks', 'car_multi_status')
// optional configuration
  ->showKeysAsTooltips(false) // to hide tooltips 
  ->width(80), // in pixels
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
