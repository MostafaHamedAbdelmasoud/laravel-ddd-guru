<?php


return [
    'path'          => env('DOMAIN_PATH', 'Domain'),
    'migrations'    => true,
    'factories'     => true,
    'observers'     => true,
    'views'         => true,
    'translations'  => true,
    'commands'      => true,
    'layout'        => ['lte', [
        'compacted' => true
    ],],
    'structure' => [
        "base" => [
            "Common" => [
                "Commands" => [],
                "Exceptions" => [
                    "Handler.php"
                ],
                "Helpers" => [
                    "UploadHelper.php",
                    "Enums.php",
                    "Lang.php",
                    "Main.php",
                    "QueryHelpers.php"
                ],
                "Http" => [
                    "Middleware" => [
                        "Admin.php",
                        "Authenticate.php",
                        "CheckForMaintenanceMode.php",
                        "Cors.php",
                        "EncryptCookies.php",
                        "LangMiddleware.php",
                        "RedirectIfAuthenticated.php",
                        "TrimStrings.php",
                        "TrustProxies.php",
                        "VerifyCsrfToken.php"
                    ],
                    "Kernel.php"
                ],
                "Console" => [
                    "Kernel.php"
                ],
                "Providers" => [
                    "DomainServiceProvider.php",
                    "EventServiceProvider.php",
                    "HelperServiceProvider.php",
                    "PolicyServiceProvider.php",
                    "RepositoryServiceProvider.php",
                ],
            ],
            "Domain" => [],
            "Infrastructure" => [

                "Contracts" => [
                    "BaseRepository.php",
                    "Scope.php"
                ],
                "AbstractModels" => [
                    'BaseModel.php',
                ],
                "AbstractRepositories" => [
                    "EloquentRepository.php",
                ],

                "AbstractProviders" => [
                    "ServiceProvider.php"
                ],

                "Http" => [
                    "AbstractResources" => [
                        'BaseResource.php',
                        'BaseCollection.php'
                    ],
                    "AbstractRequests" => [
                        'BaseRequest.php'
                    ],
                    "AbstractControllers" => [
                        'BaseController.php'
                    ],
                    "AbstractFactories" => [
                        "ModelFactory.php",
                    ],
                ],

                "Commands" => [
                    "AbstractCommand" => [
                        'BaseCommand.php'
                    ],
                ],

                "Scoping" => [
                    "Scoper.php"
                ],

                "Traits" => [
                    "BuilderParameters.php",
                    "SpatieQueryBuilder.php",
                    "WorkFlow.php",
                    "CanBeScoped.php"
                ],
            ]
        ],
        'domain' => [
            //'DataTables',
            // 'Database' => [
            //     'Factories',
            //     'Migrations',
            //     'Seeds'
            // ],
            // 'Tests'=>[
            //     'Feature',
            //     'Unit'
            // ],
            // 'Entities' => [
            //     'Views',
            //     'Traits'=>[
            //         'CustomAttributes',
            //         'Relations',
            //     ],
            // ],
            // 'Events',
            // 'Http' => [
            //     'Controllers',
            //     'Requests',
            //     'Resources',
            //     'Rules',
            // ],
            //"Commands",
            "Traits",
            "Contracts",
            // 'Graphql'=>[
            //     "Queries",
            //     "Mutations",
            //     "Subscriptions",
            //     "Interfaces",
            //     "Inputs",
            //     "Unions",
            //     "Scalars",
            //     "Types",
            //     "Directives",
            // ],
            //'Listeners',
            //'Notifications',
            'Providers',
            // 'Repositories' => [
            //     'Contracts',
            //     'Eloquent',
            // ],
            // 'Resources' => [
            //     'Lang',
            //     'Views'
            // ],
            'Routes' => [
                'api',
                'web'
            ],
        ],
    ],
    "stubs" => [
        "test_stub" => 'test_stub.stub',
        "config-app" => "Config/app.stub",
        "config-fortify" => "Config/app.stub",
        "config-auth" => "Config/auth.stub",
        "config-cors" => "Config/cors.stub",
        "config-lighthouse" => "Config/lighthouse.stub",
        "event" => "Domain/Events/event.stub",
        "job" => "Domain/Jobs/job.stub",
        "command" => "Domain/Commands/command.stub",
        "livewire" => "Common/Http/Livewire/livewire.stub",
        "middleware" => "Common/Http/Middleware/middleware.stub",
        "common_command" => "Common/Commands/command.stub",
        "common_scope" => "Common/Scopes/scope.stub",
        "common_event" => "Common/Events/event.stub",
        "common_notification" => "Common/Notifications/notification.stub",
        "common_listener" => "Common/Listeners/listener.stub",
        "common_mail" => "Common/Mails/mail.stub",
        "scope" => "Domain/Entities/Scopes/scope.stub",
        "observer" => "Domain/Observers/observer.stub",
        "policy" => "Domain/Policies/policy.stub",
        "mail" => "Domain/Mail/mail.stub",
        "criteria" => "Domain/Criteria/criteria.stub",
        "listener" => "Domain/Listeners/listener.stub",
        "notification" => "Domain/Notifications/notification.stub",
        "rule" => "Domain/Http/Rules/rule.stub",
        "eloquent" => "Domain/Repositories/Eloquent/eloquent.stub",
        "contract" => "Domain/Repositories/Contracts/contract.stub",
        "controller" => "Domain/Http/Controllers/controller.stub",
        "controller-sac" => "Domain/Http/Controllers/SAC/controller.stub",
        "controller-api-resource" => "Domain/Http/Controllers/Api/V1/controller.stub",
        "controller-api-sac" => "Domain/Http/Controllers/Api/V1/SAC/controller.stub",
        "request-store" => "Domain/Http/Requests/Entity/store.stub",
        "request-update" => "Domain/Http/Requests/Entity/update.stub",
        "service" => "Domain/Services/service.stub",
        "resource" => "Domain/Http/Resources/resource.stub",
        "resource_collection" => "Domain/Http/Resources/collection.stub",
        'database-view' => 'Domain/Entities/Views/database_view.stub',
        'datatable' => 'Domain/Datatables/datatable.stub',
        'entity' => 'Domain/Entities/entity.stub',
        'relation' => 'Domain/Entities/Traits/Relations/relations.stub',
        'customer-attributes' => 'Domain/Entities/Traits/CustomAttributes/attributes.stub',
        'factory' => 'Domain/Database/Factories/factory.stub',
        'migration' => 'Domain/Database/Migrations/migration.stub',
        'migration_view' => 'Domain/Database/Migrations/view.stub',
        'seeder' => 'Domain/Database/Seeds/seeder.stub',
        'view-fields' => 'Domain/Resources/Views/_partials/_fields.blade.stub',
        'view-scripts' => 'Domain/Resources/Views/_partials/_scripts.blade.stub',
        'view-buttons' => 'Domain/Resources/Views/buttons/actions.blade.php',
        'view-create' => 'Domain/Resources/Views/create.blade.php',
        'view-edit' => 'Domain/Resources/Views/edit.blade.php',
        'view-index' => 'Domain/Resources/Views/index.blade.php',
        'view-show' => 'Domain/Resources/Views/show.blade.php',
        'first_domain-entity' => 'User/entity.stub',
        'first_domain-user-migration' => 'User/user-migration.stub',
        'first_domain-user-factory' => 'User/user-factory.stub',
        'first_domain-user-seeder' => 'User/user-seeder.stub',
        'first_domain-user-route-service-provider' => 'User/route-service-provider.stub',
        
        'component-view' => 'Common/Components/view.stub',
        'component-class' => 'Common/Components/class.stub',
        'route-web' => 'route-web.stub',


        'phpunit' => 'phpunit.stub',
        'magic-Feature' => 'Domain/Tests/magic-Feature.stub',
        'Feature' => 'Domain/Tests/Feature.stub',
        'magic-Unit' => 'Domain/Tests/magic-Unit.stub',
        'Unit' => 'Domain/Tests/Unit.stub',


        'graphql-Directives' => 'Domain/Graphql/Directives/Directives.graphql',
        'graphql-Directives-php' => 'Domain/Graphql/Directives/Directive.stub',
        'graphql-Interfaces' => 'Domain/Graphql/Interfaces/Interfaces.graphql',
        'graphql-Mutations' => 'Domain/Graphql/Mutations/Mutations.graphql',
        'graphql-Mutations-php' => 'Domain/Graphql/Mutations/Mutation.stub',
        'graphql-Queries' => 'Domain/Graphql/Queries/Queries.graphql',
        'graphql-Queries-php' => 'Domain/Graphql/Queries/Query.stub',
        'graphql-Scalars' => 'Domain/Graphql/Scalars/Scalars.graphql',
        'graphql-Scalars-php' => 'Domain/Graphql/Scalars/Scalar.stub',
        'graphql-Subscriptions' => 'Domain/Graphql/Subscriptions/Subscriptions.graphql',
        'graphql-Types' => 'Domain/Graphql/Types/Types.graphql',
        'graphql-Inputs' => 'Domain/Graphql/Inputs/Inputs.graphql',
        'graphql-Unions' => 'Domain/Graphql/Unions/Unions.graphql',
        'graphql-common' => 'directives.graphql.stub',

        'test-crud' => 'directives.graphql.stub',
        'app-js' => 'app.js.stub',
        'main-translation' => 'main.stub',

        'test-crud' => 'directives.graphql.stub',
        'app-js' => 'app.js.stub',
        'main-translation' => 'main.stub',
        'repository-eloquent-test' => 'Domain/Tests/Unit/Repository/Eloquent.stub',
        'resource-test' => 'Domain/Tests/Unit/Resource/Main.stub',
        'resource-normal-test' => 'Domain/Tests/Unit/Resource/Methods/NormalResource.stub',
        'resource-setup' => 'Domain/Tests/Unit/Resource/Methods/SETUP.stub',
        'entity-test' => 'Domain/Tests/Unit/Entity/Main/Main.stub',
        'entity-constants-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/Constants.stub',
        'entity-protected-constants-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/ProtectedConstants.stub',
        'entity-jwt-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/JWT.stub',
        'entity-setup-method' => 'Domain/Tests/Unit/Entity/Main/Methods/Setup.stub',
        'trait-test-case' => 'Domain/Tests/Unit/Entity/Main/Methods/Trait.stub',
        'entity-relations-test' => 'Domain/Tests/Unit/Entity/Relations/Main.stub',
        'entity-relations-anonymous-class' => 'Domain/Tests/Unit/Entity/Relations/AnonymousClass.stub',
        'entity-relations-has-methods' => 'Domain/Tests/Unit/Entity/Relations/Has.stub',
        'entity-relations-belongs-to-methods' => 'Domain/Tests/Unit/Entity/Relations/BelongsTo.stub',
        'entity-relations-belongs-to-many-methods' => 'Domain/Tests/Unit/Entity/Relations/BelongsToMany.stub',
        'request-existance-test-cases-methods' => 'Domain/Tests/Unit/Request/Methods/ExistanceRules.stub',
        'request-size-test-cases-methods' => 'Domain/Tests/Unit/Request/Methods/SizeRules.stub'
    ]
];
