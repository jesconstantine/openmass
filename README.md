# OpenMass - a constituent focused web platform.

## Requirements

* MySQL/MariaDB 
* [git](https://git-scm.com/downloads)
* [composer](https://getcomposer.org/)

## Getting Started

The following is just one way to install OpenMass. Customize to taste.

1. Get the latest code, database, and uploaded files tarball from https://github.com/massgov/openmass/releases
1. You may find it convenient to create an "artifacts" directory in your project root to store the database dump.  Files in this directory will be ignored by Git.
1. Extract the files tarball to web/sites/default/files
1. `composer install`. Your codebase is now assembled.
1. Configure web/sites/default/settings.php for your database.  Add a hash_salt value.
1. `cd web`
1. Import the database `../vendor/bin/drush sql-query --file=/path/to/dump.sql.gz`
1. Unzip uploaded_files.tar.gz into sites/default/files
1. Start a development web server `../vendor/bin/drush runserver`
1. To get a URL for logging in as a superuser `../vendor/bin/drush uli --uri=http://127.0.0.1:8888`

## Customizing Look and Feel
One innovative feature of this platform is its use of a [Pattern Lab](http://patternlab.io) style guide to theme most pages. Our Pattern Lab implementation, [Mayflower](https://github.com/massgov/mayflower), is a uniform look and feel for all web properties that serve Massachusetts. 
 
#### Quick customization
1. Fork the [mayflower-artifacts](https://github.com/massgov/mayflower-artifacts) repo
1. Edit to taste
Edit composer.json to point to your fork
 
#### Thorough customization
1. Fork the mayflower repo
1. Edit to taste
1. Build a new Pattern lab style guide and save its output into a new "artifacts repo" which is referenced from your composer.json. Your artifacts repo should be laid out exactly like [mayflower-artifacts](https://github.com/massgov/mayflower-artifacts). 
 

## Roadmap
- One day soon, this platform will install without using a database as a seed.
- One day soon, we will have regular contributor calls to work on the platform

## Credits
- Built by MassIT for the Commonwealth of Massachusetts
