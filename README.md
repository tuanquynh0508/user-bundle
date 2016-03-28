Symfony 3 User Bundle
============================

###### Summary :

 1) Installing project
    1 - Edit composer.json
    2 - update vendors
    3 - add in kernel
    4 - add in parameter
    5 - add in config
    6 - add routing
    7 - Update database

1) Installing project
------------------------


1- Edit composer.json

    "require": {
        "tuanquynh/user-bundle" : "dev-master"
    },
    "repositories": [
        {
            "type"  : "vcs",
            "url"   : "https://github.com/tuanquynh0508/user-bundle"
        }
    ],

2- UPDATE YOUR VENDOR

    composer update


3 - ADD IN KERNEL :

  new TuanQuynh\UserBundle\TuanQuynhUserBundle(),

4 - ADD IN PARAMETER



5 - ADD IN CONFIG

tuanquynh_user:

6 - ADD ROUTING
```
tuanquynh_user:
    resource: "@TuanQuynhUserBundle/Resources/config/routing.yml"
    prefix:   /
```

7 - UPDATE DATABASE
```
php bin/console doctrine:schema:update --force
php bin/console tuanquynh:user:create admin 123 test1@gmail.com
```
