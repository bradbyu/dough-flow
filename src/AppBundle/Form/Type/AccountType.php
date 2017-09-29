<?php
/**
 * Dough Flow Budget Forecasting System
 *
 * @author    Brad Neeley
 * @copyright Copyright (c) 2017
 * @license   All rights reserved
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AccountType
 */
class AccountType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label'    => 'Account Name',
                'required' => true,
                'attr'     => ['maxlength' => 255],
            ]
        );
        $builder->add(
            'type',
            ChoiceType::class,
            [
                'choices' => [
                    Account::TYPE_CHECKING    => Account::TYPE_CHECKING,
                    Account::TYPE_SAVINGS     => Account::TYPE_SAVINGS,
                    Account::TYPE_CREDIT_CARD => Account::TYPE_CREDIT_CARD,
                ]
            ]
        );
        $builder->add(
            'save',
            SubmitType::class
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Account::class,
            ]
        );
    }
}
