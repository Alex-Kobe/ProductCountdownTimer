# Woo Product Countdown Timer

This plugin is designed to add a countdown timer to the product page in woocommerce. This countdown timer determains when the product will be delivered to the client once ordered.

For example, an output from this program could be "Order within the next 2 hours 37 minutes 2 seconds to get delivery on Tuesday 25 Oct 2022". 

### Rules for the countdown timer

There are a few rules for this program to be functional.
- The product will be shipped on the same day unless the cut off time has passed.
- If the cut off time has passed, the item will ship the next available day.
- The product will deliver on the next available day after the product has been shipped.
- The administrator will have the ability to set holidays.
- On holidays, there will be no shipping or deliveries.
- There will also be no shipping or deliveries on weekends (Saturday & Sunday).

To calculate the shipping date, you need to...
	- make sure that the cut off for shipping on that day had not passed
	- make sure that there are no holidays on the day you plan to ship 
	- make sure that the shipping date is not on a weekend (Saturday & Sunday)

To calculate the delivery date, you need to delivery the next available delivery date...
	- there will be no deliverys on a weekend (Saturday & Sunday)
	- There will be no deliverys on a holiday

### Settings Page

There will be a settings page in which you will be able to set some parameters. This page will be split into "Countdown Settings", and "Holidays"

For Countdown settings, you will be able to
    - Enable the countdown plugin.
    - Change the cut off time for shipping same day.
    - Change the shipping date (so this makes it so when before the cut off time, it will ship on the value selected. Defaulted to same day).
    - Preview what the countdown timer will say.

For the Holidays, You will be able to set the holidays. These holidays will make that day act as a weekend to where there is no shipping or deliveries on that day.
    - You will be able to set the name of the holiday
    - You will be able to set the date of the holiday


## Prerequisites 

- Wordpress: This is a plugin designed for use in wordpress. This plugin cannot be used outside of wordpress. 
- WooCommerce: This is a plugin designed for use in WooCommerce. WooCommerce is not required for this to function, but I do use a WooCommerce functions to do things such as applying my code to pages that are only products. You will be able to modify these functions to suit the off the shelf/custom ecommerce platform you use.
- php 7.4: To use this script, you will need to have php 7.4. Some functions on this script where released in php 7.4, but the code can be changed to suit whatever php version you use.


## Installation

To install this plugin, you can download it from this repository. After this, you should have a wordpress instilation in which you should add this to the plugins folder. 

- path-to-wp-instalation/wp-contents/plugins/

After you have added the the plugin to your plugins folder, you can follow the steps below to get the plugin active.

- Rxtract the zip folder.
- Make sure that the plugin folder is named "ProductCountdownTimer". 
- Go into your wordpress dashboard & direct youself to your plugins section
- Enable the plugin

This will add a subdirectory to your sidebar and allow you to access the settings. Here you can change the settings previously spoken about in the document. To fiinish off, you will need to add shortcode to your products page where you would like to place your countdown timer. The shortcode should look like the below code.

```
[ countdown_timer ]
```