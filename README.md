# Apedik/Test

This Magento 2 module demonstrates a dynamic approach to adding extension attributes to orders using plugins and `di.xml` configuration.

## Purpose

The primary purpose of this module is to showcase a flexible and maintainable way to extend the `Magento\Sales\Api\Data\OrderInterface` with custom attributes. Instead of hardcoding the logic for each attribute in a plugin, this approach uses `di.xml` to define the mapping between extension attribute codes and their data sources, which can be either existing order data keys or dedicated hydrator classes for complex logic.

## Key Features

* **Dynamic Extension Attribute Population:** Adds extension attributes to orders based on `di.xml` configuration.
* **Flexibility:** Easily add or modify extension attributes without changing the plugin's code.
* **Maintainability:** Keeps code clean and organized, reducing the risk of conflicts and making upgrades smoother.
* **Scalability:** Supports a growing number of extension attributes without code bloat.
* **Hydrator Classes (Optional):** Allows for complex attribute logic to be encapsulated in dedicated classes.

## Installation

1.  **Install via Composer (Recommended):**

    ```bash
    composer require apedik/test
    ```

2.  **Enable the module:**

    ```bash
    bin/magento module:enable apedik_test
    ```

3.  **Run setup upgrade:**

    ```bash
    bin/magento setup:upgrade
    ```

4.  **Compile (if needed):**

    ```bash
    bin/magento setup:di:compile
    ```

5.  **Flush cache:**

    ```bash
    bin/magento cache:flush
    ```

## Usage

After installation, the module will dynamically add the following extension attributes to orders:

* `custom_attribute_1`: Populated with the order's customer email.
* `custom_attribute_2`: Populated with the order's total quantity ordered.
* `complex_attribute`: Populated with a combination of the customer group ID and order status, calculated by a dedicated hydrator class.

To test the module:

1.  Place an order in your Magento store or retrieve an existing order.
2.  Observe the extension attributes in the order data (e.g., using `bin/magento sales:order:get <order_id>` or by inspecting the order in the Magento admin).
