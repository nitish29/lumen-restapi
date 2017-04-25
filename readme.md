RESTful API Demo
===================
This repository contains the code for a **RESTful API** built on top of Lumen framework. The API interacts with a **User** resource using different REST endpoints. For every query made, the API returns a JSON response.

----------

Installation steps and Setup
------------

For developing this API, I used **Laravel Homestead** to setup my local enviornment. It's a pre-packaged Vagrant box, that already has PHP, a web server and a database (among other softwares) installed so that you don't have worry about installing and configuring them before you start coding. Additionally, I have shared a **Vagrantfile**, which replicates my working environment for you.

- Clone this repo.
- Install [Vagrant] and [Virtual Box].
- Install [Composer]. Make sure you put Composer PHAR in your ```PATH```, this allows composer to be accessed globally.
- Install the required dependencies for the API by runiing composer install command. 
    ```sh
    $ cd <path_to_cloned_github_repo>
    $ composer install
    ```
- Add an entry to the `hosts` file on your machine. You must add a domain to serve the API requests. The hosts file will redirect requests for your Homestead sites into your Homestead machine. On Mac and Linux, this file is located at `/etc/hosts`. On Windows, it is located at `C:\Windows\System32\drivers\etc\hosts`. The lines you add to this file will look like the following:
  ```sh
    192.168.10.10  restapi.app
    ```
- Copy the contents of the `.env.example` file,which is in the project root directory,and paste it into a new file. Rename the file to `.env`. 
- Run this command, to provision your virtual machine.
    ```sh
    $ vagrant up
    ```
    > **Note:** You might have to configure the `Homestead.yaml` file. The file is located inside project root. You'll have to configure the `folders` and `site` properties in this file, by changing the `map` and `to` attributes for both. And then run `vagrant up` command again. Refer this link on how to change the properties: https://laravel.com/docs/5.4/homestead#per-project-installation
- Type `restapi.app` in your browser, this should load a page, which mentions the Lumen version. Something like this `Lumen (5.4.6) (Laravel Components 5.4.*)`.
- Finally, Migrate the database schema and insert(seed) dummy values into it. 
    ```sh
        $ vagrant ssh // enter this command to log into to your virtual machine
        //change directory into project root directory on VM, then run the follwoing commands
        $ php artisan migrate
        $ php artisan db:seed --class=UsersTableSeeder
    ```
----
REST API End-points description
------------

I have exposed a total of 15 end-points. These end points allow searching data pertaining to users based on first name, last name, age, and gender. I thought about making a single controller action that parses input request parameters, however, after reading few articles on best REST practices, I found out that there is `no hard-and-fast rule` on how many end points you should expose. Therefore, I decided to make `dedicated end-points`, based on `different combinations` of request parameters provided. 
- This allowed me to handle the queries at a more granular level, thereby enabling me to provide dedicated end-points to `serve these requests individually`. 
- Furthermore, if any refactoring was required(for any particular end-point) this ensured that the appropriate controller action was changed `without breaking the rest of the implementation`. 

**Request Parameters:**

| Request Parameter | Type | Format |
|---------|----------------|--------|
| lastname | String(varchar)      | Only accepts alphabetic characters [A-Za-z]
| firstname| String(varchar) | Only accepts alphabetic characters [A-Za-z]
| age| Number(int) | Only accepts digits [0-9]
| gender| String(Enum) | Only accepts alphabetic characters [A-Za-z], values `male` or `female`
----
**Route List:**
> **Note:** All request params(enclosed inside curly braces) in the URI column are required. 

| Method     | URI                               | Action                                                  |
|------------|-----------------------------------|---------------------------------------------------------|
| `GET` | `/api/v1/users/lastName/{last_name}/firstName/{first_name}/gender/{gender}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByAllAttributes`         |
| `GET` | `/api/v1/users/lastName/{last_name}`                           | `App\Http\Controllers\UsersController@searchUserByLastName`         |
| `GET` | `/api/v1/users/lastName/{last_name}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByLastNameAndAge`         |
| `GET` | `/api/v1/users/lastName/{last_name}/gender/{gender}`                           | `App\Http\Controllers\UsersController@searchUserByLastNameAndGender`         |
| `GET` | `/api/v1/users/lastName/{last_name}/gender/{gender}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByLastNameGenderAndAge`         |
| `GET` | `/api/v1/users/firstName/{first_name}`                           | `App\Http\Controllers\UsersController@searchUserByFirstName`         |
| `GET` | `/api/v1/users/firstName/{first_name}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByFirstNameAndAge`         |
| `GET` | `/api/v1/users/firstName/{first_name}/gender/{gender}`                           | `App\Http\Controllers\UsersController@searchUsersearchUserByFirstNameAndGender`         |
| `GET` | `/api/v1/users/firstName/{first_name}/gender/{gender}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByFirstNameGenderAndAge`         |
| `GET` | `/api/v1/users/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByAge`         |
| `GET` | `/api/v1/users/gender/{gender}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByGenderAndAge`         |
| `GET` | `/api/v1/users/gender/{gender}`                           | `App\Http\Controllers\UsersController@searchUserByGender`         |
| `GET` | `/api/v1/users/lastName/{last_name}/firstName/{first_name}`                           | `App\Http\Controllers\UsersController@searchUserByLastNameAndFirstName`         |
| `GET` | `/api/v1/users/lastName/{last_name}/firstName/{first_name}/gender/{gender}`                           | `App\Http\Controllers\UsersController@searchUserByLastNameFirstNameAndGender`         |
| `GET` | `/api/v1/users/lastName/{last_name}/firstName/{first_name}/age/{age}`                           | `App\Http\Controllers\UsersController@searchUserByLastNameFirstNameAndAge`         |

