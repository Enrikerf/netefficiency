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

To not employ more time in configuration I used my own docker images when it was possible and I only put composer in one image
