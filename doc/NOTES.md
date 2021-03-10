# Solution Procces:

## First Thoughts:

In the first approach my plan will have the following steps:

1. I am going to set up a docker environment with two nginx server, each one with the required compatible php versions and phpunit
1. The first analysis of the code shows that we have dead code. The right thing to do is delete it, to not make more complex 
the code and the process. Obviously the deletion of code always have more analysis than a simple single file class but if it was a core code 
I'll take the precaution of make a TAG or commit in the delete step to recover the code if it will be necessary.
1. The next step is to make unit test to our business logic and then start refactoring to adapt from php5 to php7 and improve the code, because we have
smells codes, some are pretty clear but all of them showed by our IDE(phpstorm). At first sight we are not going to have serious incompatibilities with the php version
1. The last step is to set up a symfony application and structure the code with a good architecture and good practices.
1. improve documentation 


### Step 1

I suffer a docker update so takes me more time.

I setup two environments to enable run:

    $ docker-compose --project-name php7 -f dev-docker-composer-php7.yml up
 
    $ docker-compose --project-name php5 -f dev-docker-composer-php5.yml up

To not employ more time in configuration I used my own docker images when it was possible, and I only put composer in one image

## Step 2

We only have 2 native functions dependency in our code: getdate() and floor() ( the old fashion constructor was deleted because it was unnecessary)
so we shouldn't have problems migrating.

To ensure I review 

* [change log from php5.0 to php7.0](https://www.php.net/manual/en/migration70.php)
* [change log from php7.0 to php7.1](https://www.php.net/manual/en/migration71.php)
* [change log from php7.1 to php7.2](https://www.php.net/manual/en/migration72.php)
* [change log from php7.2 to php7.3](https://www.php.net/manual/en/migration73.php)
* [change log from php7.3 to php7.3](https://www.php.net/manual/en/migration74.php)

in index.php we have a bug because REQUEST_URI will return a relative route from server name starting with '/', so the endpoints are not reachable
I made a quick fix to prove it, It is not problematic because we are migrating to symfony, and we'll develop a new controller


