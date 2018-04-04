<?php

namespace UserBundle\Entity;

use AppBundle\Entity\BlockchainAddress;
use AppBundle\Entity\Holding;
use AppBundle\Entity\Rig;
use AppBundle\Entity\Setting;
use AppBundle\Entity\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank(groups={"profile"})
     *
     * @var string
     */
    protected $username;

    /**
     * @Assert\NotBlank(groups={"profile"})
     *
     * @var string
     */
    protected $email;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @Assert\NotBlank(groups={"profile"})
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Holding", mappedBy="user")
     */
    private $holdings;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rig", mappedBy="owner")
     */
    private $rigs;

    /**
     * @var Setting
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Setting")
     */
    private $setting;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->holdings = new ArrayCollection();
        $this->rigs = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Holding $holding
     *
     * @return User
     */
    public function addHolding(Holding $holding){
        $this->holdings->add($holding);

        $holding->setUser($this);

        return $this;
    }

    /**
     * @param Holding $holding
     *
     * @return User
     */
    public function removeHolding(Holding $holding){
        $this->holdings->removeElement($holding);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getHoldings(){
       return $this->holdings;
    }

    /**
     * @param Rig $rig
     *
     * @return User
     */
    public function addRig(Rig $rig){
        $this->rigs->add($rig);

        $rig->setOwner($this);

        return $this;
    }

    /**
     * @param Rig $rig
     *
     * @return User
     */
    public function removeRig(Rig $rig){
        $this->rigs->removeElement($rig);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRigs(){
        return $this->rigs;
    }

    /**
     * @return Setting
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @param Setting $setting
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;
    }

    /**
     * @return array
     */
    public function getAlerts(){
        $alerts = array();

        $now = new \DateTime();

        /** @var Rig $rig */
        foreach ($this->rigs as $rig){
            /** @var BlockchainAddress $address */
            foreach ($rig->getBlockchainAddresses() as $address){
                /** @var Transaction $transaction */
                foreach ($address->getToTransactions() as $transaction){
                    if ($transaction->getAlert() && !$transaction->getAlert()->hasBeenRead()) {
                        $diff = $now->diff($transaction->getAlert()->getCreatedAt());

                        $minutes = $diff->days * 24 * 60;
                        $minutes += $diff->h * 60;
                        $minutes += $diff->i;

                        $alerts[] = array(
                            "diff" => $minutes,
                        );
                    }
                }
            }
        }

        return $alerts;
    }
}

