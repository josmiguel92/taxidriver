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

        foreach ($items as $item){
            if(file_exists($item->getAbsolutePath()))
                $item->updateThumbs();
            else
                $output->writeln("Un lugar (".$item->getName().") contiene una referencia a una imagen que no existe: ". $item->getPath());
        }


        $output->writeln("Se procesaron ". count($items). ' lugares');

        $items = $em->getRepository('AppBundle:Image')->findAll();

        foreach ($items as $item){
            if(file_exists($item->getAbsolutePath()))
                $item->updateThumbs();
            else
                $output->writeln("Una imagen (".$item->getId().") contiene una referencia a una imagen que no existe: ". $item->getPath());

        }

        $output->writeln("Se procesaron ". count($items). ' Imagenes de la galeria');

        $items = $em->getRepository("AppBundle:Blogentrie")->findAll();

        foreach ($items as $item){
            if(file_exists($item->getAbsolutePath()))
                $item->updateThumbs();
            else
                $output->writeln("Un Post (".$item->getTitle().") contiene una referencia a una imagen que no existe: ". $item->getPath());

        }

        $output->writeln("Se procesaron ". count($items). ' Posts');

        $items = $em->getRepository("AppBundle:Transfer")->findAll();

        foreach ($items as $item){
            if(file_exists($item->getAbsolutePath()))
                $item->updateThumbs();
            else
                $output->writeln("Un Transfer (".$item->getName().") contiene una referencia a una imagen que no existe: ". $item->getPath());

        }

        $output->writeln("Se procesaron ". count($items). ' Transfers');

        $items = $em->getRepository("AppBundle:Experience")->findAll();

        foreach ($items as $item){
            if(file_exists($item->getAbsolutePath()))
                $item->updateThumbs();
            else
                $output->writeln("Una Experience (".$item->getName().") contiene una referencia a una imagen que no existe: ". $item->getPath());

        }

        $output->writeln("Se procesaron ". count($items). ' Experience');

        $items = $em->getRepository("AppBundle:AirportTransfer")->findAll();

        foreach ($items as $item){
            if(file_exists($item->getAbsolutePath()))
                $item->updateThumbs();
            else
                $output->writeln("Una AirportTransfer (".$item->getName().") contiene una referencia a una imagen que no existe: ". $item->getPath());

        }

        $output->writeln("Se procesaron ". count($items). ' AirportTransfer');
        $output->writeln("Tarea finalizada");


    }
}