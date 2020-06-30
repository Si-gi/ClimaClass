<?php
/**
 * Created by PhpStorm.
 * User: si_gi
 * Date: 08/02/2019
 * Time: 10:45
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Message
 *
 * @ORM\Table(name="private_message")
 * @ORM\Entity(repositoryClass="App\Repository\PrivateMessageRepository")
 * @ORM\HasLifecycleCallbacks
 */

class PrivateMessage
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="receiver", referencedColumnName="id")
     */
    protected $receiver;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="sender", referencedColumnName="id")
     */

    protected $sender;

    /**
     * @ORM\Column(type="text", name="content")
     */

    protected $content;

    /**
     * @ORM\Column(type="datetime", name="sendAt", nullable=true)
     */
    protected $sendAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

    /**
     * @param mixed $sendAt
     */
    public function setSendAt($sendAt): void
    {
        $this->sendAt = $sendAt;
    }

}
