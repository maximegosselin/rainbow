# Rainbow

[![Latest Version](https://img.shields.io/github/release/maximegosselin/rainbow.svg)](https://github.com/maximegosselin/rainbow/releases)
[![Build Status](https://img.shields.io/travis/maximegosselin/rainbow.svg)](https://travis-ci.org/maximegosselin/rainbow)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)


*Rainbow* is a general-purpose middleware stack.


## System Requirements

PHP 7.0 or later.


## Install

Install using [Composer](https://getcomposer.org/):

```
$ composer require maximegosselin/rainbow
```

*Rainbow* is registered under the `MaximeGosselin\Rainbow` namespace.


## Documentation

For an introduction to the middleware concept, [read this](http://www.slimframework.com/docs/concepts/middleware.html).

Declare middleware stack with core logic:
```php
$stack = new MiddlewareStack(function($in, $out) {
    // Core logic...
});
```

Push middleware to the stack:
```php 
$stack->push(function($in, $out, callable $next) {
    
    /* 'before' logic goes here... */
    
    $out = $next($in, $out);
    
    /* 'after' logic goes here... */
    
    return $out;
});
```

Call the stack with an inbound value and fetch the outbound value:
```php
$out = $stack->call('foo');
```



## Tests

Run the following command from the project folder.
```
$ vendor/bin/phpunit
```


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
