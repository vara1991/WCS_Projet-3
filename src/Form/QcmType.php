<?php

namespace App\Form;

use App\Entity\Response;
use App\Entity\Participant;
use App\Entity\ResponseQcm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Response', null,  ['choice_label' => 'text',
                'expanded' => true,
                'multiple' => false,
            ])
            /*->add('participant', CollectionType::class, [
                'entry_type' => ParticipantType::class,
                'entry_options' => ['label' => false],
            ])*/
            //->add('participants', null, [
                //'choice_label' => 'id',
                //'expanded' => true,
               // 'multiple' => true
            //])
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResponseQcm::class,
            //'data_class' => Participant::class,
        ]);
    }
}
