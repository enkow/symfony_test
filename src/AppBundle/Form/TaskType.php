<?php
/**
 * Task type.
 *
 */

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\TagDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TaskType.
 *
 */
class TaskType extends AbstractType
{
    /**
     * Form builder.
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array $options Form options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $tagDataTransformer = new TagDataTransformer($options['tag_model']);

        $builder->add(
            'id',
            'hidden'
        );
        if (isset($options['validation_groups'])
            && count($options['validation_groups'])
            && !in_array('task-delete', $options['validation_groups'])
        ) {
            $builder->add(
                'title',
                'text',
                array(
                    'label'      => 'form.task.title',
                    'required'   => true,
                    'max_length' => 255,
                )
            );
            $builder->add(
                'notes',
                'textarea',
                array(
                    'label'    => 'form.task.notes',
                    'required' => false,
                )
            );
            $builder->add(
                $builder
                    ->create('tags', 'text')
                    ->addModelTransformer($tagDataTransformer)
            );
        }
        if (isset($options['validation_groups'])
            && count($options['validation_groups'])
            && in_array('task-edit', $options['validation_groups'])
        ) {
            $builder->add(
                'is_finished',
                'choice',
                array(
                    'choices'  => array(
                        0 => 'form.task.is_finished.no',
                        1 => 'form.task.is_finished.yes',
                    ),
                    'required' => true
                )
            );
        }
        $builder->add(
            'save',
            'submit',
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Task',
                'validation_groups' => 'task-default',
            )
        );
        $resolver->setRequired(array('tag_model'));
        $resolver->setAllowedTypes(
            array(
                'tag_model' => 'Doctrine\Common\Persistence\ObjectRepository'
            )
        );
    }

    /**
     * Getter for form name.
     *
     * @return string Form name
     */
    public function getName()
    {
        return 'task_form';
    }
}
