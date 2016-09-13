# Mayflower Assets Integration

Configured CircleCI for [massgov/mayflower](https://github.com/massgov/mayflower) to build the production artifact on every build but only deploy the artifact when a release is cut. The deployment script uses phing and copies the built artifact into a clone of [palantirnet/mayflower-artifacts](https://github.com/palantirnet/mayflower-artifacts) and commits all the changes, tags with the same release version of [massgov/mayflower](https://github.com/massgov/mayflower). 

A special Github user [palantirnet-temp1](https://github.com/palantirnet-temp1) was created that has access to both [massgov/mayflower](https://github.com/massgov/mayflower) and [palantirnet/mayflower-artifacts](https://github.com/palantirnet/mayflower-artifacts). [massgov/mayflower](https://github.com/massgov/mayflower) has been configured to use [palantirnet-temp1](https://github.com/palantirnet-temp1) as [checkout keys](https://circleci.com/gh/massgov/mayflower/edit#checkout). 

See [https://github.com/massgov/mayflower/pull/49](https://github.com/massgov/mayflower/pull/49) and [https://github.com/massgov/mayflower/pull/50](https://github.com/massgov/mayflower/pull/50) for this work.

[palantirnet/mayflower-artifacts](https://github.com/palantirnet/mayflower-artifacts) is configured with a [composer.json](https://github.com/palantirnet/mayflower-artifacts/blob/master/composer.json). (Note: I am unsure if the license or authors is correct)

The last bit of work was done to [palantirnet/mass](https://github.com/palantirnet/mass) to include [palantirnet/mayflower-artifacts](https://github.com/palantirnet/mayflower-artifacts) as a composer dependency. I created a new phing build file to symlink the assets to the theme directory.

See [https://github.com/palantirnet/mass/pull/7](https://github.com/palantirnet/mass/pull/7) for this work.

My work completed should mirror [https://docs.google.com/document/d/1h2ZZo-8x3vf3cHL0tyrT3emxDDClvBDin-wlHHQThMk/edit#](https://docs.google.com/document/d/1h2ZZo-8x3vf3cHL0tyrT3emxDDClvBDin-wlHHQThMk/edit#).
