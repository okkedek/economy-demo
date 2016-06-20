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

namespace App\Infrastructure\Schema;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarketplaceStatisticsSchema
{
    /**
     * Creates a statistics schema
     * @param $tableName
     */
    public static function create($tableName)
    {
        Schema::create($tableName, function (Blueprint $blueprint) use ($tableName) {

            // UUID4 of linked aggregate
            $blueprint->char('aggregate_id', 36);

            // number of shops on the market
            $blueprint->integer('shops_count', false, true);

            $blueprint->index(['aggregate_id'], $tableName . '_m_v_uix');
        });
    }

    /**
     * Drops a statistics schema
     *
     * @param $tableName
     */
    public static function drop($tableName)
    {
        Schema::drop($tableName);
    }
}