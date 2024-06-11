#!/bin/bash

# Run from the root directory
# Requires `npm i -g esbuild`

mkdir -p ./dist/js

esbuild --bundle ./src/cornerstone-code-blocks.js > ./dist/js/cornerstone-code-blocks.js
esbuild --bundle --minify ./src/cornerstone-code-blocks.js > ./dist/js/cornerstone-code-blocks.min.js
