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

# Entrez mdp: root

# Entrez mdp: root
exit
```

## Démarrage

Entrer l'une de ses url et authentifiez-vous.

### test_technique
```http://test_technique.localhost/```

### mixed_vinyl
```http://mixed_vinyl.localhost/ ```

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
