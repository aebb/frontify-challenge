# Frontify Color API

Hello there! 👋

This task aims to show us where you stand as a developer, what your coding style is, and to have a basis for discussion.

For this purpose, create a simple and elegant RESTful API server for creating, reading, updating, and/or deleting 
operations on a Color entity. A Color should have a name and a HEX value. Pick one or more operations for a simple 
workflow to show how well and properly you engineer solutions, even for simple problems. Do it as well as you would 
expect for a code review by yourself. Work on top of the existing skeleton and Git history.

Keep in mind, we need a basis for discussion, not a fully-fledged enterprise solution. It's fine when features aren't 
implemented completely. Spend at most a few hours.

## Rules of the Game

- Don't use any further library or framework.
- You have to write the code — no code generators or assistants allowed (e.g., GitHub Copilot).
- Feel free to change existing code (or fix existing problems) as you see fit.
- Don't share the code publicly; just send it back to us.
- **Enjoy!**

## Skeleton Setup

**Requirements:** PHP 7.3+, node.js (optional, format the code manually if you don't use Prettier).

We use [http-server-request](https://github.com/sunrise-php/http-server-request) to abstract PHP's `$_SERVER`
and `$_REQUEST` superglobals, [Prettier for PHP](https://github.com/prettier/plugin-php) for code-formatting
and [PHPUnit](https://phpunit.de/) for testing:

```shell
npm i && php composer.phar install
```

Run PHP's built-in server available at [localhost:8080](http://localhost:8080):

```shell
npm start
```

Execute the PHPUnit tests via NPM shortcut:

```shell
npm test
```

### Technical Assessment

#### Tech Stack:
- Docker
- PHP 7.4
- MySQL

#### Install and Run:

```docker-compose up -d```

PHP Container access: ```docker exec -it task-frontify /bin/bash```

MySQL Container access: ```docker exec -it database-frontify /bin/bash```

##### Install dependencies

```composer update -vvv```

#### Solution:

##### Endpoints:

- [GET] - /colors/{id}

```
curl --location --request GET 'http://localhost/colors/1'  --header 'Content-Type: application/json'
```

- [DELETE] - /colors/{id}

```
curl --location --request DELETE 'http://localhost/colors/1' --header 'Content-Type: application/json'
```

- [POST] 
```
curl --location --request POST 'http://localhost/colors' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "color",
    "hexCode": "#ffffff"
}'
```

- PSR-12 Standard
- src/Controller/: Contains endpoints entry 
- src/Entity/: Entity models for the app
- src/Migrations/: Migrations for the databases
- src/Request/: Middleware classes to map requests into entities
- src/Service/: Logic for the entity operations
- src/Utils/: "Libraries" and utils
