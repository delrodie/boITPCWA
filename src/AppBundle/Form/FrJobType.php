<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrJobType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le titre de l\'offre'
                ]
            ])
            ->add('description', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('localite', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'La localite de prise de fonction'
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
            ->add('contrat', ChoiceType::class,[
                'choices' => [
                    'BENEVOLAT' => 'Benevolat',
                    'STAGE' => 'Stage',
                    'STAGE + EMBAUCHE' => 'stage + embauche',
                    'CDD' => 'CDD',
                    'CDI' => 'CDI',
                    'CONSULTANT' => 'Consultant',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('datefin', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date fin de reception de dossier'
                ]
            ])
            ->add('statut', CheckboxType::class,[
                'attr' => [
                    'class' => 'custom-control-input'
                ],
                'required' => false
            ])
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FrJob'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_frjob';
    }


}
