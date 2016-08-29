# Deploying a local install to Acquia

This document describes taking a local installation of the site and deploying a complete copy of it to Acquia.

## Steps

1. Install the site locally
1. Generate a database artifact and install on Acquia
1. Sync files
1. Deploy code
1. Select new tag on Acquia (if deploying from a tag)
1. Take Acquia site out of maintenance mode

## Database

From your VM:

```
vendor/bin/phing drupal-dump-db
```

From your host machine:

```
scp artifacts/db-XYZ.sql.gz massgovdemo.dev@free-5792.devcloud.hosting.acquia.com:
ssh massgovdemo.dev@free-5792.devcloud.hosting.acquia.com 'drush @massgovdemo.dev ah-db-import --drop ~/db-XYZ.sql.gz'
```

## Files

From your host machine:

```
(cd web/sites/default && rsync -rltDvPh --delete files/ massgovdemo.dev@free-5792.devcloud.hosting.acquia.com:dev/files)
```

## Code

From your VM:

```
vendor/bin/phing deploy -Dbuild.env=acquia-dev
```

## On Acquia

Log in to the Acquia UI and verify the correct branch or tag is deployed: [https://insight.acquia.com/cloud/workflow?s=3679931](https://insight.acquia.com/cloud/workflow?s=3679931)

Clear the Drupal cache:

```
ssh massgovdemo.dev@free-5792.devcloud.hosting.acquia.com 'drush @massgovdemo.dev cache-rebuild'
```

Log in to the site and take it out of maintenance mode: [http://massgovdemoq3hkjviknb.devcloud.acquia-sites.com//](http://massgovdemoq3hkjviknb.devcloud.acquia-sites.com//)

## Reference

* [rsyncing files on Acquia cloud](https://docs.acquia.com/articles/rsyncing-files-acquia-cloud)
* [Assessing disk space usage](https://docs.acquia.com/articles/assessing-disk-space-usage)
* [Importing your files](https://docs.acquia.com/cloud/site/import/manual/files)
* [Importing your database](https://docs.acquia.com/cloud/site/import/manual/database)
* [rsync man page](http://linux.die.net/man/1/rsync)
