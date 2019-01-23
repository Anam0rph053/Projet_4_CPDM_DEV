<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\NotBlank(groups={"tickets_filled"}, message="Veuillez compléter ce champs")
     * @Assert\Length(groups={"tickets_filled"},min=2, max=50, minMessage="Le nom doit comporter au minimum 2 caractères", maxMessage="Le nom ne peut pas comporter plus de 50 caractères" )
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Assert\NotBlank(groups={"tickets_filled"}, message="Veuillez compléter ce champs")
     * @Assert\Length(groups={"tickets_filled"},min=2,max=50, minMessage="Le prénom doit comporter au minimum 2 caractères", maxMessage="Le prénom ne peut pas comporter plus de 50 caractères")
     */
    private $firstName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     * @Assert\NotBlank(groups={"tickets_filled"}, message="Veuillez compléter ce champs")
     * @Assert\DateTime(groups={"tickets_filled"}, message="Le format est incorrect")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @Assert\NotBlank(groups={"tickets_filled"}, message="Veuillez compléter ce champs")
     * @Assert\Type(groups={"tickets_filled"}, type="string", message="Erreur, merci de sélectionner votre pays")
     */
    private $country;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="reducePrice", type="boolean", nullable=true)
     * @Assert\Type(groups={"tickets_filled"},type="bool")
     */
    private $reducePrice ;

    /**
     * @var  int
     * @ORM\Column(name="Price", type="integer")
     */
    private $price;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Booking", inversedBy="booking", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Ticket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return Ticket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set birthDate.
     *
     * @param \DateTime $birthDate
     *
     * @return Ticket
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate.
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set reducePrice.
     *
     * @param bool|null $reducePrice
     *
     * @return Ticket
     */
    public function setReducePrice($reducePrice = null)
    {
        $this->reducePrice = $reducePrice;

        return $this;
    }

    /**
     * Get reducePrice.
     *
     * @return bool|null
     */
    public function getReducePrice()
    {
        return $this->reducePrice;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Set booking.
     *
     * @param \AppBundle\Entity\Booking $booking
     *
     * @return Ticket
     */
    public function setBooking(Booking $booking)
    {

        $this->booking = $booking;

        return $this;
    }


    /**
     * Get booking.
     *
     * @return \AppBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
