# Change Log for WebPurify

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## 4.0 - 2016-08-04

* Preventing users from directly accessing the plugin files.
* Autmatic updates to codekit.config files.

### BuddyPress integration is complete.

* Activity content, comments, and actions
* Blog activity, from above
* Group name, description, and activity
* Private message subjects and contents
* Profile field groups, names, and user supplied data
* Other components like Settings & Notifications will inherit from the above changes

### Additional Fixes

* Stored XSS in saving admin options
* Redirect hi-jacking on saving admin options
* Unprefixed options were getting saved into the options table, they no longer are
* The additional options caching function was actually hurting performance, by triggering 6 calls to get_option() only to get 1 option from the array. This was removed, and fixed to only use get_option() with default values as necessary. (WordPress options are pre-fetched by default, meaning there is no performance hit for calling the function multiple times, so long as you’re actually using the results of the function.)
* Fixed several debug and fatal errors when navigating around, saving, and drafting new posts. Originally, the plugin was causing WordPress’s “Add New” post screen to fatal error.

## 3.4.4 - 2016-07-22

- Resolves a problem with the 'Mode of operation' checkbox that was
  unconditionally firing when submitting a comment.
- Updating the language of the label for the 'Mode of Operation' checkbox.

## 3.4.3 - 2016-07-22

- Completing the front-end comment checking.
- Documenting outstanding TODO messages.

## 3.4.2 - 2016-07-22

- Adding front-end comment checking.

## 3.4.1 - 2016-07-21

- Fixes when users would leave the page and come back to the page.
  The checkbox value for the mode would not persist.

## 3.4.0 - 2016-07-21

- Adding internationalization functionality
- Adding internationalization files

## 3.3.0 - 2016-07-20

- Removing the helper functions file because it's no longer needed
- Adding functions to more easily communicate with the REST API and update the lists.
- Updates how the lists are modified on save
- Updates i18n functions
- Automatic codekit update
- Adds JavaScript for saving options and for M4
- Adds a checkbox to the options page to handle a new mode of operation
- Monitors the post title and the post content from the dashboard. Prompts the
  user if they having profanity or a blacklisted word found before submitting.

## 3.2.0 - 2016-07-19

- Removes old comment serialization code (which was done by direct queries)
- Makes use of a WordPress filter to sanitize the comment content
- Adds functionality to also sanitize the comment name
- Removes old post serialization code (which was done by direct queries)
- Uses a WordPress filter to purify the post title, post content, and post name
- Sanitizes the options being written to the database
- Introduces functionality for adding and removing words to the blacklist
- Introduces functionality for adding and removing words to the whitelist

## 3.2.0 - 2016-07-13

- Adds a function for properly including the display of the options template.
- Updates the 'Save' button to match the WordPress skin.
- Improves the language preference by using a `select` element rather than
  radio buttons.
- Resolves problems when saving radio button values.

## 3.1.0 - 2016-07-13

- Updates the webpurifytextreplace-options.php to the WordPress Coding Standards
- Applies parameterized, prepared database queries
- Updates gitignore to ignore irrelevant files for source control
- Updates the webpurifytextreplace.php to the WordPress Coding Standards
- Adds TODO notes for when its time to improve the security of the front-end
