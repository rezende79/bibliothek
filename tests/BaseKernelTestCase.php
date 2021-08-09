<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Fixtures\BookFixtures;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseKernelTestCase extends KernelTestCase
{
    /** @var EntityManager */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        $this->loadFixtures();
    }

    private function loadFixtures()
    {
        (new BookFixtures())->load($this->entityManager);
    }

    protected function getEntityManager() {
        return $this->entityManager;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}