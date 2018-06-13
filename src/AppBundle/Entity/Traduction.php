<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traduction
 *
 * @ORM\Table(name="traduction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TraductionRepository")
 */
class Traduction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\OneToOne(targetEntity="FrArticle")
     * @ORM\JoinColumn(name="fr_id", referencedColumnName="id")
     */
    private $francais;

    /**
     *
     * @ORM\OneToOne(targetEntity="EnArticle")
     * @ORM\JoinColumn(name="en_id", referencedColumnName="id")
     */
    private $anglais;


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
     * Set francais
     *
     * @param \AppBundle\Entity\FrArticle $francais
     *
     * @return Traduction
     */
    public function setFrancais(\AppBundle\Entity\FrArticle $francais = null)
    {
        $this->francais = $francais;

        return $this;
    }

    /**
     * Get francais
     *
     * @return \AppBundle\Entity\FrArticle
     */
    public function getFrancais()
    {
        return $this->francais;
    }

    /**
     * Set anglais
     *
     * @param \AppBundle\Entity\EnArticle $anglais
     *
     * @return Traduction
     */
    public function setAnglais(\AppBundle\Entity\EnArticle $anglais = null)
    {
        $this->anglais = $anglais;

        return $this;
    }

    /**
     * Get anglais
     *
     * @return \AppBundle\Entity\EnArticle
     */
    public function getAnglais()
    {
        return $this->anglais;
    }
}
