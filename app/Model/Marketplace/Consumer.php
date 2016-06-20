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


use App\Model\Marketplace\Exception\InsufficientTokensException;

class Consumer
{
    protected $id;
    protected $name;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var Product[]
     */
    protected $products = [];

    /**
     * Consumer constructor.
     * @param $id
     * @param $name
     * @param Token $token
     */
    public function __construct($id, $name, Token $token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->token = $token;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function buyFromShop(Shop $shop, $amount)
    {
        if ($this->token->getAmount() < $amount) {
            throw new InsufficientTokensException();
        }
        $product = $shop->sellFor(new Token($amount));
        $this->token = $this->token->substract($product->getAmount());
        $this->products[] = $product;

        return $product;
    }

    public function getProductAmount()
    {
        $amount = 0;
        
        foreach ($this->products as $product) {
            $amount += $product->getAmount();
        }

        return $amount;
    }

    public function getTokenAmount()
    {
        return $this->token->getAmount();
    }
}