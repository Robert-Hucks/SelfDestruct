<?php

namespace RobertHucks\SelfDestruct\Traits;

use RobertHucks\SelfDestruct\Models\Destructor;
use RobertHucks\SelfDestruct\Exceptions\MissingAttributeOnModel;

trait SelfDestruct {
    public static function bootSelfDestruct()
    {
        static::created(function ($model) {
            if ($model->created_at && $model->life_time) {
                $ttl = new \DateTime($model->created_at);
                $ttl->add( new \DateInterval("PT{$model->life_time}S"));
                Destructor::create([
                    'deletable_type' => get_class($model),
                    'deletable_id' => $model->getKey(),
                    'ttl' => $ttl,
                ]);
            } else {
                if (!isset($model->created_at)) {
                    throw MissingAttributeOnModel::create(get_class($model), 'created_at');
                }

                if (!isset($model->life_time)) {
                    throw MissingAttributeOnModel::create(get_class($model), 'life_time');
                }
            }
        });
    }
}