## Start the API

```shell
cp .env.example .env
php artisan sail:install
php artisan key:generate
./vendor/bin/sail up
```

In the `.env` file, set `SESSION_DRIVER` to `cookie`

To run tests: `./vendor/bin/sail test`

## About the API
The requested features are stored in the `./app/Application` directory.

The implemented repositories are stored in the `./app/Infrastructure` directory. Those implementations actually use Eloquent models under the hood.

The business logic is in the `./app/Domain` directory.

## Communicating with the Dog API
Everytime a breed must be returned by this API, it first get the data from the external API provider. To prevent the rate limitation, that synchronisation can only be made at least **30 minutes** after the last one.

## Todo
With more time, many things could be added:
- data validation
- schema validation of the external API provider response
- better handling of errors, at the moment only not found entities (`breed`, `user`, `park`)) result in a **404** response
- mapper classes 
- set some variables in a config file, for example at the moment the synchronisation delay with the external API and its base URL are hardcoded in the `./app/Providers/BreedServiceProvider.php` file
