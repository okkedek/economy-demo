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
use App\Model\Marketplace\Exception\OutOfStockException;

class Shop
{
    private $id;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Token
     */
    protected $token;

    protected $isOpen = true;

    /**
     * Shop constructor.
     * @param $id
     * @param Product $product
     */
    public function __construct($id, Product $product)
    {
        $this->id = $id;
        $this->product = $product;
        $this->token = new Token(0);
    }

    public function getId()
    {
        return $this->id;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    /**
     * Sells product for the given amount of tokens. Every product costs one token. 
     * 
     * @param Token $token
     * @return Product
     * @throws OutOfStockException when more tokens were provided than product is available
     */
    public function sellFor(Token $token)
    {
        try {
            $amount = $token->getAmount();
            $sold = $this->product->take($amount);

            $this->token = $this->token->add($amount);
            $this->product = $this->product->substract($amount);
            
            return $sold;
        } catch (InsufficientAmountException $e) {
            throw new OutOfStockException("Out of stock", 0, $e);
        }
    }

    public function isClosed()
    {
        return $this->isOpen !== true;
    }

    public function getProductAmount()
    {
        return $this->product->getAmount();
    }

    public function getTokenAmount()
    {
        return $this->token->getAmount();
    }
}