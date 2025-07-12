# Weight Based Shipping Plugin for Bagisto

This plugin provides a flexible weight-based shipping method for your Bagisto e-commerce store. It allows you to define shipping rates based on the total weight of the products in the customer's cart, configurable directly from the Bagisto admin panel.

## Features

*   **Weight-Based Calculation:** Dynamically calculates shipping costs based on the aggregated weight of all items in the cart.
*   **Configurable Rates:** Define multiple weight tiers and their corresponding prices (e.g., 0-1kg costs X, 1-5kg costs Y, etc.).
*   **Admin Panel Integration:** Easily enable, disable, and configure the shipping method via the Bagisto admin interface.
*   **Multi-Channel & Multi-Locale Support:** Compatible with Bagisto's multi-channel and multi-locale features.

## Installation

### Via Composer

Once this package is published on Packagist, you can install it directly via Composer:

1.  **Require the package:**
    ```bash
    composer require prasanna/weight-based-shipping
    ```

2.  **Register the Service Provider:**
    Open `config/concord.php` and add the following line to the `'modules'` array:
    ```php
    // config/concord.php

    'modules' => [
        // ... other modules
        \Prasanna\WeightBasedShipping\Providers\WeightBasedShippingServiceProvider::class,
    ],
    ```

3.  **Clear Caches:**
    ```bash
    php artisan optimize:clear
    ```

### Manual Installation

1.  **Download the Plugin:**
    Download the `weight-based-shipping.zip` file (or clone the repository) and extract its contents.

2.  **Place the Plugin Files:**
    Create a new directory `packages/Prasanna/WeightBasedShipping` in your Bagisto project's root and place all the plugin files inside it. The structure should look like:
    ```
    bagisto/
    ├── packages/
    │   └── Prasanna/
    │       └── WeightBasedShipping/
    │           ├── src/
    │           │   ├── Carriers/
    │           │   ├── Config/
    │           │   ├── Providers/
    │           │   ├── Resources/
    │           │   └── Routes/
    │           └── composer.json
    └── ...
    ```

3.  **Update Root `composer.json`:**
    Open your Bagisto project's root `composer.json` file and add the following entry to the `"psr-4"` section within the `"autoload"` object:
    ```json
    // composer.json

    "autoload": {
        "psr-4": {
            // ... existing entries
            "Prasanna\\WeightBasedShipping\\": "packages/Prasanna/WeightBasedShipping/src/"
        }
    },
    ```
    **Important:** Ensure the backslashes are correctly escaped (`\\`).

4.  **Register the Service Provider:**
    Open `config/concord.php` and add the following line to the `'modules'` array:
    ```php
    // config/concord.php

    'modules' => [
        // ... other modules
        \Prasanna\WeightBasedShipping\Providers\WeightBasedShippingServiceProvider::class,
    ],
    ```

5.  **Run Composer and Artisan Commands:**
    From your Bagisto project's root directory, run these commands:
    ```bash
    composer dump-autoload
    php artisan optimize:clear
    ```

## Configuration

1.  **Log in to Bagisto Admin:**
    Access your Bagisto admin panel.

2.  **Navigate to Shipping Methods:**
    Go to `Configure > Sales > Shipping Methods`.

3.  **Configure Weight Based Shipping:**
    *   Find and click on "Weight Based Shipping".
    *   **Title:** Enter a display title for the shipping method (e.g., "Standard Weight Shipping").
    *   **Description:** Provide a brief description.
    *   **Rates:** This is crucial. Enter your weight tiers and prices as a comma-separated list of `weight:price` pairs.
        *   Example: `0:10,5:25,10:40`
        *   This means:
            *   For total cart weight from 0 up to (but not including) 5, the price is 10.
            *   For total cart weight from 5 up to (but not including) 10, the price is 25.
            *   For total cart weight 10 and above, the price is 40.
        *   **Important:** Ensure your first rate starts with `0` to cover all weights from zero.
    *   **Status:** Set to `Active` to enable the shipping method.
    *   Click "Save".

4.  **Add Weight Attribute to Products:**
    *   Go to `Catalog > Attributes` and ensure you have an attribute with the code `weight`. If not, create one (e.g., `text` type, `decimal` validation).
    *   Go to `Catalog > Products`, edit your products, and assign appropriate numerical values to their `weight` attribute.

## Usage

Once configured, during the checkout process, if the total weight of the items in the customer's cart falls within one of your defined weight ranges, the "Weight Based Shipping" option will appear with the corresponding calculated price.

## Compatibility

This plugin has been developed and tested with Bagisto versions running Laravel 11 and PHP 8.2+. Compatibility with older Bagisto versions (e.g., Laravel 10, PHP 8.1) is not guaranteed and may require modifications.

## Contributing

Feel free to fork this repository, make improvements, and submit pull requests.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
