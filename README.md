# symfonyRestAPI
symfony Rest Api is a rest service to handle the CRUD for the Products, 
Discounts, Product Groups and Orders, 
The Data base Schema is very basic, And can be further enhanced and modified,
Its Just a symfony Practice. 
There is no Visual interfaces, Its Just an API calls and the response
is a Json Objects. Which can be further enhanced and modified

To run the Project 

First Clone the project 

```$xslt
git clone git@github.com:amjadkhan896/symfonyRestAPI.git
```
Then second step is 

```$xslt
cd symfonyRestApi
```

Then

```$xslt
composer install
```

Then if you want to generate the data base with 0 entries

```$xslt
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force

```

Or if you want the database, I already put the database backup file. 
import it into mysql

The last step to run the project is 

```$xslt
php bin/console server:run
```

To check the route end points

You can run the command to see the routes and their parameters

```$xslt
php bin/console debug:router

```

I have added all the api routes in routes-plus-params.txt and their inputs.
So that if you use Postman or any other software. to check the response.
The Params i speciefied or in the form of Json. So you will select 

```$xslt
BODY->RAW->JSON
```