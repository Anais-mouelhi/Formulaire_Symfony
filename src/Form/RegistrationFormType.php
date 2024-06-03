<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    // Méthode pour construire le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajouter les champs du formulaire
        $builder
            ->add('email') // Champ pour l'email de l'utilisateur
            ->add('agreeTerms', CheckboxType::class, [ // Champ pour l'accord aux conditions d'utilisation
                'mapped' => false, // Ne pas mapper ce champ à une propriété de l'entité Admin
                'constraints' => [ // Contraintes de validation pour l'accord aux conditions
                    new IsTrue([
                        'message' => 'You should agree to our terms.', // Message d'erreur si les conditions ne sont pas acceptées
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [ // Champ pour le mot de passe de l'utilisateur
                'mapped' => false, // Ne pas mapper ce champ à une propriété de l'entité Admin
                'attr' => ['autocomplete' => 'new-password'], // Attributs HTML pour le champ de saisie du mot de passe
                'constraints' => [ // Contraintes de validation pour le mot de passe
                    new NotBlank([
                        'message' => 'Please enter a password', // Message d'erreur si le champ est vide
                    ]),
                    new Length([
                        'min' => 6, // Longueur minimale du mot de passe
                        'minMessage' => 'Your password should be at least {{ limit }} characters', // Message d'erreur pour une longueur de mot de passe insuffisante
                        // Longueur maximale autorisée par Symfony pour des raisons de sécurité
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    // Méthode pour configurer les options du formulaire
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configuration des options par défaut
        $resolver->setDefaults([
            'data_class' => Admin::class, // L'entité associée au formulaire
        ]);
    }
}
