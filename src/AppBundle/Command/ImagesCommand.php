<?php
/**
 * Created by PhpStorm.
 * User: Josué Aguilar
 * Date: 21/06/2018
 * Time: 23:51
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use \AppBundle\Entity\Blogentrie;
use \AppBundle\Entity\Image;
use \AppBundle\Entity\Place;




class ImagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('thumbs:update')
            ->setDescription('Re-create thumbnails for all images')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $items = $em->getRepository('AppBundle:Place')->findAll();

        foreach ($items as $item)
            $item->updateThumbs();

        $output->writeln("Se procesaron ". count($items). ' lugares');

        $items = $em->getRepository('AppBundle:Image')->findAll();

        foreach ($items as $image)
            $image->updateThumbs();

        $output->writeln("Se procesaron ". count($items). ' Imagenes de la galeria');

        $items = $em->getRepository("AppBundle:Blogentrie")->findAll();

        foreach ($items as $post)
            $post->updateThumbs();

        $output->writeln("Se procesaron ". count($items). ' Posts');
        $output->writeln("Tarea finalizada");


    }
}