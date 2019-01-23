<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as MyAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 * @MyAssert\HalfDay()
 * @MyAssert\OverBooking()
 */
class Booking
{
    const TYPE_FULL_DAY = 'allDay';
    const TYPE_HALF_DAY = 'halfDay';
    const MAX_TICKETS_PER_BOOKING = 10;
    const MIN_TICKETS_PER_BOOKING = 1;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visitDate", type="datetime")
     * @Assert\DateTime(message="Le format est incorrect.")
     * @Assert\NotBlank(groups={"booking_init"}, message="Veuillez compléter ce champs")
     * @MyAssert\NotTuesday(groups={"booking_init"})
     * @MyAssert\NotSunday(groups={"booking_init"})
     * @MyAssert\BankHolidays(groups={"booking_init"})
     * @MyAssert\PastDay(groups={"booking_init"})

     */
    private $visitDate;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketNumber", type="integer")
     * @Assert\Type(type="integer",groups={"booking_init"})
     * @Assert\NotBlank(groups={"booking_init"})
     */
    private $ticketNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(groups={"booking_init"}, message="Veuillez compléter ce champs")
     * @Assert\Email(groups={"booking_init"},message="Votre adresse email est incorrect")
     * @Assert\Length(groups={"booking_init"},max=70)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="ticketType", type="string", length=255)
     * @Assert\NotBlank(groups={"booking_init"}, message="Veuillez compléter ce champs")
     */
    private $ticketType;

    /**
     * @var string
     *
     * @ORM\Column(name="transactionNumber", type="string", length=255)
     */
    private $transactionNumber;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="booking", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid(groups={"tickets_filled"})
     */
    private $tickets;

    /**
     * @ORM\Column(name="price", type="float")
     */
    private $price;


    public function __construct()
    {
        $this->visitDate = new \DateTime();
        $this->tickets = new ArrayCollection();
    }

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
     * Set visitDate.
     *
     * @param \DateTime $visitDate
     *
     * @return Booking
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate.
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * Set ticketNumber.
     *
     * @param int $ticketNumber
     *
     * @return Booking
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * Get ticketNumber.
     *
     * @return int
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ticketType.
     *
     * @param string $ticketType
     *
     * @return Booking
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType.
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * Set transactionNumber.
     *
     * @param string $transactionNumber
     *
     * @return Booking
     */
    public function setTransactionNumber($transactionNumber)
    {
        $this->transactionNumber = $transactionNumber;

        return $this;
    }

    /**
     * Get transactionNumber.
     *
     * @return string
     */
    public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }

    /**
     * Add ticket.
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setBooking($this );

        return $this;
    }

    /**
     * Remove ticket.
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTicket(Ticket $ticket)
    {
        return $this->tickets->removeElement($ticket);
    }

    /**
     * Get ticket.
     *
     * @return \Doctrine\Common\Collections\Collection | Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }


    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Booking
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}
