<?php

namespace Joubjoub\RelationshipBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use Joubjoub\RelationshipBundle\Model\RelationshipInterface;
use Joubjoub\RelationshipBundle\Provider\RsProviderInterface;

class RelationshipType extends AbstractType {

    protected $rsProvider;

    public function __construct(RsProviderInterface $rsProvider) {
        $this->rsProvider = $rsProvider;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
               
                ->add('status', 'choice', array(
                    'label' => false,
                    'choices' => array(
                        RelationshipInterface::RELATION_ASK => 'ask',
                        RelationshipInterface::RELATION_CONFIRMED => 'confirm',
                        RelationshipInterface::RELATION_DENY => 'deny',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                ))
                ->add('type', 'choice', array(
                    'label' => false,
                    'choices' => array(
                        RelationshipInterface::TYPE_DEFAULT => 'relation',
                        RelationshipInterface::TYPE_FRIEND => 'friend',
                        RelationshipInterface::TYPE_FAMILY => 'family',
                        RelationshipInterface::TYPE_COWORKER => 'coworker',
                        RelationshipInterface::TYPE_SEXEFRIEND => 'sexefriend',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                ))
                ->add('user', 'entity_id', array(
                    'class' => $this->rsProvider->getUserRelationalManager()->getClass(),
                    'label'=>false,
                     'property'=>'username'
                ))
                ->add('relatedUser', 'entity_id', array(
                    'class' => $this->rsProvider->getUserRelationalManager()->getClass(),
                    'label' =>false,
                    'property'=>'username'
                ))
        ;
    }

    public function setDefaultOption(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => $this->rsProvider->getRelationshipManager()->getClass(),
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'joubjoub_relationshipbundle_relationship';
    }

}
