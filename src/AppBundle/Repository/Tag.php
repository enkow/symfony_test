<?php
/**
 * Tag repository.
 *
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class Tag.
 */
class Tag extends EntityRepository
{
    /**
     * Save tag object.
     *
     * @param Tag $tag Tag object
     */
    public function save(\AppBundle\Entity\Tag $tag)
    {
        $this->_em->persist($tag);
        $this->_em->flush();
    }

    /**
     * Remove tag object.
     *
     * @param $tag Tag object
     *
     */
    public function delete(\AppBundle\Entity\Tag $tag)
    {
        $this->_em->remove($tag);
        $this->_em->flush();
    }
}
