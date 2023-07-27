### Fonts 

titles  'Maven Pro', sans-serif;
subTitles 'Neuton', serif;
text 'Questrial', sans-serif;


### à faire FRONT 

- maquette 
- relever toutes les parties statiques de l'interface / dynamique 

- filtre produits
- recherche par attribut 

### à faire Back 
- tri chaussures H/F ( nouveaux parametres a product);
- relation products - user pour les commandes ( nouvelle antité Commande one to many products et user);  
- permettre aux users de modifier leurs compte (nom prenom mdp va pas plus loin);

- schéma BDD quand tu auras tout fini 

<!-- ### attribut 
= taille, marque ect : relation entre produits - produitsAttribut / produits - produitsCatégorie -->


### droits/accès/permission de fichiers 
- chmod

### sidebar pour le filtre 
### Sécurité 
    = failles XSS 
    = injection 
    = Admin granted 
    -OWASP normes veille 




### migrations

symfony console make:migration 
symfony console doctrine:migrations:migrate 