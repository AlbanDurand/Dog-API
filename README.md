## About the API

The app is divided in 3 main parts.

### Domain (`./app/Domain`)
All the business logic is there. It allows to centralize all entities and interactions between them in one place without polluting the rest of the app.

### Infrastructure (`./app/Infrastructure`)
Components interacting with services external to the application can be found here. In the context of this app, we have:
- the repositories communicating with the MySQL database
- a class (`./app/Infrastructure/BreedExternalProvider/BreedApiProvider.php`) responsible for fetching data from the external API provider 

### Application (`./app/Application`)
The implemented features of the API are there.

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

## Tests
Enter the following command to run automated tests: `./vendor/bin/sail test`

All tests are stored in the `./tests` directory.


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
# Don't forget to replace {userId} and {parkId} with real values
curl -X POST http://localhost/user/{userId}/associate \
    -H "Content-Type: application/json" \
    -d '{ "relatedModelType": "park", "relatedModelId": "{parkId}" }'
```

### Associating a breed to a user
```shell
# Don't forget to replace {userId} and {breedId} with real values
curl -X POST http://localhost/user/{userId}/associate \
    -H "Content-Type: application/json" \
    -d '{ "relatedModelType": "breed", "relatedModelId": "{breedId}" }'
```

### Associating a breed to a park
```shell
# Don't forget to replace {parkId} and {breedId} with real values
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
