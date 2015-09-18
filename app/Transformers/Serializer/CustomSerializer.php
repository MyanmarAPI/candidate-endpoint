<?php


/*|-------------------------------------------
  | Customize Serializer Class 
  |-------------------------------------------
 */

namespace App\Transformers\Serializer;

use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\ArraySerializer;

class CustomSerializer extends ArraySerializer
{
    
    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        if (isset($data['party']) && empty($data['party'])) {
            $data['party'] = new \StdClass();
        }

        return $data;
    }

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        $data = array_map(function($item){
            if (isset($item['party']) && empty($item['party'])) {
                $item['party'] = new \StdClass();
            }
            return $item;
        }, $data);

        return array($resourceKey ?: 'data' => $data);
    }

    /**
     * Serialize the meta.
     *
     * @param array $meta
     *
     * @return array
     */
    public function meta(array $meta)
    {
        $default['data_version'] = $this->getDataVersion();

        return array('meta' => array_merge($meta, $default));
    }

    /**
     * Get data version.
     *
     * @return int
     */
    protected function getDataVersion()
    {
        return app('data_version')->current('candidate');
    }

}
