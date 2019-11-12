<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameEs', null, ["label"=>"Nombre de la experiencia"])
            ->add('name', null, ["label"=>"Nombre de la experiencia, en ingles"])

            ->add('priceSumary', null, ["label"=>"Precios segun origen"])
            ->add('priceSumaryEn', null, ["label"=>"Precios segun el origen, en ingles"])

            ->add('external', null, ["label"=>"Esta experiencia se gestiona desde otra web"])
            ->add('externalUrl', null, ["label"=>"URL Externa para gestionar la experiencia"])

            ->add('basePrice', MoneyType::class, ["label"=>"Precio de la experiencia",'currency'=>"EUR"])
            ->add('is_personal_price', null, ["label"=>"El precio del servicio se cuenta por persona de forma independiente"])
            ->add('personal_price_increment', MoneyType::class, ["label"=>"Incremento del precio por cada persona, independiente de la configuración general",'currency'=>"EUR"])

            ->add('description', CKEditorType::class, ["label"=>"Descripcion, en español"])
            ->add('descriptionEn',CKEditorType::class, ["label"=>"Descripcion, en ingles"])

            ->add('file', null, ['label'=>"Imagen destacada de la Experiencia"])

            ->add('targetPlace', null, ["label"=>"Lugar donde se realiza"])
            ->add('durationTime', null, ["label"=>"Tiempo de duración, ej: ´8h´, ´12h´"])
            ->add('distance', null, ["label"=>"Distancia, en km"])
            ->add('galleryImage0')->add('galleryImage1')->add('galleryImage2')
            ->add('galleryImage3')->add('galleryImage4')
            ->add('weight', null, ['label'=>'Orden entre los servicios, mayores tienen prioridad'])
            ->add('important', null, ['label'=>'Destacado, aparece en las sugerencias'])

            ->add('isExternalBook', CheckboxType::class , ['label'=>'Este servicio se reserva en otra web', 'required'=>false])
            ->add('trekksoftId', null, ['label'=>'ID en trekksoft. Ejemplo: si ve algo como id="trekksoft_3234", la ID sería 3234'])
            ->add('trekksoftTourId', null, ['label'=>'ID de tour en trekksoft. Ejemplo: si ve algo como .setAttrib("tourId", "254469"), la ID del tour sería 254469','required'=>false])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Experience'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_experience';
    }


}
