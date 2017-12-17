Dispather emulation
===================

Emulation of mass mailing according to some criteria.

Project uses docker, docker-compose and rabbitMQ.

# Installation

Ensure you have docker and docker-compose installed.

After project cloning go to docker directory and execute

```bash
$ docker-compose up -d dispatch
$ docker-compose run dispatch composer install
```

# Automated tests

```bash
$ docker-compose run dispatch vendor/bin/codecept build
$ docker-compose run dispatch vendor/bin/codecept run unit
```

# Test run

Ensure you have run tests before. Than execute

```bash
$ docker-compose run dispatch php index.php
```

Also you can run worker itself

```bash
$ docker-compose run dispatch php worker.php
```

