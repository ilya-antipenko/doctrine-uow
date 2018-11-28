This repository shows an example of unsafe behaviour of Doctrine2 in case of using `flush` inside `postFlush` event.
Doctrine documentation mentions that: https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#postflush 

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
