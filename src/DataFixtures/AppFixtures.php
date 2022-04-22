<?php

namespace App\DataFixtures;

use App\Entity\NewItem;
use App\Entity\Role;
use App\Entity\User;
use App\Service\FileManagerService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private FileManagerService $fileManagerService;

    public function __construct(UserPasswordHasherInterface $hasher, FileManagerService $fileManagerService)
    {
        $this->hasher = $hasher;
        $this->fileManagerService = $fileManagerService;
    }

    public function load(ObjectManager $manager): void
    {
        $dataFixtures = new DataFixtures();

        $userVadim = $dataFixtures->userVadim();
        $password = $this->hasher->hashPassword($userVadim, 'qwer1234');
        $userVadim->setPassword($password);

        $userHope = $dataFixtures->userHope();
        $password = $this->hasher->hashPassword($userHope, 'qwer1234');
        $userHope->setPassword($password);

        $userTest = $dataFixtures->userTest();
        $password = $this->hasher->hashPassword($userTest, 'qwer1234');
        $userTest->setPassword($password);

        $firstCatNew = $dataFixtures->firstCatNew($userVadim);

        $secondCatNew = $dataFixtures->secondCatNew($userVadim);

        $thirdCatNew = $dataFixtures->thirdCatNew($userHope);

        $manager->persist($userVadim);
        $manager->persist($userHope);
        $manager->persist($userTest);
        $manager->persist($firstCatNew);
        $manager->persist($secondCatNew);
        $manager->persist($thirdCatNew);
        $manager->persist($dataFixtures->firstComment($userHope, $firstCatNew));
        $manager->persist($dataFixtures->secondComment($userVadim, $firstCatNew));
        $manager->persist($dataFixtures->thirdComment($userVadim, $secondCatNew));
        $manager->persist($dataFixtures->fourthComment($userVadim, $thirdCatNew));
        $manager->persist($dataFixtures->fifthComment($userHope, $thirdCatNew));


        $manager->flush();
    }
}
