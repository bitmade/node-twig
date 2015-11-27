# node-twig
A small Node.js module that lets you render Twig templates using the original PHP implementation.  
The package also supports Express.js so this can be used as a template engine.

## Install
Install this package through NPM.
```
npm install node-twig --save 
```
## Usage
### Standalone
```javascript
var renderTwig = require('node-twig').renderTwig;

renderTwig('/full/path/to/template.twig', options, function (error, template) {
  // ... do something with the rendered template. :)
});
```

or with ES6/ES7

```javascript
import { renderTwig } from 'node-twig';

renderTwig('/full/path/to/template.twig', options, (error, template) => {
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
  // The second argument is basically the same options object like above.
  // Most of the time you will be passing context data that will be available in the template.
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
Since Twig is a PHP library there is no (easy) way to make it extandable inside Node. Therefore you can specify multiple PHP files and a function that will act as an extension.
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

You can specify multiple files.  
Your PHP file could look like this:

```php
<?php

function myTwigExtension(\Twig_Environment &$twig) {
  $twig->addFunction('url', new \Twig_SimpleFunction('url', function ($context, $destination) {
    return 'something-fancy';
  }));
}
```
