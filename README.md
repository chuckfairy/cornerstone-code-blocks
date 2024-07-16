# Cornerstone Code Blocks

Using [Highlight.js](https://github.com/highlightjs/highlight.js) create a new [Themeco Cornerstone](https://theme.co/pro) element that outputs a code block.


## Features

- Cornerstone native controls including loopers, conditions, custom attributes, and custom CSS
- Sample Prefab with copy code button
- Over 200 colorschemes
- Support for over 150 languages and file types


## Requirements

- [WordPress](https://wordpress.com)
- [Themeco X / Cornerstone / Pro](https://theme.co), works best on Cornerstone 7.5.0+


## Filters

### Changing the Default values

The filters in place are the following as well as their default values.

```php
// Defaults
$language = apply_filters('cs_code_blocks_default_language', 'javascript');
$tabSize = apply_filters('cs_code_blocks_default_tab_size', 2);
$colorScheme = apply_filters('cs_code_blocks_default_tab_size', 'tomorrow-night-bright');
```

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

When editing TSS, Cornerstone will cache the output of styles. To turn off this feature, tap into the following filter.

```php
add_filter('cs_disable_style_cache', '__return_true');
```
