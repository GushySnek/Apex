<?php


namespace App\Service\Listener;


use App\Entity\Hero;
use App\Entity\News;
use App\Entity\Skill;
use App\Entity\Weapon;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DoctrineListener implements EventSubscriber
{
    private $imagesPath;

    public function __construct($imagesPath)
    {
        $this->imagesPath = $imagesPath;
    }

    public function getSubscribedEvents()
    {
        return array('preRemove', 'preUpdate');
    }

    public function preRemove(LifecycleEventArgs $args) {
        $entity = $args->getObject(); // C'est comme ça qu'on récupère l'entité

        if ($entity instanceof Weapon || $entity instanceof Hero || $entity instanceof News || $entity instanceof Skill) {
            unlink($this->imagesPath.'/'.$entity->getImage());
        }
    }

    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getObject(); // C'est comme ça qu'on récupère l'entité

        if ($entity instanceof Weapon || $entity instanceof Hero || $entity instanceof News || $entity instanceof Skill) {
            if ($args->hasChangedField('image')) {
                $oldValue = $args->getOldValue('image');
                unlink($this->imagesPath.'/'.$oldValue);
            }
        }
    }
}