#!/bin/bash

FOLDER=./dist/cornerstone-code-blocks;

# Setup folder
mkdir -p $FOLDER;

# Clean
rm -rf $FOLDER/*;

# Copy files
cp -R ./ $FOLDER/;

# Clean build files
rm $FOLDER/package.json;
rm $FOLDER/package-lock.json;
rm -f $FOLDER/node_modules;
rm -f $FOLDER/src;
rm -f $FOLDER/.git
rm -f $FOLDER/dist/.gitkeep

# Create zip
zip -r ./dist/cornerstone-code-blocks.zip $FOLDER;
