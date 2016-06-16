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

namespace App\Model\Marketplace;

/**
 * Class Token
 *
 * ValueObject, models an amount of money in this market
 *
 * @package App\Model\Marketplace
 */
class Token
{
    use AmountTrait;

    /**
     * Token constructor.
     * @param $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param $amount
     * @return Token
     */
    public function getWithAmount($amount)
    {
        return new self($amount);
    }


}