Design Considerations and Obeservations:
----

In my quest to make the API response times faster, I tried various different approaches just to see the impact all of them would have on the API response time. I tried retrieving records using Eloquent, Query Builder and Raw SQL. 

> **Note:** I used `Faker` to seed `10K records` and `1M records`.

**API response times:**

- Without adding indexes to columns:
    > **Note:** Queries made had all the attributes specified. => `searchUserByAllAttributes`
  - For fetching a `single record` from a total of 10,000 records `(DB size - 0.5 MB)`
 
    | Database Interaction Using | Response Time |
    |---------|--------|
    | Eloquent ORM | Total Response Time: `143 ms`, Query Execution Time: `6.87 ms`
    | Frequent Query Builder | Total Response Time: `87 ms`, Query Execution Time: `5.38 ms`
    | Raw SQL | Total Response Time: `85 ms`, Query Execution Time: `5.32 ms` 

  - For fetching `all records` from a total of 10,000 records `(DB size - 0.5 MB)`
  
    | Database Interaction Using | Response Time |
    |---------|--------|
    | Eloquent ORM | Total Response Time: `486 ms`, Query Execution Time: `14.77 ms`
    | Frequent Query Builder | Total Response Time: `140 ms`, Query Execution Time: `14.73 ms`
    | Raw SQL | Total Response Time: `90 ms`, Query Execution Time: `13.58 ms` 

- I then added indexes to all the column attributes, to check whether it would have any effect on response times.

- After adding indexes to columns:
  - For fetching a `single record` from a total of 10,000 records `(DB size - 0.5 MB)`
  
    | Database Interaction Using | Response Time |
    |---------|--------|
    | Eloquent ORM | Total Response Time: `86 ms`, Query Execution Time: `3.08 ms`
    | Frequent Query Builder | Total Response Time: `85 ms`, Query Execution Time: `4.18 ms`
    | Raw SQL | Total Response Time: `82 ms`, Query Execution Time: `3.15 ms` 

  - For fetching `all records` from a total of 10,000 records `(DB size - 0.5 MB)`
  
    | Database Interaction Using | Response Time |
    |---------|--------|
    | Eloquent ORM | Total Response Time: `797 ms`, Query Execution Time: `14.98 ms`
    | Frequent Query Builder | Total Response Time: `470 ms`, Query Execution Time: `13.33 ms`
    | Raw SQL | Total Response Time: `459 ms`, Query Execution Time: `16.27 ms` 

  - I then tried fetching records against `1M records` just to see the effect on response time. `(DB size - 134.8 MB)`
 
      > **Note:** Queries made were used to retrieve records only by age. => `searchUserByAge`. Just for kicks, I tried searching by all attributes, however, the PHP processor ran out of memory. 

    | Database Interaction Using | Response Time |
    |----------------------------|---------------|
    | Eloquent ORM | Total Response Time: `1797 ms`|
    | Frequent Query Builder | Total Response Time: `470 ms`|
    | Raw SQL | Total Response Time: `501 ms` |

- After running all these queries, these are the learnings that I had:
    - Adding indexes to columns made response time faster.    
    - Eloquent ORM is faster for inserts, but is slow when compared to Query Builder or Raw SQL.
    - For a DB containing `10,000 records`, Raw SQL is faster when compared to Query Builder or Eloquent.
    - For a DB containing `1M records`, Raw SQL & Query Builder significantly outperform Eloquent.
    - After this point, I decided either to move forward with either Raw SQL or Query Builder, as their response time was less.
    - To cut down even more on response time & to ensure that the API is scalable even when handling millions of records I decided to use pagination. 
    - Pagination worked out of the box with Query Builder and for it to work with Raw SQL, I would have to implement a manual paginator. Converting Raw SQL into an object format that Pagination supports would invariably lead to an increase in response time. Using Raw SQL with Manual paginator would mean that the response time would be similar to Query Builder. 
    - Therfore, I finally decided to move forward with Query Builder, with pagination enabled.
> **Final Observation:** For all the end-points, using Query Builder with pagination ensured that the response time was under 1 second. 


Addtional Thoughts/Caveats
----
- While adding indexes makes response time faster, adding indexes to all/some columns might not be a good idea when there are many columns.
- I also thought about caching results using redis along with pagination, but since our implementation only deals with fetching(GET requests) information at the moment, pagination seemeed to serve our needs well(i.e keeping response time under 1 second). Moreover, even though space is cheap, overhead of maintaining data at two places seemed overkill considering the scope of this API.

FUTURE - API Version 2 Considerations
------------
- Depending on the functional requirement of the API, we can add the following methods/end-points in the second version of our API:
    
    These end-points would basically extend support for **Filtering.**
    
    | Request Type | URI | Desciption |
    |--------------|-----|------------|
    | GET | /api/v2/users/filter/less/age/{age}  | Retrieve Users less than a particular age
    | GET | /api/v2/users/filter/greater/age/{age}  | Retrieve Users greater than a particular age
    | GET | /api/v2/users/filter/range/age/{age}  | Retrieve Users within a particular age range
    

- Filtering can be combined with other attributes like `last_name`, `first_name` etc to expose more end-points and to achieve even more fine grained filtering.

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

   [git-repo-url]: <https://github.com/joemccann/dillinger.git>
   [Composer]: <https://getcomposer.org/download/>
   [Vagrant]: <https://www.vagrantup.com/downloads.html>
   [Virtual Box]: <https://www.virtualbox.org/wiki/Downloads>

