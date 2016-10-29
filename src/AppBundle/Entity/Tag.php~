<?php
/**
 * Tag entity.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Tag.
 *
 * @package Model
 * @author Tomasz Chojna
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Tag")
 * @UniqueEntity(fields="name", groups={"tag-default"})
 */
class Tag
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
     * Name.
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=128,
     *     nullable=false
     * )
     * @Assert\NotBlank(groups={"tag-default"})
     * @Assert\Length(min=3, max=128, groups={"tag-default"})
     *
     * @var string $name
     */
    private $name;

    /**
     * Set Id.
     *
     * @param string $id Id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get Id.
     *
     * @return integer Result
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name Name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }
}
