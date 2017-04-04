# OpenMass - a constituent focused web platform.

## Requirements

* MySQL
* [git](https://git-scm.com/downloads)
* [composer](https://getcomposer.org/)

## Getting Started

The following is just one way to install OpenMass. Customize to taste.

1. Get the latest code, database, and uploaded files tarball from https://github.com/massgov/openmass/releases
1. `composer install`. Your codebase is now assembled.
1. Configure web/sites/default/settings.php for your database.
1. `cd web`
1. Import the database `../vendor/bin/drush sql-query --file=/path/to/dump.sql.gz`
1. Unzip uploaded_files.tar.gz into sites/default/files
1. Start a development web server `../vendor/bin/drush runserver`
1. To get a URL for logging in as a superuser `../vendor/bin/drush uli --uri=http://127.0.0.1:8888`

## Roadmap

- One day soon, this platform will install without using a database as a seed.
- One day soon, we will have regular contributor calls to work on the platform

## Credits
- Built by MassIT for the Commonwealth of Massachusetts
