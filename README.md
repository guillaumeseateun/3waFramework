"# 3waFramework" Maxime Vilar - Charles Rizzon - Guillaume Seateun 

## Contexte
Nous avons du créer notre propre framework capable d'afficher une page avec des routes.

## Librairies utilisées
- Twig 
- Symfony/Composant/YAML

## Fonctionnement
Le framework s'utilise de la façon suivante :
    - Un point d'entrée sur le fichier index.php défini sur le .htaccess qui va se charger de recevoir toutes les requêtes. C'est lui qui va instancier l'application dans lequel est inclus le fichier app.php qui est le bootstrap de l'application.
    - Un Service Container qui est contenu dans le Dispatcher, qui va gérer la demande du client et lui fournir la réponse.
    - La méthode run() du Dispatcher va invoquer le router et en fonction de la route, instancier la bonne méthode dans le bon contrôleur pour répondre à la requête.
    - Du composant Twig qui va se charger de gérer les vues dans la réponse au client qui sera préparé dans le Service Container.

## Route

Pour utiliser les routes, il faut aller dans le dossier config puis routes.YAML

Exemple :

HomeController_index:
    pattern:   \/
    connect:  App\Controllers\HomeController:index

## Build

composer init

Librairies requises :
- composer require symfony/yaml
- composer require twig/twig

composer.json 
```json

"autoload": {
        "psr-4": {
            "Framework\\": "src/",
            "App\\": "app/"
        }
    }

```

Commande à utiliser ain de démarrer le serveur pour utiliser le framework 
```php
php -S localhost:8000 -t public/
```

