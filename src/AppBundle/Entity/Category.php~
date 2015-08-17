<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/17/15
 * Time: 3:12 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 *
 * @ORM\Entity
 * @ORM\Table(name="categories")
 * @package AppBundle\Entity
 */
class Category
{
    /**
     *
     * @ORM\Column(type="integer", options={"unsigned" = true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * The category name
     *
     * @ORM\Column
     * @Assert\Length(max="50", maxMessage="category.name.max_length")
     * @Assert\NotBlank(message="category.name.not_blank")
     * @var string
     */
    private $name;

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Video", mappedBy="category")
     * @var ArrayCollection
     */
    private $videos;


    public function __toString()
    {
        return (string)$this->name;
    }

    public function __construct()
    {
        $this->videos = new ArrayCollection();
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add videos
     *
     * @param Video $videos
     * @return Category
     */
    public function addVideo(Video $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param Video $videos
     */
    public function removeVideo(Video $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
