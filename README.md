# DependencyInjection [![Build Status](https://travis-ci.org/cgTag/DependencyInjection.svg?branch=master)](https://travis-ci.org/cgTag/DependencyInjection)
An easy to use dependency injection library

## Background
cgTag DI is the dependency injector for PHP used to develop the cgTag.com website and cron services. It allows
me to design PHP classes without concerns of tight coupling between class usage and class implementation. It
uses a fluid interface for easier usage and supports automatic injection via reflection.

## Why Another DI Library?

This is my forth DI library written from scratch. I've written ones for C#, JavaScript and TypeScript in the past and wanted to continue with
a pattern that I was familiar with. There are other libraries for PHP such as [PHP-DI](http://php-di.org/) and [Nette DI](https://github.com/nette/di)
that offer their own approaches, but my goal is seamless DI without much effort from the programmer.

## Requirements
- PHP 7.1 or higher

## License
MIT License

Refer to [LICENSE.txt](https://github.com/cgTag/DependencyInjection/blob/master/LICENSE.txt) for detailed information.
