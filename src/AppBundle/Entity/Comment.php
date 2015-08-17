<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/17/15
 * Time: 8:52 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 *
 * @ORM\Entity
 * @ORM\Table(name="comments")
 * @ORM\HasLifecycleCallbacks
 * @package AppBundle\Entity
 */
class Comment
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
     * @ORM\Column(type="text", length=2000)
     * @Assert\NotBlank(message="comment.message.not_blank")
     * @Assert\Length(max="2000", maxMessage="comment.message.max_length")
     * @var string
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Video")
     * @ORM\JoinColumn(referencedColumnName="id", name="video_id")
     * @Assert\Valid
     * @var Video
     */
    private $video;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", name="author_id")
     * @Assert\Valid
     * @var User
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
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
     * Set message
     *
     * @param string $message
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set video
     *
     * @param Video $video
     * @return Comment
     */
    public function setVideo(Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set author
     *
     * @param User $author
     * @return Comment
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
