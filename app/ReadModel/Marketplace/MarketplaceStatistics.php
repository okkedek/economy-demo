<?php
/**
 *
 * This file is part of the okkedk/economy demo.
 * (c) 2016 i-Help Networks <okke@ihelp.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\ReadModel\Marketplace;

use Doctrine\DBAL\Connection;

final class MarketplaceStatistics
{
    const TABLE = "marketplace_stats";

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    /**
     * @return \stdClass[] containing statistics
     */
    public function findAll()
    {
        return $this->connection->fetchAll(sprintf("SELECT * FROM %s", self::TABLE));
    }

    /**
     * @param $marketplaceId
     * @return \StdClass
     */
    public function findById($marketplaceId)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s where aggregate_id = :aggregate_id", self::TABLE));
        $stmt->bindValue('aggregate_id', $marketplaceId);
        $stmt->execute();

        return $stmt->fetch();
    }

}
