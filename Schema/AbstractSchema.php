<?php

namespace DoS\SettingsBundle\Schema;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface as BaseSchemaInterface;

abstract class AbstractSchema implements BaseSchemaInterface
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * @param array  $options
     * @param string $steps
     * @param int    $default
     *
     * @return int
     */
    protected function getDefaultOptionValue(array $options, $steps, $default = 0)
    {
        $value = $options;
        $steps = explode('.', $steps);

        foreach ($steps as $step) {
            if (!array_key_exists($step, $value)) {
                return $default;
            }

            $value = $value[$step];
        }

        return $value;
    }
}
