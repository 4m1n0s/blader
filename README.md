
# Blader

HTML Generator using Laravel Blade templating engine

### Requirements
+ PHP > 7.3
+ Node + NPM

### Installation
first install a fresh project of blader

    composer create-project iamine/blader blader

after you creating your project with composer cd inside project and run:

    npm install

### Folders Structure

    source/
	    _assets/
	    _components/
	    _layouts/
	    index.blade.php

Any folder or file start with ( _ ) will be ignored during the compiling proccess.

[ _assets ] for static assets like js, sass, css.... this folder will be compiled to assets in source directory and then will be copied to the compiled directory.

[ _components ] where blade components live.

### Available Commands

#### PHP Commands

    php blader build

this will generate a compiled version of your project

#### NPM Commands

    npm run dev

    npm run watch
	
	npm run prod

npm prod will generate a beautified version of HTML files.

### LICENSE
The MIT License (MIT).