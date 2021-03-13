# Solution Process:

## First Thoughts:

In the first approach my plan will have the following steps:

1. I am going to set up a docker environment with two Nginx server, each one with the required compatible PHP versions and PHPUnit
1. The first analysis of the code shows that we have dead code. The right thing to do is delete it, to not make more complex the code and the process. Obviously, the deletion of code always have more analysis than a simple single file class but if it was a core code
   I'll take the precaution of making a TAG or commit in the delete step to recover the code if it will be necessary.
1. The next step is to make a unit test to our business logic and then start refactoring to adapt from php5 to php7 and improve the code because we have
   smells codes, some are pretty clear but all of them showed by our IDE(PhpStorm). At first sight we are not going to have serious incompatibilities with the PHP version
1. The last step is to set up a Symfony application and structure the code with good architecture and good practices.
1. improve documentation


### Step 1

I suffer a docker update so takes me more time.

I set up two environments to enable run:

    $ docker-compose --project-name php7 -f dev-docker-composer-php7.yml up
 
    $ docker-compose --project-name php5 -f dev-docker-composer-php5.yml up

To not employ more time in the configuration I used my own docker images when it was possible, and I only put composer in one image

## Step 2

We only have 2 native PHP functions dependency in our code: getdate() and floor() ( the old fashion constructor was deleted because it was unnecessary)
so we shouldn't have problems migrating.

To ensure I review

* [change log from php5.0 to php7.0](https://www.php.net/manual/en/migration70.php)
* [change log from php7.0 to php7.1](https://www.php.net/manual/en/migration71.php)
* [change log from php7.1 to php7.2](https://www.php.net/manual/en/migration72.php)
* [change log from php7.2 to php7.3](https://www.php.net/manual/en/migration73.php)
* [change log from php7.3 to php7.3](https://www.php.net/manual/en/migration74.php)

in index.php we have a bug because REQUEST_URI will return a relative route from server name starting with '/', so the endpoints are not reachable
I made a quick fix to prove it, It is not problematic because we are migrating to Symfony, and we'll develop a new controller

> Because of the update in the system I spent more time, so it's late, and I'll do it tomorrow the remaining work

## Step 3

### Step 3.1
I will make the test to proceed to refactor the code and then, with the code ensured and clean migrate to Symfony framework
without uncontrolled risks.

The analysis of the code shows us that we have two functions:
* return the current day in a specific format
* a function that seems to return a price incremented by 20% whatever taxes you introduce it will be changed to 20% by parameter

the first function its clear, but the second I'll need to reduce de unnecessary temporary variables to understand better the desired functionality,
so I'll make a test to keep the current result. The endpoint always returns the same values because the price and tax are
hardcoded, so while I don't affect the client we'll be right.

### Step 3.2
With the test, I determine that the desired requirement of VAT are: calculate the full price with 20% taxes and return taxes charged
This code doesn't work properly on negative numbers or in the upper limits, so I am going to fix the behaviour.

I am not agreed with the interface of the function or the behaviour but I'm going to fix it and from then we could change the code.

### Step 3.3
The code passes all the test, we are going to refactor the code.

    Brake to dinner from 21 to 22

### Step 3.4

Refactor today function

## Step 4

install Symfony and configure it

I realise that the version installed, Symfony 5 it is not compatible with php5 but, if the premise is to migrate to Symfony,
and the minimum version that accepts that PHP version is not supported any more (3.4) I don't consider it a good solution.
is heavier, have unnecessary dependencies and have abandoned packages. It was a mistake, and I have no time to fix it. I proved with the tests that the core code is compatible with php5


## Step 4.1 

Taking advantage of my mistake I will migrate the code to the new php74 styles.

## Step 5

Make a documentation to set up the environment 

SETUP Dockers

    docker-compose --project-name php7 -f dev-docker-composer-php7.yml up

List all the containers in the image

    docker ps 

Access to php service to execute tests

    docker exec -it php7_php-<NAME> /bin/sh

Execute test
```
/var/www/app # php vendor/phpunit/phpunit/phpunit --testdox
PHPUnit 9.5.2 by Sebastian Bergmann and contributors.

Warning:       Your XML configuration validates against a deprecated schema.
Suggestion:    Migrate your XML configuration using "--migrate-configuration"!

Main Finance (App\Tests\MainFinance)
 ✔ Today
 ✔ V a t

Time: 00:00.414, Memory: 8.00 MB

OK (2 tests, 21 assertions)
/var/www/app #
```


# Last Steps and discussions


We could see the time employed in the project without this part:

![logo](ProjectTime.PNG) "Image 1. Reference: [wakatime](https://wakatime.com/@enrikerf)"

I would like to develop a hexagonal architecture. Of course, it has no sense in such a code and will be against pragmatism, but I'll do it for the pleasure of the academic purpose.

I develop the architecture in full detail to show the structure, in this size of code the interfaces are useless and only 
made verbose the code. The core concept is to be pragmatic and choose between the full implementation of the book concept 
and our necessities. In this case, We could inject the services directly and if we need an interface in the future implement it.

> With all implemented, I will change the core interface of the vat function to return only the vat given base price and
remove the by reference parameter.

We could develop a view concept to don't get constant in the controller and separate responsibilities

Another point to discuss is the division in services per use case, we could make less verbose the code by joining the services and separate it by interfaces or even injecting a unique service with all the use cases. but if something is wrong all endpoints will fail.

As we can see in Image 2. between the full implementation and the traditional MVC architecture we have multiple choices
I usually choose not to implement use cases interfaces, because only one class implement and we could remember the phrase:
"the better moment to implement an interface is when you need it"

The second possible shortcut is to implement a unique Response model with a response code and response content and the controller
will have the responsibility to process it.

The third possible shortcut is to inject directly the Repository and don't have interfaces.


![hexagonal](hexagonalCost.png) "Image 2. Hexagonal architecture cost"