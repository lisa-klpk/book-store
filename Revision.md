# Controller

    - Correspond à nos routes (resource)
    - Contient la logique (cerveau de notre route)
    - Il va envoyer des données à nos "view"
    - C'est une class, nommé toujours au singulier et doit suffixé par "Controller"
    - Elle contient des méthodes dont le rôle et de renvoyer des "Symfony\Component\HttpFoundation\Response"
    - Elle manipule des modèles
    - Elle étend de "Symfony\Bundle\FrameworkBundle\Controller\AbstractController"
    - Il manipule aussi des formulaires
    - On peut dire qu'il manipule **TOUT**

# View

    - Elle permet de générer du HTML
    - Elle utilise la librairie twig (https://twig.symfony.com/)
    - Elle utilise le sytème de block et d'héritage (extends)
    - Elle se range dans le dossier "templates" et doit suivre la
      convention de nommage suivante : `{nomDuController}/{nomDeLaMethode}.html.twig`

# Model

    - Il utilise la librairie doctrine (https://www.doctrine-project.org/)
    - Contient de entitées:
        - C'est une class
        - Contient des propriétés (avec getter et setter) qui sont associé au colone d'une table
          en base de données
        - C'est **UNE DONNÉE**
    - Contient des repository (dépot):
        - C'est une class, avec des méthodes
        - Les méthodes de cette class sont nommées "Les finders"
        - C'est ce qui vas lancer nos requếtes à la base de données
        - Ces méthodes récupére une ou plusieurs entités
        - Pour récupérer ces entités nous utilisons le "Doctrine\ORM\QueryBuilder"
    - Contient un "EntityManager":
        - Insère, Met à jour et supprime des entités
        - C'est class
        - possède une méthode persist : Il prépare l'insertion ou la mise à jour d'une entité
        - possède une méthode remove : Il prépare la supression d'une entité
        - possède la méthode flush : Elle envoie les opérations à la base de données

# Route

    - Correspond au "path" (chemin) dans notre application
    - C'est une annotation
    - C'est une class "Symfony\Component\Routing\Annotation\Route"
    - Elle sont nommé avec la convention suivante : `app_{nomDeLaClass}_{nomDeLaMethod}`

# Form

    - C'est un composant divisé en 3 classes :
        - Le form type (c'est une class qui hérite de "Symfony\Component\Form\AbstractType")
          Cette class à pour but de "Configurer notre formulaire et ses champs"
        - Le formulaire (c'est une class qui implémente "Symfony\Component\Form\FormInterface")
          dont le rôle est de "Controller l'intérieur de ce formulaire" (validation, remplissage etc ...)
        - La view (c'est une class "Symfony\Component\Form\FormView") dont le
          rôle est d'afficher le formulaire.

    - Correspond à un Type, c'est une class qui est relié à une
      autre class et dont le role est de remplir cette autre
      class.
    - Le FormType est attaché à une "Data Class" (généralement
      c'est une entité)
    - Le FormType possède des options permettant de configurer
      le comportement de notre formulaire (la méthode, ou la
      protection CSRF)
    - Elle possède une méthode "buildForm" qui configure les
      champs de notre formulaire (nom du champ, type du champ et doptions)
    - Les champs doivent correspondre (sauf exception) aux propriétés
      de la "Data Class"
    - Le formulaire peut être créé en utilisant `$this->createForm(MonType::class)`
      dans le controller.
    - Nous pouvons "remplir" le formulaire avec `$form->handleRequest($request)`
    - Nous pouvons récupérer la "Data Class" avec `$form->getData()`
    - Nous pouvons générer le HTML du formulaire avec `$form->createView()`
    - Nous pouvons nous assurer de la soumissions ainsi que de la validation
      du formulaire graçe a : `$form->isSubmitted()`, `$form->isValid()`
    - Nous pouvons afficher la view de notre formulaire avec "{{ form(nomDuFormView) }}"

# Security

    - La sécurité en symfony est divisé en 2 couches distincte:
      l'authentification et l'authorization
    - La première étape c'est la création de l'utlisateur :
      `symfony console make:user` (elle génére l'entité User)
    - Le seconde étape c'est la mise en place de l'authorization
      et l'authentification pour ce User :
      `symfony console make:auth`.
    - Nous avons un SecurityController avec une méthode login (
      la page de login) et une méthode logout.
    - Nous avons aussi une template "security/login.html.twig" avec
      le formulaire de login.
    - la commande "make:auth" nous génére une class "Authenticator" à l'intérieur
      de cette classe nous avons la méthode "onAuthenticationSuccess" qui se lance
      lorque l'utilisateur c'est connécté avec succes. Il ne faut pas
      oublié de retoucher la redirection.
    - Dans notre entité nous retrouvons une propriété rôle qui permet
      de distinguer des utilisateurs entre eux. Symfony nous
      fournis de base le role "ROLE_USER".
    - Nous avons la possibilité dans un controller de récupérer l'utilisateur
      connécté avec `$this->getUser()` (attention, si l'utilisteur n'est pas
      connécté getUser retournera `null`).
    - Nous avons la possibilité dans un template de récupérer le user avec
      `app.user`
    - Nous pouvons dans une méthode d'un controller utiliser l'annotation
      "Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted" pour
      limiter l'accès à certain role.
    - Nous pouvons tester le role de l'utilisateur dans un template graçe
      à la fonction "is_granted"
    - Nous pouvons créer facilement un formulaire d'inscription en suivant
      les étapes suivantes :
        1. Créer le form type pour le User
        2. Créer une méthode de controller qui affiche et traite le formulaire.
           ATTENTION ! Les mot des passes doivent être crypter, pour
           les crypter il faut "injecter" la class "Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface".
           Ensuite pour crypter le mot de passe il faut utiliser la
           méthode "$crypter->hashPassword($user, $password)".
        3. Créer le template pour cette route.

# Fixtures

    - Les fixtures sont un outil qui permettent de créer des (fausses) données.
    - Installation du bundle (extension) symfony :
        - `composer require hautelook/alice-bundle`
    - Vous pouvez commencer à écrire vos fichiers yml de fixtures dans le répertoire
      `fixtures`.
    - Vous pouvez rajouter des données en suivant le format d'alice : https://github.com/nelmio/alice#table-of-contents
    - Vous pouvez charger les données dans votre base de données en utilisant
      la commande : `symfony console hautelook:fixtures:load`
