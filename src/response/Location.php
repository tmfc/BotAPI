<?php namespace api\response;

/**
 * @author MehdiKhody <khody.khoram@gmail.com>
 * @since 1.0.0
 *
 * @property float longitude
 * @property float latitude
 *
 * @method float getLongitude()
 * @method float getLatitude()
 */
class Location extends Response
{

    /**
     * Response can have relations with other objects,
     * in this method we introduce all objects this object
     * have relations.
     *
     * @return array of objects
     */
    protected function relations()
    {
        return [];
    }
}