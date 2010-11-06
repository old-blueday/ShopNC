/*
 * readme.txt
 *
 * PHP Toolkit for PayPal v0.51
 * http://www.paypal.com/pdn
 *
 * Copyright (c) 2004 PayPal Inc
 *
 * Released under Common Public License 1.0
 * http://opensource.org/licenses/cpl.php
 *
 */

CHANGELOG
------------

1-13-2005
  - Removed .csv logging capabilities
  - Check pressence of "business" paramater ipn_success.php and ipn_error.php

REQUIREMENTS
------------

PHP 4.1.0 or Greater
URL: http://www.php.net

For SSL/HTTPS:
PHP 4.3.0 or greater compiled with OpenSSL support.
URL: http://www.php.net

OR

cURL 7.9.5 or Greater with OpenSSL support.
URL: http://curl.haxx.se


INSTALLATION
------------

Unzip all contents contained php_toolkit.zip.

Upload the PHP ToolKit folder and contents to the document root of your web site. The document root is the main directory containing all of your web site files.

Open the config.inc.php file located inside the includes directory and configure the script with your PayPal account settings.



Example Document Root: /home/yoursite/www
Example Installation Directory: /home/yoursite/www/php_toolkit

Configuration Information
Configuring PHP ToolKit is as simple as entering your order form variable names inside of the config.inc.php file. Most of the configuration options have already been pre-configured with PayPal.


FILE DESCRIPTIONS
-----------------
config.inc.php
Main configuration file for the script

global_config.inc.php
Contain global functions used through the script

payment.php
A pre-configred payment button for testing purposes

orderform.php
A pre-configred order form for testing purposes

process.php
Sends transaction information to PayPal for further processing

success.php
Displayed when transaction submitted to Paypal is approved

cancelled.php
Displayed when transaction submitted to PayPal fails

styles.css
Example stylesheet

ipn.php
Receives post back information from PayPal's API and parses the results

ipn_success.php
Executed if an IPN transaction is successful

ipn_error.php
Executed if an IPN transaction errors


CONFIGRURATION
--------------

The following variables are configurable in the config.inc.php file:

$paypal[url] (required)
PayPal API URL

$paypal[post_method] (required)
Post Methods: fso – use this method if PHP is compiled with OpenSSL support. curl – use this method if cURL is installed on your web server. libCurl – use this method if PHP is compiled with libCurl support. If your system does not support any of the post methods listed above, use “fso” as the default post method.

$paypal[curl_location] (optional)
If cURL is installed on your web server, set this option to the absolute path of cURL. (ex. /usr/bin/curl)

$paypal[business] (required)
Primary Account email address

$paypal[command] (required)
Must be set to “_xclick”.

$paypal[site_url] (optional)
URL of website you plan to run the script under. The site url must always have a trailing forward slash “/” after the domain name. (ex: http://www.paypalsolutions.com/)

$paypal[image_url] (optional)
URL of the 150x50 pixel image you would like to use as your logo.

$paypal[success_url] (optional)
URL path to where the user will be returned after completing the payment.

$paypal[cancel_url] (optional)
URL path to where the user will be returned if payment is cancelled.

$paypal[notify_url] (optional)
URL path to the IPN notification script.

$paypal[return_method] (optional)
Return URL behavior. If set to “1” the the buyer will be sent back to the success_url using a GET method. If set to “2” the buyer will be sent back to the success_url using a POST method.

$paypal[currency_code] (optional)
Defines the currency of the payment. (ex. USD, EUR, GBP)

$paypal[lc] (optional)
Sets the default country and associated language for the login or signup page that your customers see when they click your button. This field is set to “USA” by default.

$paypal[display_comment] (optional)
If set to “1” customers will not be prompted to include a note. If set to “0” customers will be prompted to include a note.

$paypal[comment_header] (optional)
Label that will appear above the notes field.

$paypal[background_color] (optional)
Sets the background color of your payment pages. 1=black 0=white

$paypal[display_shipping_address] (optional)
(optional)If set to “1” customers will not be asked for a shipping address. If set to “0” customers will be prompted to include a shipping address.

$paypal[item_name] (optional)
(optional)Description of item.

$paypal[item_number] (optional)
Item Number of the product.

$paypal[amount] (optional)
The price or amount of the purchase, not including shipping, handling, or tax.

$paypal[on0] (optional)
First option field name.

$paypal[os0] (optional)
First option field value.

$paypal[on1] (optional)
Second option field name.

$paypal[os1] (optional)
Second option field value.

$paypal[quantity] (optional)
Quantity of items to be purchased.

$paypal[edit_quantity] (optional)
If set to “1” the user will be able to edit the quantity. If set to “0” the quantity will not be editable by the user.

$paypal[invoice] (optional)
Transaction invoice number.

$paypal[tax] (optional)
Tax amount you would like to apply to the transaction.

$paypal[shipping_amount] (optional)
Flat shipping amount to charge.

$paypal[shipping_amount_per_item]
Flat shipping amount to charge for each additional item.

$paypal[handling_amount] (optional)
Item handling amount.

$paypal[custom_field] (optional)
Custom order form field.

$paypal[firstname] (optional)
Buyers firstname

$paypal[lastname] (optional)
Buyers lastname

$paypal[address1] (optional)
Buyers address 1

$paypal[address2] (optional)
Buyers address 2

$paypal[city] (optional)
Buyers city

$paypal[state] (optional)
Buyers state

$paypal[zip] (optional)
Buyers zip

$paypal[email] (optional)
Buyers email

$paypal[phone_1] (optional)
Buyers area code

$paypal[phone_2] (optional)
Buyers first 3 digits of phone number

$paypal[phone_3] (optional)
Buyers last 4 digits of phone number
