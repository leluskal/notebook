<?php
declare(strict_types=1);

namespace App\Model\FurnishingLink;

use App\Model\Furnishing\Furnishing;
use App\Model\Room\Room;

class FurnishingLink
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $furnishingId;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $linkName;

    /**
     * @var string
     */
    private $shop;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int
     */
    private $roomId;

    /**
     * @var int
     */
    private $purchased;

    private $dateOfPurchase;

    /**
     * @var Furnishing
     */
    private $furnishing;

    /**
     * @var Room
     */
    private $room;

    public function __construct(
        int $furnishingId,
        string $link,
        string $linkName,
        string $shop,
        int $price,
        int $roomId,
        int $purchased
    )
    {
        $this->furnishingId = $furnishingId;
        $this->link = $link;
        $this->linkName = $linkName;
        $this->shop = $shop;
        $this->price = $price;
        $this->roomId = $roomId;
        $this->purchased = $purchased;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFurnishingId(): int
    {
        return $this->furnishingId;
    }

    public function setFurnishingId(int $furnishingId): void
    {
        $this->furnishingId = $furnishingId;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getLinkName(): string
    {
        return $this->linkName;
    }

    public function setLinkName(string $linkName): void
    {
        $this->linkName = $linkName;
    }

    public function getShop(): string
    {
        return $this->shop;
    }

    public function setShop(string $shop): void
    {
        $this->shop = $shop;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getRoomId(): int
    {
        return $this->roomId;
    }

    public function setRoomId(int $roomId): void
    {
        $this->roomId = $roomId;
    }

    public function getPurchased(): int
    {
        return $this->purchased;
    }

    public function setPurchased(int $purchased): void
    {
        $this->purchased = $purchased;
    }

    public function getDateOfPurchase()
    {
        return $this->dateOfPurchase;
    }

    public function setDateOfPurchase($dateOfPurchase): void
    {
        $this->dateOfPurchase = $dateOfPurchase;
    }

    public function getFurnishing(): Furnishing
    {
        return $this->furnishing;
    }

    public function setFurnishing(Furnishing $furnishing): void
    {
        $this->furnishing = $furnishing;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }
}