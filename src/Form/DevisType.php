<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    // Méthode pour construire le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajouter les champs du formulaire
        $builder
            ->add('clientName', TextType::class) // Champ pour le nom du client
            ->add('description', TextareaType::class) // Champ pour la description du devis
            ->add('amount', NumberType::class, [ // Champ pour le montant du devis
                'scale' => 2, // Définissez la précision souhaitée pour votre champ Float
            ])
            ->add('createdAt', DateTimeType::class, [ // Champ pour la date de création du devis
                'widget' => 'single_text', // Utiliser un widget de saisie de texte simple pour la date
            ]);
            // Vous pouvez également ajouter d'autres champs ici si nécessaire
    }

    // Méthode pour configurer les options du formulaire
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configuration des options par défaut
        $resolver->setDefaults([
            'data_class' => Devis::class, // L'entité associée au formulaire
        ]);
    }
}
