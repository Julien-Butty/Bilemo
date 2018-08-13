Bilemo
======



Bilemo is an API providing an updated database on the latest mobile devices.
You could also manage your customers list.




Installation
------------

- Clone this repository: https://github.com/Julien-Butty/Bilemo.git
- In your command line type these lines:

`````
composer install
`````

Configure your database in .env file, return in your command line and type this:
`````
bin/console doctrine:database:create
bin/console doctrine:fixtures:load
`````

Documentation
-------------

Check the documentation to know all possibilities of our API. You can access it with this URL:
``````
{your_domain}/api/doc
``````

