<?php

namespace App\Listener;

use App\Entity\Telephones;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Telephones::class)]
#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: Telephones::class)]
class TelephoneImageListener
{
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    public function preUpdate(Telephones $telephone, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('nom')) {
            foreach ($telephone->getImages() as $image) {
                if (!$image->getImage()) {
                    $path = $this->kernel->getProjectDir()
                        . '/public/images/telephones/'
                        . $event->getEntityChangeSet()['slug'][0]
                        . '/' . $image->getImageName();

                    if (is_file($path)) {
                        $image = new File($path);

                        $image->move(
                            $this->kernel->getProjectDir() . '/public/images/telephones/' . $telephone->getSlug()
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

    public function postRemove(Telephones $telephone): void
    {
        $dir = $this->kernel->getProjectDir()
            . '/public/images/telephones/'
            . $telephone->getSlug();

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
