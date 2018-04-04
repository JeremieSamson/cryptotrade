<?php

namespace AppBundle\Entity\Alert;

use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * TransactionAlert
 *
 * @ORM\Table(name="alert_transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Alert\TransactionAlertRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class TransactionAlert extends Alert
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

