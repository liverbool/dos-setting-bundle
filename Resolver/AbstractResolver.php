<?php

namespace DoS\SettingsBundle\Resolver;

use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Sylius\Bundle\SettingsBundle\Templating\Helper\SettingsHelper;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractResolver extends OptionsResolver
{
    /**
     * @var array
     */
    protected $defaultOptions = array();

    /**
     * @var array
     */
    protected $defaultAllowedTypes = array();

    /**
     * @var array
     */
    protected $defaultAllowedValues = array();

    /**
     * @var SettingsHelper
     */
    protected $settingsHelper;

    /**
     * @param SettingsHelper $settingsHelper
     */
    public function __construct(SettingsHelper $settingsHelper)
    {
        $this->settingsHelper = $settingsHelper;
    }

    /**
     * Init default options.
     *
     * @param \Closure $initDefault
     */
    protected function init(\Closure $initDefault)
    {
        $initDefault();
        $this->resolve($this->settingsHelper->getSettings($this->getNamespace()));
    }

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

    /**
     * @param string $option
     * @param null   $allowedTypes
     *
     * @return OptionsResolver
     */
    public function setAllowedTypes($option, $allowedTypes = null)
    {
        $this->defaultAllowedTypes[$option] = $allowedTypes;

        return parent::setAllowedTypes($option, $allowedTypes);
    }

    /**
     * @param string $option
     * @param null   $allowedValues
     *
     * @return OptionsResolver
     */
    public function setAllowedValues($option, $allowedValues = null)
    {
        $this->defaultAllowedValues[$option] = $allowedValues;

        return parent::setAllowedValues($option, $allowedValues);
    }

    /**
     * @param array $options
     *
     * @return OptionsResolver
     */
    public function setDefaults(array $options)
    {
        $this->defaultOptions = $options;

        return parent::setDefaults($options);
    }

    /**
     * @param SettingsBuilderInterface $builder
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        /** @var OptionsResolver $builder */
        $builder->setDefaults($this->defaultOptions);

        foreach($this->defaultAllowedTypes as $key => $value) {
            $builder->setAllowedTypes($key, $value);
        }

        foreach($this->defaultAllowedValues as $key => $value) {
            $builder->setAllowedValues($key, $value);
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * @return string
     */
    abstract public function getNamespace();

    /**
     * @param array $options
     */
    abstract public function setDefaultOptions(array $options = array());
}
