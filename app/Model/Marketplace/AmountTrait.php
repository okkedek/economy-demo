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


use App\Model\Marketplace\Exception\InsufficientAmountException;

trait AmountTrait
{
    private $amount;

    public function take($amount)
    {
        if ($this->amount < $amount) {
            throw new InsufficientAmountException();
        }

        return $this->getWithAmount($amount);
    }

    public function substract($amount)
    {
        if ($this->amount >= $amount) {

            return $this->getWithAmount($this->amount - $amount);
        }
    }

    public function add($amount)
    {
        return $this->getWithAmount($this->amount + $amount);
    }


    public function getAmount()
    {
        return $this->amount;
    }

    public abstract function getWithAmount($amount);
}