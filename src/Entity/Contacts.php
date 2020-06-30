<?php
/**
 * Created by PhpStorm.
 * User: si_gi
 * Date: 11/02/2019
 * Time: 14:51
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * BlogPost
 *
 * @ORM\Table(name="Contacts")
 * @ORM\Entity(repositoryClass="App\Repository\ContactsRepository")
 * @ORM\HasLifecycleCallbacks
 */

class Contacts
{

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    protected $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    protected $idContact;

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idContact
     */
    public function setIdContact($idContact): void
    {
        $this->idContact = $idContact;
    }

    /**
     * @return mixed
     */
    public function getIdContact()
    {
        return $this->idContact;
    }
}
