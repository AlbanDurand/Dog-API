## About the API
The requested features are stored in the `./app/Application` directory.

The implemented repositories are stored in the `./app/Infrastructure` directory. Those implementations actually use Eloquent models under the hood.

The business logic is in the `./app/Domain` directory.

## Start the API

### Setting up
```shell
composer install
cp .env.example .env
php artisan sail:install
php artisan key:generate
./vendor/bin/sail up
php artisan migrate
```

In the `.env` file, set `SESSION_DRIVER` to `cookie`

To run tests: `./vendor/bin/sail test`

## Endpoints
| Title                          | Method | URL                                        |
|--------------------------------|--------|--------------------------------------------|
| List all users                 | GET    | <http://localhost/users>                   |
| List all parks                 | GET    | <http://localhost/parks>                   |
| List all breeds                | GET    | <http://localhost/breed>                   |
| Show one breed                 | GET    | <http://localhost/breed/{breedId}>         |
| Show random breed              | GET    | <http://localhost/breed/random>            |
| Show breed image               | GET    | <http://localhost/breed/{breedId}/image>   |
| Associate park/breed with user | POST   | <http://localhost/user/{userId}/associate> |
| Associate breed with park      | POST   | <http://localhost/park/{parkId}/breed>     |



## Manipulating data

### Creating users and parks
```shell
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ParkSeeder
```

### Associating a park to a user
```shell
curl -X POST http://localhost/user/{userId}/associate \
    -H "Content-Type: application/json" \
    -d '{ "relatedModelType": "park", "relatedModelId": "{parkId}" }'
```

### Associating a breed to a user
```shell
curl -X POST http://localhost/user/{userId}/associate \
    -H "Content-Type: application/json" \
    -d '{ "relatedModelType": "breed", "relatedModelId": "{breedId}" }'
```

### Associating a breed to a park
```shell
curl -X POST http://localhost/park/{parkId}/breed \
    -H "Content-Type: application/json" \
    -d '{ "breedId": "{breedId}" }'
```

## Communicating with the Dog API
Everytime a breed must be returned by this API, it first get the data from the external API provider. To prevent the rate limitation, that synchronisation can only be made at least **30 minutes** after the last one.

## Todo
With more time, many things could be added:
- data validation
- schema validation of the external API provider response
- better handling of errors, at the moment only not found entities (`breed`, `user`, `park`)) result in a **404** response
- mapper classes 
- set some variables in a config file, for example at the moment the synchronisation delay with the external API and its base URL are hardcoded in the `./app/Providers/BreedServiceProvider.php` file
- scheduled task to regularly synchronise data with the external API
- more tests
