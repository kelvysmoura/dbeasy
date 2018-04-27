# DBEasy - Documentation - 1.0.0

## Autoload e Connection
```php
// Autoload
require_once 'dbeasy-path/autoload.php';

// Namespace
use Core\DBEasy;

// Connection
$dbe = new DBEasy([
  'host' => '';          // optional // value default: 'localhost'
  'port' => '';          // optional // value default: empty
  'dbname' => '';        // required // value default: 'undefined'
  'user' => '';          // optional // value default: 'root'
  'pass' => '';          // optional // value default: empty
]);
```

## Create
```
$dbe->create('your-table-name')->set(['colname' => 'value', 'colname' => 'value'])->run();
```
*Notes about create() method*
- your table name and array in set method is required
- value default in create() methods is: 'undefined'

## Read
```php
// Simple read
$dbe->read('your-table-name')->cols()->run();

// Read by id
$dbe->read('your-table-name')->cols()->id(1)->run();

// Read by outher column
// wh = where
$dbe->read('your-table-name')->cols()->wh('colname', 'value')->run();

// Read by limits
$dbr->read('your-table-name')->cols()->limit(3)->run();

// Read by order
$dbr->read('your-table-name')->cols()->orderBy('id Desc')->run();

```
*Notes about read() method*
- your table name and cols() is required
- value default in cols() method is: '*'
- value default in read() methods is: 'undefined'

## Update
```
$dbe->update('your-table-name')->set(['colname' => 'value', 'colname' => 'value'])->id(1)->run();
```
*Notes about update() method*
- your table name and array in set method is required
- value default in update() methods is: 'undefined'

## Delete
```
// Delete by id
$dbe->delete('your-table-name')->id(1)->run();

// Delete all
$dbe->delete('your-table-name')->all()->run();
```
*Notes about delete() method*
- your table name and secundary method is required
- value default in delete() methods is: 'undefined'
