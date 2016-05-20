### Installation


```bash
// Clone current repository as [my/www/folder]
git clone git@github.com:dropdog/rightclick.git [my/www/folder]

// Get into the folder
cd [my/www/folder]

// Switch to develop branch
git checkout develop

// Install Drupal with Drush or through the UI
drush site-install dropdog --db-url="mysql://[db_user]:[db_pass]@localhost/[db_name]" --account-name="admin" --account-pass="admin"
```

### Development mode

```
// In order to complete the development mode run this script.
// This will add custom development settings, modules, trusted domains etc
// and no other script need to run on the site.
yes | sudo bash $(drush dd)/profiles/dropdog/dev-scripts/full-dev-setup.sh

```

### Live mode

```bash
// Just edit the settings.php file and change the $mode variable to 'live'
```

-------------

### Individual commands to allow Development mode

If you already have run the command above you don't need to run any other commands.
But in case you want to do specific tasks on the site you have the options bellow.

#### Enable development mode

```
// Enable development mode by sourcing the development files to settings.php
sudo bash $(drush dd)/profiles/rightclick/dev-scripts/enable-dev.sh
````

#### Enable development drupal modules

```
// Enable common development modules (which are not enabled by default)
drush en -y devel devel_generate kint webprofiler dblog
````

By default the trusted domains **will not be enabled** on settings.php but you can do it easily.
To enable them change:

```
// Find in settings.php
$trusted_domains = TRUE;
```

#### After build tasks

```bash
drush entity-updates -y
drush php-eval 'node_access_rebuild();'
drush cr
```

or in one line all together:

```bash
drush entity-updates -y && drush php-eval 'node_access_rebuild();' && drush cr
```
