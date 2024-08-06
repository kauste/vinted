# Vinted home asignment

## Commandline

To execute the script and obtain the results, run the following command:

```bash
php main.php
```

## Data

In src/data directory you can find:
- input.txt file, where shipment price data is string
- providers.txt, sizes.txt and prices.txt files in PHP serialization format
- seeder.php file, where data is serialized from array and seeded to previously mentioned files
## Data

In the `src/data` directory, you will find:

- **`input.txt`** contains purchase records in text format.
- **`providers.txt`, `sizes.txt`, and `prices.txt`** contains files in PHP serialization format.
- **`seeder.php`** contains script that serializes data from arrays and seeds it into the aforementioned files.

## Workflow

### Initialization and Data Preparation

1. **Instantiation of `ProviderPriceController`**
   An instance of the **`ProviderPriceController`** class is created and its method **`countPricesAndDiscounts()`** is invoked in `main.php`.
3. **Data Collection and Processing by `DataCollector`**
   - The constructor  **`ProviderDataService`** object instantiates a **`DataCollector`** object.
   - **`DataCollector`** providers functions for:
        - Extracting data from text files.
        - Unserializing data as needed.
        - Selecting relevant information.
        - Connecting datasets if required.
2. **Data Preparation by `ProviderDataService`**
   The constructor of **`ProviderPriceController`** initializes a **`ProviderDataService`** object. This service is responsible for preparing data for the **`ProviderPriceController`**.
        - **`input.txt`** is parsed into a two-level nested array.
        - Data from **`providers.txt`**, **`sizes.txt`**, and **`prices.txt`** is connected into a unified array, selecting only the    required values (short names for sizes, providers, and prices).
        - Separate price arrays are prepared for different sizes.
   **`ProviderDataService`** utilizes the static class **`Functions`** with abstract methods to facilitate data handling

### Data Processing

4. **Validation and Discount Calculation**
   - The **`countPricesAndDiscounts()`** method of **`ProviderPriceController`** validates the data using the static **`Validator`** class.
    - The method utilizes functions within **`ProviderPriceController`** to calculate available discounts. Items with invalid data are labeled as "Ignored", while valid entries have their discounts and provider shipping costs computed and incorporated accordingly.

5. **Output Generation**
   - After discount calculations, an **`Output`** object is created.
   - The **`Output`** object converts the processed array into a string format and formats the prices as needed.

## Authors

Rugilė [Github](https://github.com/kauste)