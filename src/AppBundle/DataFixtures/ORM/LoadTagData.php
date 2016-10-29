<?php
/**
 * Data fixture for Tag entity.
 *
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Tag;

/**
 * Class LoadTagData
 */
class LoadTagData implements FixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tags = array('private', 'business', 'important', 'school');
        foreach ($tags as $tag) {
            $obj = new Tag();
            $obj->setName($tag);
            $manager->persist($obj);
        }
        $manager->flush();
    }
}
