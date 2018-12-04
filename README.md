Doctrine ORM Internals. UnitOfWork
==================================

This repository shows an example of unsafe behaviour of Doctrine2 in case of using `flush` inside `postFlush` event.

Slides
------
https://www.slideshare.net/IlyaAntipenko/doctrine-orm-internals-unitofwork-124771728

Install
-------
Run following commands to install application
```
composer install
bin/console doctrine:schema:update --force
```

Steps to reproduce
------------------
1. Open `AppBundle\Command\AppTestCommand`
2. Uncomment code with number 1 and run `bin/console app:test`
3. Uncomment code with number 2 and run `bin/console app:test`
