# Social Sensei Development

## Docker / WP ENV

To develop using docker, you can use WP ENV.  Be sure to be in the root directory of the plugin and then run the following commands.

```
npm -g i @wordpress/env
```
```
cp .wp-env.example.json .wp-env.json
```
```
wp-env start
```

After a little bit of time this should spin up a blank WordPress install at localhost:8888 where you can test the plugin functionality.  Additional paramters can be added to the `.wp-env.json` file.  [More info can be found here.]('https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/#wp-env-json)

To bring the stack down you can run:

```
wp-env stop
```
