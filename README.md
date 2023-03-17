# Zelty_test
Documentation faites par Fidel REYES
## Présentation
Ceci est une application test de développement 
sous Symfony pour Zelty
Le test en PHP consiste en Développer une petite application web qui permet 
de gérer des articles à partir d’une API.

## Configuration requise:

- **symfony 6.2.7**
- **php 8.1.16**
- **docker**
- **docker-compose**
- 

# DATABASE Entrez mdp: root
DATABASE_URL="mysql://root:root@172.16.238.13:3306/zelty?serverVersion=mariadb-10.10.2&charset=utf8mb4"

# MAILER Entrez gmail
MAILER_DSN=gmail://adresse@gmail.com:mdp@localhost
exit
```

## Démarrage
```http://zelty_test.localhost/ ```

Entrer l'une de ses url et authentifiez-vous.

### zelty_test
```http://zelty_test.localhost/register ```
```http://zelty_test.localhost/login ```
```http://zelty_test.localhost/api/articles/{id} ```

### Webmail (mailhog)
```http://127.0.0.1:8025```



### .env
|  Apps | Name  |   Default | 
|---|---|---|
|  Hub | **DATABASE_URL** | **mysql://root:root@db:3306/laravel9** |


## Commandes utiles
Stopper tout les containers actifs
```shell
docker stop $(docker ps -q)
```
