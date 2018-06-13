<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraductionEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->fr = $options['fr']; $fr = $this->fr;
        $this->en = $options['en']; $en = $this->en;

        $builder
            ->add('francais', EntityType::class, array(
                    'attr'  => array(
                        'class' => 'form-control',
                        'autocomplete'  => 'off'
                    ),
                    'class' => 'AppBundle:FrArticle',
                    'query_builder' =>  function(EntityRepository $er) use($fr){
                        return $er->findFrArticleNonTraduit($fr);
                    },
                    'choice_label'  => 'titre',
                )
            )
            ->add('anglais', EntityType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                ),
                'class'  => 'AppBundle:EnArticle',
                'query_builder' => function(EntityRepository $er) use ($en) {
                    return $er->findEnArticleNonTraduit($en);
                },
                'choice_label'  => 'titre',
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Traduction',
            'fr' => null,
            'en' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_traduction';
    }


}
