# Vinted home asignment

## Commandline

To execute the script and obtain the results, run the following command:

```bash
php main.php
```

## Data

In the `src/data` directory, you will find:

- **`input.txt`** contains purchase records in text format.
- **`couriers.txt`, `sizes.txt`, and `prices.txt`** contains files in PHP serialization format.
- **`seeder.php`** contains script that serializes data from arrays and seeds it into the aforementioned files.

## Workflow

### Initialization and Data Preparation

1. **Instantiation of `CourierPriceController`**
   An instance of the **`CourierPriceController`** class is created and its method **`countPricesAndDiscounts()`** is invoked in `main.php`.
3. **Data Collection and Processing by `DataCollector`**
   - The constructor  **`CourierDataService`** object instantiates a **`DataCollector`** object.
   - **`DataCollector`** couriers functions for:
        - Extracting data from text files.
        - Unserializing data as needed.
        - Selecting relevant information.
        - Connecting datasets if required.
2. **Data Preparation by `CourierDataService`**
   The constructor of **`CourierPriceController`** initializes a **`CourierDataService`** object. This service is responsible for preparing data for the **`CourierPriceController`**.
        - **`input.txt`** is parsed into a two-level nested array.
        - Data from **`couriers.txt`**, **`sizes.txt`**, and **`prices.txt`** is connected into a unified array, selecting only the    required values (short names for sizes, couriers, and prices).
        - Separate price arrays are prepared for different sizes.
   **`CourierDataService`** utilizes the static class **`Functions`** with abstract methods to facilitate data handling

### Data Processing

4. **Validation and Discount Calculation**
   - The **`countPricesAndDiscounts()`** method of **`CourierPriceController`** validates the data using the static **`Validator`** class.
    - The method utilizes functions within **`CourierPriceController`** to calculate available discounts. Items with invalid data are labeled as "Ignored", while valid entries have their discounts and courier shipping costs computed and incorporated accordingly.

5. **Output Generation**
   - After discount calculations, an **`Output`** object is created.
   - The **`Output`** object converts the processed array into a string format and formats the prices as needed.

## Authors

Rugilė [Github](https://github.com/kauste)