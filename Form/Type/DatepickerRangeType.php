<?php

namespace Admingenerator\GeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatepickerRangeType extends AbstractType
{
    protected $defaults;
    
    public function __construct() {
        $this->defaults = array(
            'autoclose'     =>  true,
            'html5_format'  =>  'yyyy-MM-dd',
            'prepend_from'  =>  'date_range.from.label',
            'prepend_to'    =>  'date_range.to.label',
            'weekstart'     =>  1,
            'years'         =>  range(date('Y'), date('Y') - 120),
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               ->add('from', new DatepickerType(), $options['from'])
               ->add('to',   new DatepickerType(), $options['to']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'autoclose'   =>    null,
            'format'      =>    null,
            'prepend'     =>    null,
            'weekstart'   =>    null,
            'years'       =>    null,
            'widget'      =>    'datepicker_range',
            'from'        =>    function (Options $options) {
                return array(
                    'widget'        =>  'datepicker',
                    'attr'          =>  array('class' => 'input-small'),
                    'autoclose'     =>  is_null($options['autoclose']) ? $this->defaults['autoclose']    : $options['autoclose'],
                    'format'        =>  is_null($options['format'])    ? $this->defaults['html5_format'] : $options['format'],
                    'prepend'       =>  is_null($options['prepend'])   ? $this->defaults['prepend_from'] : $options['prepend'],
                    'weekstart'     =>  is_null($options['weekstart']) ? $this->defaults['weekstart']    : $options['weekstart'],
                    'years'         =>  is_null($options['years'])     ? $this->defaults['years']        : $options['years'],
                );
            },
            'to'          =>    function (Options $options) {
                return array(
                    'widget'        =>  'datepicker',
                    'attr'          =>  array('class' => 'input-small'),
                    'autoclose'     =>  is_null($options['autoclose']) ? $this->defaults['autoclose']    : $options['autoclose'],
                    'format'        =>  is_null($options['format'])    ? $this->defaults['html5_format'] : $options['format'],
                    'prepend'       =>  is_null($options['prepend'])   ? $this->defaults['prepend_to']   : $options['prepend'],
                    'weekstart'     =>  is_null($options['weekstart']) ? $this->defaults['weekstart']    : $options['weekstart'],
                    'years'         =>  is_null($options['years'])     ? $this->defaults['years']        : $options['years'],
                );
            },
        ));

        $resolver->setAllowedValues(array(
            'weekstart'       =>  array_merge(array(null), range(0, 6)),
        ));

        $resolver->setAllowedTypes(array(
            'autoclose'       =>  array('null', 'bool'),
            'format'          =>  array('null', 'int', 'string'),
            'prepend'         =>  array('null', 'bool', 'string'),
            'weekstart'       =>  array('null', 'int'),
            'years'           =>  array('null', 'array'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'datepicker_range';
    }
}
