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

## 