# Cornerstone Code Blocks

Using [Highlight.js](https://github.com/highlightjs/highlight.js) create a new [Themeco Cornerstone](https://theme.co/pro) element that outputs a code block.

![Main Element](https://raw.githubusercontent.com/chuckfairy/cornerstone-code-blocks/master/screenshots/main_element.png)

![Code Area Prefab](https://raw.githubusercontent.com/chuckfairy/cornerstone-code-blocks/master/screenshots/code_area_prefab.png)


## Features

- Cornerstone native controls including loopers, conditions, styles, custom attributes, and custom CSS
- Sample Prefab with copy code button
- Over 200 colorschemes
- Support for over 150 languages and file types
- Will not output any CSS or JS to your page if it is not being used


## Requirements

- [WordPress](https://wordpress.com)
- [Themeco X / Cornerstone / Pro](https://theme.co), works best on Cornerstone 7.5.0+


## Parameters

You can setup a Dynamic select box with `dynamic:code_blocks_languages` for the languages and `dynamic:code_blocks_color_schemes` for the color schemes.

```json
{
  "language": {
    "type": "select",
    "initial": "javascript",
    "options": "dynamic:code_blocks_languages"
  },
  "colorScheme": {
    "type": "select",
    "initial": "tomorrow-night-bright",
    "options": "dynamic:code_blocks_color_schemes"
  }
}
```

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
