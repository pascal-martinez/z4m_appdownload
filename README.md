# ZnetDK 4 Mobile module: App Download (z4m_dbexport)
![Screenshot of the App Download view provided by the ZnetDK 4 Mobile 'z4m_appdownload' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_appdownload/screenshot.jpg)

The **z4m_appdownload** module allows you to download the software code, data, and documents of the [ZnetDK 4 Mobile](/../../../znetdk4mobile) starter application for backup purposes or to transfer the application to a new web host.

## LICENCE
This module is published under the [version 3 of GPL General Public Licence](LICENSE.TXT).

## FEATURES
This module contains the `z4m_appdownload` view to declare within the [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
of the application.  
This view shows 3 buttons to download in a ZIP archive the software code of the application, its data and its documents.  
The procedure to install the application on a new web hosting can also be displayed. 

## REQUIREMENTS
- [ZnetDK 4 Mobile](/../../../znetdk4mobile) version 2.9 or higher.

## INSTALLATION
1. Add a new subdirectory named `z4m_appdownload` within the
[`./engine/modules/`](/../../../znetdk4mobile/tree/master/engine/modules/) subdirectory of your
ZnetDK 4 Mobile starter App,
2. Copy module's code in the new `./engine/modules/z4m_appdownload/` subdirectory,
or from your IDE, pull the code from this module's GitHub repository,
3. Edit the App's [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and add a new menu item definition for the view `z4m_appdownload`.
For example:  
```php
\MenuManager::addMenuItem(NULL, 'z4m_appdownload', MOD_Z4M_APPDOWNLOAD_MENU_LABEL, 'fa-cloud-download');
```
4. Go to the **Download the APP** menu to display the module's view. 

## USERS GRANTED TO MODULE FEATURES
Once the **Download the APP** menu item is added to the application, you can restrict 
its access via a [user profile](https://mobile.znetdk.fr/settings#z4m-settings-user-rights).  
For example:
1. Create a user profile named `Admin` from the **Authorizations | Profiles** menu,
2. Select for this new profile, the **Download the APP** menu item,
3. Finally for each allowed user, add them the `Admin` profile from the
**Authorizations | Users** menu. 

## TRANSLATIONS
This module is translated in **French**, **English** and **Spanish** languages.  
To translate this module in another language or change the standard
translations:
1. Copy in the clipboard the PHP constants declared within the 
[`locale_en.php`](mod/lang/locale_en.php) script of the module,
2. Paste them from the clipboard within the
[`locale.php`](/../../../znetdk4mobile/blob/master/applications/default/app/lang/locale.php) script of your application,   
3. Translate each text associated with these PHP constants into your own language.
4. Copy the [`z4m_appdownload_instructions_en.php`](mod/view/z4m_appdownload_instructions_en.php) script of the module
in the [`./application/default/app/view/`](/../../../znetdk4mobile/blob/master/applications/default/app/view) subfolder of your application,
5. Remove the `_en` suffix to the copied PHP script so it is renamed to `z4m_appdownload_instructions.php`.
6. Translate into your own language the text within the `z4m_appdownload_instructions.php` script.

## CHANGE LOG
See [CHANGELOG.md](CHANGELOG.md) file.

## CONTRIBUTING
Your contribution to the **ZnetDK 4 Mobile** project is welcome. Please refer to the [CONTRIBUTING.md](https://github.com/pascal-martinez/znetdk4mobile/blob/master/CONTRIBUTING.md) file.
