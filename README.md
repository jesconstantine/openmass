# OpenMass - a constituent focused web platform.

## Requirements

* A LAMP stack
* [git](https://git-scm.com/downloads)
* [composer](https://getcomposer.org/)

## Getting Started

1. Get the latest code, database, and uploaded files tarball from https://github.com/massgov/openmass/releases
1. `composer install`. Your codebase is now assembled.
1. Configure your site's settings.php for your database.
1. Import the database
1. Unzip uploaded_files.tar.gz into sites/default/files
1. `web web && drush runserver`
3. Visit 127.0.0.1:8888

## Roadmap

-  One day soon, this platform will install without using a database as a seed.
- One day soon, we will have regular contributor calls to work on the platform

## Credits
- Built by MassIT for the Commonwealth of Massachusetts
- Maintained by Moshe Weitzman <weitzman@tejasa.com>
