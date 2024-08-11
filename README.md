# Vinted home asignment

## Commandline

To seed the data required for this project, run the following command:
```bash
php src/data/seeder.php
```

To execute the main script and generate the results, use the following command:
```bash
php main.php
```

To run the unit tests, ensure that your PHP version is at least 8.2. Before running the tests, uncomment the fourth line in `main.php`
Install the necessary dependencies and run the tests with the following commands:
```bash
composer install
php ./vendor/bin/phpunit
```

## Data

In the `src/data` directory, you will find:

- `input.txt` contains purchase records in text format.
- `couriers.txt`, `sizes.txt`, and `prices.txt` contains files in PHP serialization format.
- `test-text.txt`, `test-sizes.txt`, `test-prices.txt`, `test-couriers.txt` contains files for testing
- `seeder.php` contains script that serializes data from arrays and seeds it into the aforementioned files.

## Workflow

### Initialization and Data Preparation

1. **Instantiation of CourierPriceController**

   An instance of the `CourierPriceController` class is created and its method `countPricesAndDiscounts()` is invoked in `main.php`.

2. **Data Collection and Processing by DataCollector**

   The constructor of `CourierDataService` object instantiates a `DataCollector` object.
   `DataCollector` provides functions for:
    - Extracting data from text files
    - Unserializing data as needed
    - Selecting relevant information
    - Connecting datasets if required

3. **Data Preparation by CourierDataService**

   The constructor of `CourierPriceController` initializes a `CourierDataService` object. This service is responsible for preparing data for the `CourierPriceController`.
    - `input.txt` is parsed into a two-level nested array
    - Data from `couriers.txt`, `sizes.txt`, and `prices.txt` is connected into a unified array, selecting only the required values (short names for sizes, couriers, and prices)
    - Separate price arrays are prepared for different sizes

    `CourierDataService` utilizes the static class `Functions` with abstract methods to facilitate data handling 

### Data Processing

4. **Validation and Discount Calculation**

   - The `countPricesAndDiscounts()` method of `CourierPriceController` validates the data using the static `Validator` class.
    - The method utilizes functions within `CourierPriceController` to calculate available discounts. Items with invalid data are labeled as "Ignored", while valid entries have their discounts and courier shipping costs computed and incorporated accordingly.

5. **Output Generation**

   - After discount calculations, an `Output` object is created.
   - The `Output` object converts the processed array into a string format and formats the prices as needed.

## Authors

Rugilė [Github](https://github.com/kauste)