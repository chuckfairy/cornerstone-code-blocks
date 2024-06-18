# Cornerstone Code Blocks

Using [Highlight.js](https://github.com/highlightjs/highlight.js) create a new [Cornerstone](https://theme.co/pro) element that outputs a code block.


## Features

- Cornerstone native controls including loopers, conditions, custom attributes, and custom CSS
- Sample Prefab with copy code button
- Over 200 colorschemes
- Support for over 150 languages and file types


## Filters


## Building

Requires

- `bash`
- `npm i -g esbuild`
- `npm i -g node-sass`

Building

```sh
npm run build;

# Or individually
npm run build-css;
npm run build-js;
npm run build-plugin;

# Scripts are also in ./bin/
```

## Developing Cornerstone Elements

When editing TSS, Cornerstone will cache this output. To turn off this feature, tap into the following filter.

```php
add_filter('cs_disable_style_cache', '__return_true');
```
