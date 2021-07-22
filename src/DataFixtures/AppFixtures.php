<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Restaurant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create();

        for($i=1; $i < 10; $i++)
        {
            $restaurant = new Restaurant(); 

            $restaurant->setNom($faker->sentence(6))
                        ->setPhoto($faker->imageUrl($width = 640, $height = 480))
                        ->setDescription($faker->text);
            $manager->persist($restaurant);
    
        }
        
        $admin = new User();
        $admin->setEmail("admin@gmail.com")
            ->setNom("admin")
            ->setPassword($this->encoder->encodePassword($admin, "mdp_admin"))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $manager->flush();
    }
}

