# Domain Driven Design [ DDD ]
DDD is a package to support a DDD laravel application with custom artisan commands to generate different Domain Components, such as : Entity, Controller, Request, API Resource, CRUD,  etc.

### Installation

1- navigate to your project:
```sh
cd ./your-project
```


2- run composer command
```ssh
$ composer require MostafaHamed/laravel-guru-ddd
```
3- Run the following command

```sh
$ php artisan ddd:directory
```

4-  Update your .env file and run the following commands
```sh
$ php artisan migrate:fresh --seed
$ php artisan passport:install
```
5-  Add the following key/values inside .env file [ Password Grant Type ]
```sh
PASSPORT_CLIENT_ID=
PASSPORT_CLIENT_SECRET=
```
6- Update your `database/seeds/DatabaseSeeder.php` and user
```php
    $this->call(\App\Domain\User\Database\Seeds\UserTableSeeder::class);
```

# Usage
The package provide 2 commands:


```ssh
php artisan ddd:directory
```

```ssh
npm run watch
```
This command is used to change the current file-system to suit the DDD principle by create 4 directories inside the App file
1) Common:
- Commands
- Components
- Exceptions
- Helpers
- Http
    - Middelware
    - `Kernel.php`
    - Livewire
- Console
    - `kernel.php`
- Providers
- Resources
- Routes
- Traits
2) Domain : Holds the future-domains of the app
3) Infrastructure: 
- AbstractsProviders
- AbstractRepositories
- Commands
- Contracts
- Http
    - AbstractControllers
    - AbstractFactories
    - AbstractRequests
    - AbstractResources
- Scoping
- Traits

Moreover the command will modify the Kenel namespace in the `boostrap/app.php` + overwrite the service-providers' namespaces in `config/app.php`

**The command will also create a backup of the current project file-sytem


```ssh
php artisan ddd:make {type}
```
`{type}` can be :
- `Domain` [ file system + serviceProviders ]
- `Component` [ blade for laravel 7+ ]
- `Entity`  
- `Repo` 
- `Event`  
- `Listener` 
- `DatabaseView`
- `Resource`
- `Datatable`
- `Request`
- `Rule`
- `Migration`   
- `Factory`    
- `Seeder` 
- `Graphql` 
- `Notification`
- `Controller`
- `Test`
- `Crud` [ creates : Entity + DatabaseView + Migration + Factory + Seeder + Views + Datatable + Request + Repo + Resource + Controllers ]
- `Backup`
- `Magic` [clear cache]

Please note that there are options that may be required in order to create any component and you will be asked throwghout the creation process. Therefore you can run the command above without specify any additional options.
