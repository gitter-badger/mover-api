<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/17/15
 * Time: 6:16 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag
 *
 * @ORM\Entity
 * @ORM\Table(name="tags")
 * @package AppBundle\Entity
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned" = true})
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(length=100)
     * @Assert\Length(max="100", maxMessage="tag.name.max_length")
     * @Assert\NotBlank(message="tag.name.not_blank")
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Video", mappedBy="tags")
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
     * @return Tag
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
     * @param \AppBundle\Entity\Video $videos
     * @return Tag
     */
    public function addVideo(\AppBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \AppBundle\Entity\Video $videos
     */
    public function removeVideo(\AppBundle\Entity\Video $videos)
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
