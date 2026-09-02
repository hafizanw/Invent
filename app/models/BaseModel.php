<?php

namespace App\Models;

use Phalcon\Mvc\Model;

abstract class BaseModel extends Model
{
    public function initialize()
    {
        // Default model configuration
        $this->useDynamicUpdate(true);
    }
}
