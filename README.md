# Module Pramod CustomerImport

    ``pramod/module-customerimport``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Importing customer from CSV, JSON etc. files.
Customer Import is a supportive marketing tool which allows store owners can import the customer using csv and json file via commend line.

sudo php bin/magento customer:import sample-csv sample.csv
sudo php bin/magento customer:import sample-json sample.json

## Installation
How to install Customer Import in Magento 2

### Type 1: Zip file

 - Unzip the zip file in `app/code/Pramod/CustomerImport`
 - Enable the module by running `php bin/magento module:enable Pramod_CustomerImport`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Install the module composer by running `composer require pramodguptabt07/module-customerimport:dev-main`
 - enable the module by running `php bin/magento module:enable Pramod_CustomerImport`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

## Configuration
  
## Specifications

 - Console Command
	- Import Csv File
      sudo php bin/magento customer:import sample-csv sample.csv
   - Import Json File
      sudo php bin/magento customer:import sample-json sample.json

## Attributes



