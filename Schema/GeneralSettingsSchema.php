<?php

namespace DoS\SettingsBundle\Schema;

use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Component\Validator\Constraints\Locale;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * General settings schema.
 */
class GeneralSettingsSchema implements SchemaInterface
{
    /**
     * @var array
     */
    protected $defaults;

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = array())
    {
        $this->defaults = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array_merge(array(
                'title'            => 'DoS - Modern dos for everyone',
                'meta_keywords'    => 'DoS',
                'meta_description' => 'DoS is modern for everyone',
                'meta_robots'      => 'index, follow',
                'locale'           => 'th',
                'currency'         => 'THB',
            ), $this->defaults))
            ->setAllowedTypes(array(
                'title'            => array('string'),
                'meta_keywords'    => array('string'),
                'meta_description' => array('string'),
                'meta_robots'      => array('string'),
                'locale'           => array('string'),
                'currency'         => array('string'),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $defaultCurrency = array('THB' => 'THB');

        if (isset($this->defaults['currency'])) {
            $defaultCurrency = array($this->defaults['currency'] => $this->defaults['currency']);
        }

        $builder
            ->add('title', 'text', array(
                'label' => 'ui.trans.settings.general.form.title',
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('meta_keywords', 'text', array(
                'label' => 'ui.trans.settings.general.form.meta_keywords',
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('meta_description', 'textarea', array(
                'label' => 'ui.trans.settings.general.form.meta_description',
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('meta_robots', 'text', array(
                'label' => 'ui.trans.settings.general.form.meta_robots',
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('locale', 'locale', array(
                'label' => 'ui.trans.settings.general.form.locale',
                'constraints' => array(
                    new NotBlank(),
                    new Locale(),
                ),
            ))
            ->add('currency', 'sylius_currency_choice', array(
                'label' => 'ui.trans.settings.general.form.currency',
                'choices' => $defaultCurrency,
                'constraints' => array(
                    new NotBlank(),
                    new Currency(),
                ),
            ))
        ;
    }
}
