<?php
/**
 * Task repository.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class Task.
 * @package AppBundle\Repository
 * @author Tomasz Chojna
 */
class Task extends EntityRepository
{
    /**
     * Save task object.
     *
     * @param AppBundle\Entity\Task $task Task object
     * @param boolean $isEdited Is object edited, default false
     */
    public function save(\AppBundle\Entity\Task $task, $isEdited = false)
    {
        if (!$isEdited) {
            $task->setIsFinished(0);
            $task->setCreatedAt(new \DateTime());
        }
        $this->_em->persist($task);
        $this->_em->flush();
    }

    /**
     * Remove task object.
     *
     * @param AppBundle\Entity\Task $task Task object
     */
    public function delete(\AppBundle\Entity\Task $task)
    {
        $this->_em->remove($task);
        $this->_em->flush();
    }

}
