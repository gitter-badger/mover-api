<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/16/15
 * Time: 8:54 AM
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Video
 * @ORM\Entity
 * @ORM\Table("videos")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 * @package AppBundle\Entity
 */
class Video
{
    const ACCESS_ALL = 1;
    const ACCESS_OWN = 2;
    const ACCESS_LINK = 3;

    /**
     * @ORM\Column(type="integer", options={"unsigned" = true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", name="author_id")
     * @Assert\Valid()
     * @var User
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Vich\UploadableField(mapping="user_videos", fileNameProperty="original")
     * @Assert\File(mimeTypesMessage="video.original.mime_types", mimeTypes={
     *      "video/mp4",
     *      "video/avi",
     *      "video/mpeg",
     *      "video/ogg",
     *      "video/webm",
     *      "video/x-flv",
     *      "video/quicktime",
     *      "video/x-msvideo",
     *      "video/x-ms-wmv"
     *  }, maxSize="200M", maxSizeMessage="video.original.max_size")
     * @Assert\Expression(expression="this.getOriginal() || value")
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    private $originalFile;

    /**
     * @ORM\Column()
     * @var string
     */
    private $original;

    /**
     * @ORM\Column(length=100)
     * @Assert\Length(max="100", maxMessage="video.title.max_length", min="10", minMessage="video.title.min_length")
     * @Assert\NotBlank(message="video.title.not_blank")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="video.description.not_blank")
     * @Assert\Length(min="20", max="2000",
     *  minMessage="video.description.min_length",
     *  maxMessage="video.description.max_length"
     * )
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(referencedColumnName="id", name="category_id")
     * @var Category
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", inversedBy="videos")
     * @ORM\JoinTable(name="video_tags")
     * @var ArrayCollection
     */
    private $tags;

    /**
     *
     * @ORM\Column(type="smallint", options={"unsigned" = true})
     * @Assert\Choice(callback="getAccessLevels", message="video.access_level.invalid")
     * @Assert\NotNull(message="video.access_level.not_null")
     * @var int
     */
    private $accessLevel;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(message="video.comments_available.not_null")
     * @var boolean
     */
    private $commentsAvailable;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="video")
     * @var ArrayCollection
     */
    private $comments;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getAccessLevels()
    {
        return [self::ACCESS_ALL, self::ACCESS_OWN, self::ACCESS_LINK];
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $originalFile
     */
    public function setOriginalFile(File $originalFile = null)
    {
        $this->originalFile = $originalFile;

        if ($originalFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getOriginalFile()
    {
        return $this->originalFile;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Video
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set user
     *
     * @param string $author
     * @return Video
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Video
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set original
     *
     * @param string $original
     * @return Video
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Video
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

    /**
     * Set title
     *
     * @param string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return Video
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set accessLevel
     *
     * @param integer $accessLevel
     * @return Video
     */
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get accessLevel
     *
     * @return integer 
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Add tags
     *
     * @param Tag $tags
     * @return Video
     */
    public function addTag(Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param Tag $tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set commentsAvailable
     *
     * @param boolean $commentsAvailable
     * @return Video
     */
    public function setCommentsAvailable($commentsAvailable)
    {
        $this->commentsAvailable = $commentsAvailable;

        return $this;
    }

    /**
     * Get commentsAvailable
     *
     * @return boolean 
     */
    public function getCommentsAvailable()
    {
        return $this->commentsAvailable;
    }

    /**
     * Add comments
     *
     * @param Comment $comments
     * @return Video
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
