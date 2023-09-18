<?php

namespace App\Listener;

use App\Entity\Tablettes;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Tablettes::class)]
#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: Tablettes::class)]
class TabletteImageListener
{
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    public function preUpdate(Tablettes $tablette, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('nom')) {
            foreach ($tablette->getImages() as $image) {
                if (!$image->getImage()) {
                    $path = $this->kernel->getProjectDir()
                        . '/public/images/telephones/'
                        . $event->getEntityChangeSet()['slug'][0]
                        . '/' . $image->getImageName();

                    if (is_file($path)) {
                        $image = new File($path);

                        $image->move(
                            $this->kernel->getProjectDir() . '/public/images/telephones/' . $tablette->getSlug()
                        );
                    } else {
                        throw new \Exception("Image: $path not found");
                    }
                }
            }

            if (!empty($path)) {
                $dir = mb_substr($path, 0, mb_strrpos($path, '/'));
                $restFiles = glob("$dir/*");

                foreach ($restFiles as $file) {
                    unlink($file);
                }

                rmdir($dir);
            }
        }
    }

    public function postRemove(Tablettes $tablette): void
    {
        $dir = $this->kernel->getProjectDir()
            . '/public/images/telephones/'
            . $tablette->getSlug();

        $files = glob("$dir/*");

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        if (is_dir($dir)) {
            rmdir($dir);
        }
    }
}
