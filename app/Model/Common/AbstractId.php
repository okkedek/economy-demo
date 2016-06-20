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
    protected $id;

    public function __construct($uuid = null)
    {
        $this->id = $uuid == null ? Uuid::uuid4() : $uuid;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string)$this->id;
    }

    public static function fromString($uuid)
    {
        return new static( Uuid::fromString($uuid));
    }
}