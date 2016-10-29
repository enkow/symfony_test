<?php
/**
 * Task entity.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Task.
 *
 * @package Model
 * @author Tomasz Chojna
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Task")
 */
class Task
{
    /**
     * Id.
     *
     * @ORM\Id
     * @ORM\Column(
     *     type="integer",
     *     nullable=false,
     *     options={
     *         "unsigned" = true
     *     }
     * )
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    private $id;

    /**
     * Title.
     *
     * @ORM\Column(
     *     name="title",
     *     type="string",
     *     length=255,
     *     nullable=false
     * )
     * @Assert\NotBlank(groups={"task-default", "task-edit"})
     * @Assert\Length(min=3, groups={"tag-default", "task-edit"})
     *
     * @var string $title
     */
    private $title;

    /**
     * Notes.
     *
     * @ORM\Column(
     *     name="notes",
     *     type="text",
     *     nullable=true
     * )
     * @Assert\Length(max=1024, groups={"tag-default", "task-edit"})
     *
     * @var string $notes
     */
    private $notes;

    /**
     * Created at.
     *
     * @ORM\Column(
     *     name="created_at",
     *     type="datetime"
     * )
     *
     * @var \DateTime $createdAt
     */
    private $createdAt;

    /**
     * Is finished.
     *
     * @ORM\Column(
     *     name="is_finished",
     *     type="boolean"
     * )
     * @Assert\Choice(choices = {0, 1}, groups={"task-edit"})
     *
     * @var boolean $isFinished
     */
    private $isFinished;

    /**
     * Tags array
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(
     *      name="tasks_tags",
     *      joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection $tags
     */
    protected $tags;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id.
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id.
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title.
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set notes.
     *
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes.
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isFinished.
     *
     * @param boolean $isFinished
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;
    }

    /**
     * Get isFinished.
     *
     * @return boolean 
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Add tags.
     *
     * @param \AppBundle\Entity\Tag $tags
     */
    public function addTag(\AppBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Remove tags
     *
     * @param \AppBundle\Entity\Tag $tags
     */
    public function removeTag(\AppBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags.
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
