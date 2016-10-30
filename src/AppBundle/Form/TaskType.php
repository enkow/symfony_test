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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


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
            HiddenType::class
        );
        if (isset($options['validation_groups'])
            && count($options['validation_groups'])
            && !in_array('task-delete', $options['validation_groups'])
        ) {
            $builder->add(
                'title',
                TextType::class,
                array(
                    'label'      => 'form.task.title',
                    'required'   => true,
                )
            );
            $builder->add(
                'notes',
                TextareaType::class,
                array(
                    'label'    => 'form.task.notes',
                    'required' => false,
                )
            );
            $builder->add(
                $builder
                    ->create('tags', TextType::class)
                    ->addModelTransformer($tagDataTransformer)
            );
        }
        if (isset($options['validation_groups'])
            && count($options['validation_groups'])
            && in_array('task-edit', $options['validation_groups'])
        ) {
            $builder->add(
                'is_finished',
                ChoiceType::class,
                array(
                    'choices'  => array(
                        'form.task.is_finished.no' => 0,
                        'form.task.is_finished.yes' => 1,
                    ),
                    'required' => true
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
                'data_class' => 'AppBundle\Entity\Task',
                'validation_groups' => 'task-default',
            )
        );
        $resolver->setRequired(array('tag_model'));
        $resolver->setAllowedTypes(
            'tag_model',
            'Doctrine\Common\Persistence\ObjectRepository'
        );
    }

    /**
     * Getter for form name.
     *
     * @return string Form name
     */
    public function getBlockPrefix()
    {
        return 'task_form';
    }
}
