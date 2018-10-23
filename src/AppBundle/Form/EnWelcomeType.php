<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EnWelcomeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le titre de l\'article'
                ]
            ])
            //->add('resumeintro')->add('resume')
            ->add('contenu', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tags', TextType::class,[
                'attr' => [
                    'class' => 'form-control tag-input',
                    'placeholder'   => 'Les mots clés',
                    'data-role' => "tagsinput",
                    'style' => 'color: #666'
                ]
            ])
            ->add('statut', CheckboxType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EnWelcome'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_enwelcome';
    }


}
