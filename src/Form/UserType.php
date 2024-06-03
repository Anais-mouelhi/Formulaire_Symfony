<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    // Méthode pour construire le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajouter les champs du formulaire
        $builder
            ->add('nom', TextType::class) // Champ pour le nom de l'utilisateur
            ->add('prenom', TextType::class) // Champ pour le prénom de l'utilisateur
            ->add('email', EmailType::class) // Champ pour l'email de l'utilisateur
            ->add('genre', TextType::class) // Champ pour le genre de l'utilisateur
            ->add('rgpd', CheckboxType::class, [ // Champ pour le consentement RGPD de l'utilisateur
                'label' => 'RGPD', // Libellé du champ RGPD
                'required' => false, // Champ non requis
            ]);
    }

    // Méthode pour configurer les options du formulaire
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configuration des options par défaut
        $resolver->setDefaults([
            'data_class' => User::class, // L'entité associée au formulaire
        ]);
    }
}
