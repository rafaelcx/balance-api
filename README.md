# Balance API

A simple balance API written in PHP, designed to test the capabilities of the PHP Slim Framework.

---

## Provisioning using Docker

Ensure you have Docker and Docker Compose installed on your local machine. Then, run the following command:

```
docker compose up --build
```

This will build the container and start a PHP built-in web server, which will be accessible at:
[http://localhost:8000/](http://localhost:8000/)

## Tests

To run the PHPUnit tests for the app, follow these steps:

### Start a bash session in the Docker container:

Open a terminal and execute the following command to start a bash session inside the balance-api container:

```
docker compose run --rm balance-api /bin/bash
```

This will open a bash shell inside the container where the application and its dependencies are set up.

### Run PHPUnit tests:

Once inside the container, execute the following command to run the PHPUnit tests:

```
./vendor/bin/phpunit test
```

This will run all the tests located in the `test` directory and display the results in the terminal.
