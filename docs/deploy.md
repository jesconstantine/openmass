# TL;DR

To deploy to Acquia dev, run the following command from within Vagrant (*on a clean tag*):

`vendor/bin/phing -f build/deploy.xml`

# Deployment Artifact

A Drupal deployment consists of three things:
1) Code (managed in a version controll system, usually git)
2) A database (which reflects changes made by or in code)
3) Files (because the database references files)

Without all three components you do not have a fully deployable Drupal artifact.

The deployment artifact may be able to be build in-place (such is the case in a prod deployment where the database is not built in a separate environment but is changed "live" and in-place).

# Execution Order

When a deployment is needed, the following things must happen to the existing codebase, database, and files:

1) The codebase must be updated to reflect the desired deployment status
2) The database needs to be updated in two ways: config needs to be imported *and then* update hooks need to be run.
3) Files need to stay in place.

Any deployment process, whether scripted or done by handed, must execute these steps in this order to be successful.

# Promoting Deployment Artifacts  

## To Dev
Deploying to the dev environment involves building a full Drupal Deployment Artifact locally (by pulling the database and files from canonical, then running processes on them) and then putting all three components of the artifact in the dev environment at once.

## To Staging
`@todo Moshe?`

## To Production
`@todo Moshe?`
