# DependencyInjection [![Build Status](https://travis-ci.org/cgTag/DependencyInjection.svg?branch=master)](https://travis-ci.org/cgTag/DependencyInjection)
An easy to use dependency injection library

## Background
cgTag DI is the dependency injector for PHP used to develop the cgTag.com website and cron services. It allows
me to design PHP classes without concerns of tight coupling between class usage and class implementation. It
uses a fluid interface for easier usage and supports automatic injection via reflection.

## Requirements
- PHP 7.1 or higher

# Usage
Here's some basic concepts to get you started. This DI library works by associating a `string` (the *symbol*) to another variable (the *dependency*). This
association is called the *binding*. There are different types of *bindings* such as; constants, singletons, lazy loading and reflection.

## License
MIT License

Refer to [LICENSE.txt](https://github.com/cgTag/DependencyInjection/blob/master/LICENSE.txt) for detailed information.
