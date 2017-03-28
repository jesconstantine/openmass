Administrative Notes for OpenMass project

Fetching DB/files from the Mass project
-------------
- drush sql-sync --sanitize @massgov.prod @self && drush sql-dump --gzip
- drush rsync @massgov.prod:%files @self:%files && make-a-tarball
- [Push both tarballs above to S3](https://console.aws.amazon.com/s3/buckets/openmass/?region=us-east-1&tab=overview)

Fetching new code from Mass project
-------------
- Merge PR from develop to openmass_master branches.
  - Resolve any conflicts
  - Make sure tests pass
- Push openmass_master branch to openmass repo

Making a new OpenMass release
----------
- Make sure tests are passing on master branch
- Release notes may be built from the commits on massgov/develop 
- Create a new release via Github releases
 