
### Demo PHP console application that scrapes the following website: https://wltest.dns-systems.net


## Tech stack used

- PHP >=7.4
- Composer
- DIDOM PHP Parser
- PHP Unit


## Installation

app requires [composer](https://getcomposer.org/download/) to run.

Install all the dependencies.

```sh
composer i
```
## Run
Use the following PHP CLI command to start and wait until the parsing process is done.

```sh
php run.php
```

Here we go, check a newly generated **products.json** file with JSON data

## Unit testing
Use the following PHP CLI command to run unit tests

```sh
php vendor/bin/phpunit Test/
```

**Good luck!**



