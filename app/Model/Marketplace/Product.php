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
 * Class Product
 *
 * ValueObject: models an amount of product
 *
 * @package App\Model\Marketplace
 */
class Product
{
    use AmountTrait;

    protected $name;

    /**
     * Product constructor.
     * @param $name
     * @param $amount
     */
    public function __construct($name, $amount)
    {
        $this->name = $name;
        $this->amount = $amount;
    }

    /**
     * @param $amount
     * @return Product
     */
    public function getWithAmount($amount)
    {
        return new self($this->name, $amount);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
}