## ajouter des enregistrement avec pshsh
symfony console psysh 
use APP\Entity\Pin;
$p1 = new Pin;
$p1->setTitle("pin 1");
...
$em = $container->get('doctrine'->getManager();
$em->persist($p1);
$em->flush();
dump($p1) // debug this

## creation d'un type Formulaire
symfony console make:form 
-> Pin 

## bundle
affichage date il 20 jours 
->composer require knplabs/knp-time-bundle
Utilisation twing du filtre u
->composer require twig/string-extra
gestion des erreur 404 
->composer require symfony/twig-pack


