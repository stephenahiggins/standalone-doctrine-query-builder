# Standalone Doctrine Query Builder
A standalone implementation of the Doctrine Query Builder. Removes the dependency on having a Doctrine DB connection. This is useful for building queries for other DB connections, or using PDO to execute the query.
All credit goes to the original Doctrine team. 

**Note:** This is a work in progress and is not ready for production use.

## Installation
Add the repository to your project's `composer.json`.

## Usage
```php
$qb = new StandaloneQueryBuilder();
$qb->select('*')
    ->from("test_table", 'tt')
    ->innerJoin('tt', "test_table2", 'tt2', "tt.id = tt2.id")
    ->leftJoin('tt', "test_table3", 'tt3', "tt.id = tt3.id")
    ->rightJoin('tt', "test_table4", 'tt4', "tt.id = tt4.id")
    ->setMaxResults(100);
    
// Get the SQL
$query = $qb->getSQL();
```

### Running Tests
Run `make run-tests`.

## Support
Please open an issue. Pull requests are welcome.