# DependencyInjection [![Build Status](https://travis-ci.org/cgTag/DependencyInjection.svg?branch=master)](https://travis-ci.org/cgTag/DependencyInjection)
An easy to use dependency injection library

## Background
cgTag DI is the dependency injector for PHP used to develop the cgTag.com website and cron services. It allows
me to design PHP classes without concerns of tight coupling between class usage and class implementation. It
uses a fluid interface for easier usage and supports automatic injection via reflection.

## Requirements
- PHP 7.1 or higher

*Write your code so it's flexible and injection can be automatic*
```
class DebugLogger implements ILogger {
    
}

class Service {
    public $log;
    public function __constructor(ILogger $log) 
    {
        $this->log = $log;
    }
}
```

*...and let Ninject glue it together for you.*
```
public class AppModule extends DIModule
{
    public function load(IDIContainer $con) 
    {
        $this->bind(ILogger::class)->toClass(DebugLogger::class)->asSingleton();
    }
}
```

## License
MIT License

Refer to [LICENSE.txt](https://github.com/cgTag/DependencyInjection/blob/master/LICENSE.txt) for detailed information.
