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

namespace App\Model\Common;


use Rhumsaa\Uuid\Uuid;

class AbstractId
{
    private $id;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}