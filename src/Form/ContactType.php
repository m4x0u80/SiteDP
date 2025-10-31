<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as T;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', T\TextType::class, [
                'label' => 'Nom',
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['max' => 100])]
            ])
            ->add('prenom', T\TextType::class, [
                'label' => 'Prénom',
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['max' => 100])]
            ])
            ->add('email', T\EmailType::class, [
                'label' => 'Email',
                'constraints' => [new Assert\NotBlank(), new Assert\Email()]
            ])
            ->add('telephone', T\TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'constraints' => [new Assert\Length(['max' => 30])]
            ])
            ->add('sujet', T\TextType::class, [
                'label' => 'Sujet',
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['max' => 150])]
            ])
            ->add('message', T\TextareaType::class, [
                'label' => 'Message',
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['min' => 10])]
            ])
            ->add('rgpd', T\CheckboxType::class, [
                'label' => 'J’accepte que mes données soient utilisées pour me recontacter',
                'mapped' => false,
                'constraints' => [new Assert\IsTrue(message: 'Merci de cocher ce champ.')]
            ])
        ;
    }
}
