# node-twig
A small Node.js module that lets you render Twig templates using the original PHP implementation.  
The package also supports Express.js so this can be used as a template engine.

There are a already some packages that render Twig templates but all use alternative implementations. The problem is that at the time of writing no other library seems to have all features the original PHP implementation has. That's the reason why we created this package.

## Install
Install this package through NPM.
```
npm install node-twig --save 
```
## Usage
### Standalone
```javascript
var renderFile = require('node-twig').renderFile;

renderFile('/full/path/to/template.twig', options, function (error, template) {
  // ... do something with the rendered template. :)
});
```

or with ES6/ES7

```javascript
import { renderFile } from 'node-twig';

renderFile('/full/path/to/template.twig', options, (error, template) => {
  // ... do something with the rendered template. :)
});
```

## Express
```javascript
var express = require('express');
var app = express();
var createEngine = require('node-twig').createEngine;

// See available options below this example.
app.engine('.twig', createEngine({
  root: __dirname + '/views',
}));

app.set('views', './views');
app.set('view engine', 'twig');

app.get('/', function (req, res) {
  // The second argument is basically the same options
  // object like above. Most of the time you will be passing
  // context data that will be available in the template.
  res.render('index', {
    context: {
      foo: 'bar',
      stuff: ['This', 'can', 'be', 'anything']
    }
  });
});
```

## Options
The options object can be passed to the `renderFile()` function to configure the Twig engine.
For convinience the `createEngine()` function can also consume the options which will then be the global defaults for the runtime. This is useful for global settings such as the root path, but not so useful for context information.

### root
default: `null`  
The *absolute* path to the main template directory. In Express this is probably the same as the value you set for `views` in `app.set('views', './your-root')` but please use an absolute path.

### context
default: `{}`  
The value of the context option will be available inside the Twig template. You can use scalar values, arrays or objects at any depths.

### extensions
default: `[]`  
Since Twig is a PHP library there is no (easy) way to make it extandable inside Node. That's the reason why we provide you with the `extensions` option.

An extension is just a function that takes a reference (*Always use the `&` sign for the parameter*) to the Twig environment which can then be used to define custom functions or filters. To allow for greater flexibility you can add multiple files.

Define your extensions like so:

```javascript
var options = {
  extensions: [
    {
      file: '/absolute/path/to/php/file.php',
      func: 'myTwigExtension'
    }
  ]
};
```

Your PHP file could look like this:

```php
<?php

function myTwigExtension(\Twig_Environment &$twig) {
  $twig->addFunction('url', new \Twig_SimpleFunction('url', function ($context, $destination) {
    return 'something-fancy';
  }));
}
```
