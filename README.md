# twitterInterview

Return​ a ​JSON-encoded​ ​array​ containing​ ​"hour​ ​->​ ​tweet​ ​counts" for​ a given​ ​user,
​ ​to​ ​determine​ what​ ​hour​ of​ ​the​ ​day​ ​they​ ​are​ ​most​ ​active.

### Installation

You need install first composer [Composer](https://getcomposer.org/download/)

Install the dependencies and devDependencies and start the server.

```sh
$ git clone git@github.com:czester90/twitterInterview.git
$ composer install
$ php -S localhost:8080 -t public index.php
```

Go to for example to page [http://localhost:8080/histogram/cnnbrk](http://localhost:8080/histogram/cnnbrk)

You should see json data about number tweets in current day 

### Run Unit Tests

Go to the folder with the application and follow

```sh
$ ./vendor/bin/phpunit
```