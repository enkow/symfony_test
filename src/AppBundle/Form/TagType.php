<?php
/**
 * Tag type.
 *
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class TagType.
 *
 */
class TagType extends AbstractType
{
    /**
     * Form builder.
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array $options Form options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'id',
            HiddenType::class
        );
        if (isset($options['validation_groups'])
            && count($options['validation_groups'])
            && !in_array('tag-delete', $options['validation_groups'])
        ) {
            $builder->add(
                'name',
                TextType::class,
                array(
                    'label'      => 'form.tag.name',
                    'required'   => true,
                )
            );
        }
        $builder->add(
            'save',
            SubmitType::class,
            array(
                'label' => 'form.save'
            )
        );
    }

    /**
     * Sets default options for form.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Tag',
                'validation_groups' => 'tag-default',
            )
        );
    }

    /**
     * Getter for form name.
     *
     * @return string Form name
     */
    public function getBlockPrefix()
    {
        return 'tag_form';
    }
}
