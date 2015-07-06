<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * InformationsCollectiviteListe
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class InformationsCollectiviteListe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


	 /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\Valid()   
     */
    private $listeInformations;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }





    public function __construct()
    {
        $this->listeInformations = new ArrayCollection();
    }


    /**
     * @param InformationCollectivite $info
     * @return $this
     */
    public function addInformation($info)
    {
        $this->listeInformations[] = $info;

        return $this;
    }

    /**
     * @param InformationCollectivite $info
     * @return $this
     */
    public function removeInformation($info)
    {
        $this->listeInformations->remove($info);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeInformations()
    {
        return $this->listeInformations;
    }

    /**
     * @param InformationCollectivite $infos
     * @return $this
     */
    public function setListeInformations($infos)
    {
        $this->listeInformations = $infos;

        return $this;
    }

   


}
