Requirements
------------

* See requirements for Yii2 application
* Apache web server v.2 with mod_rewrite installed
* MySQL v.5.5. or higher
* Composer installed

Installation
------------

Say you have directory `~/public_html` for your web projects

**Copy the application to your local computer:**

```
cd ~/public_html
git clone https://github.com/vkabachenko/yii2-eer.git
```

**Download all dependencies via composer:**

```
cd yii2-eer
composer global require "fxp/composer-asset-plugin:~1.1.0"
composer install
```

**Initialize the installed application**

```
php init
chmod 0777 frontend/web/files
```

**Set document root of your Web server**

For `path/to/public_html/yii2-eer/` using the Url `http://site.com`

**Database adjustment**

* Create new database with `utf8_unicode_ci` collation
* Import tables structure from `yii2-eer/common/schema/eer.sql`
* In `common/config/main-local.php` set dbname, login and password for database
* Create the user `admin` and his password:

```
cd yii2-eer
php yii admin/user
```

**Launch the application**

* In user mode: `http://site.com`
* In administrator mode: `http://site.com/administrator`

