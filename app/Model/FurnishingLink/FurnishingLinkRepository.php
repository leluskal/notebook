<?php
declare(strict_types=1);

namespace App\Model\FurnishingLink;

use App\Model\BaseRepository;

class FurnishingLinkRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'furnishing_link';
    }

    public function getById(int $id): ?FurnishingLink
    {
        $row = $this->getDbConnection()->query('SELECT * FROM furnishing_link WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $furnishingLink = new FurnishingLink(
            (int)$row->furnishing_id,
            (string)$row->link,
            (string)$row->link_name,
            (string)$row->shop,
            (int)$row->price,
            (int)$row->room_id,
            (int)$row->purchased,
        );
        $furnishingLink->setId((int)$row->id);
        $furnishingLink->setDateOfPurchase($row->date_of_purchase);

        return $furnishingLink;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $furnishingLinks = [];

        foreach ($rows as $row) {
            $furnishingLink = new FurnishingLink(
                (int)$row->furnishing_id,
                (string)$row->link,
                (string)$row->link_name,
                (string)$row->shop,
                (int)$row->price,
                (int)$row->room_id,
                (int)$row->purchased
            );
            $furnishingLink->setId((int)$row->id);
            $furnishingLink->setDateOfPurchase($row->date_of_purchase);

            $furnishingLinks[] = $furnishingLink;
        }

        return $furnishingLinks;
    }

    public function findAllUnBoughtByFurnishingId(int $furnishingId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM furnishing_link WHERE furnishing_id = ? AND purchased = 0', $furnishingId)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllBoughtByFurnishingId(int $furnishingId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM furnishing_link WHERE furnishing_id = ? AND purchased = 1', $furnishingId)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllBoughtFurnishings(): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM furnishing_link WHERE purchased = 1 ORDER BY date_of_purchase ASC')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function getTotalSpentMoney(): int
    {
        $totalMoney = (int) $this->getDbConnection()
            ->query('SELECT SUM(price) FROM furnishing_link  WHERE purchased = 1')->fetchSingle();

        return $totalMoney;
    }
}