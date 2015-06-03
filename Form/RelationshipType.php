<?php

namespace Joubjoub\RelationshipBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

class RelationshipType extends AbstractType {

    
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
                        RelationshipInterface::TYPE_SPONSOR => 'sponsor',
                        RelationshipInterface::TYPE_SEXEFRIEND => 'sexefriend',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                ))
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'joubjoub_relationshipbundle_relationship';
    }

}
