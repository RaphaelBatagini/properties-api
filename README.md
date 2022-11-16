![Test status](https://github.com/RaphaelBatagini/eng-companytwo-challenge-php/workflows/PHP%20Composer/badge.svg)

# Properties API

API to split a list of properties between two Real State Companies (CompanyOne and Company Two) following some rules.

## Project Description

## Tech Stack
- PHP 7.2
- PHPUnit 8
- Docker
- Docker Compose

### Packages
Due to its simplicity, this project was created without using a PHP framework.
Instead, only a few packages were used for specific needs:

- Coffeecode Router
- PHPDotEnv

## Application setup and execution

### Executing the application
Copy content of file **.env.example** into a new file **.env**.

Execute the following command in the project root directory:
```
$ docker-compose up -d
```

The installation of the dependencies is done when docker is initialized. Therefore, there is no need to do this procedure manually.

### Executing unit tests
To execute the unit tests, with the containers running, just use the following command:
```
$ docker-compose run tests
```

### Interacting with composer
To execute any action in the composer, use the following command pattern:
```
$ docker run --rm --interactive --tty \
  --volume $PWD:/app \
  composer <command>
```

## API Endpoints
List properties of each company:
```
/properties/portal/{companytwo|companyone}/{pagenumber}
```

List all properties:
```
/properties/{pagenumber}
```

## Specificities
- At the first time the json at REMOTE_FILE_PATH is consulted, a copy of its content will be stored in the application. In the nexts properties consults, the application will use the local copy instead of the remote one aiming for better performance.

## Improvements to be done:
- Use Chain of Responsabilities design pattern to define wich collection should be loaded in the getPropertiesCollection method;
- Check the request eTag for the remote file to define if the local version should be updated.