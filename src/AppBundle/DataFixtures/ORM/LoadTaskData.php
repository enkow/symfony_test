<?php
/**
 * Data fixture for Task entity.
 *
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Task;


/**
 * Class LoadTaskData.
 */
class LoadTaskData implements FixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $task = new Task();
        $task->setTitle('test');
        $task->setNotes('some note');
        $task->setCreatedAt(new \DateTime());
        $task->setIsFinished('0');

        $tagPrivate = $manager->getRepository('AppBundle:Tag')
            ->findOneByName('private');
        $tagImportant = $manager->getRepository('AppBundle:Tag')
            ->findOneByName('important');
        $task->addTag($tagPrivate);
        $task->addTag($tagImportant);

        $manager->persist($tagPrivate);
        $manager->persist($tagImportant);
        $manager->persist($task);
        $manager->flush();
    }
}
