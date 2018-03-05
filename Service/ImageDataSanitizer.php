<?php
namespace Powerbody\Manufacturer\Service;

/**
 * Class ImageDataSanitizer
 * @package Powerbody\Manufacturer\Service
 */
class ImageDataSanitizer
{
    /**
     * @param array $postData
     * @return array
     */
    public function sanitize(array $postData)
    {
        foreach (['logo', 'logo_normal'] as $key) {
            if (!isset($postData[$key]) || !is_array($postData[$key])) {
                continue;
            }

            if (!empty($postData[$key]['delete'])) {
                $postData[$key] = null;
                continue;
            }

            if (isset($postData[$key][0]['name']) && isset($postData[$key][0]['tmp_name'])) {
                $postData[$key] = $postData[$key][0]['name'];
                continue;
            }

            unset($postData[$key]);
        }
        return $postData;
    }
}
