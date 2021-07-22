<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Categorie;
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

        $faker = Factory::create();

        for($c=1; $c < 6; $c++){
            //création objet categorie pour pouvoir remplir categorie_id dans restaurant
            $category= new Categorie;
            $category->setCat($faker->sentence(1));
            $manager->persist($category);

            for($i=1; $i < 3; $i++){
            //création objet restaurant pour chaque catégorie créée
            $restaurant = new Restaurant(); 

            $restaurant->setNom($faker->name)
                        ->setAdresse($faker->address)
                        ->setNationalite($faker->sentence(1))
                        ->setPrixMoyen($faker->text(10))
                        ->setCategorieId($category)
                        ->setPhoto($faker->imageUrl($width = 640, $height = 480))
                        ->setDescription($faker->paragraph());
            $manager->persist($restaurant);
    
            }
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
// for ($c = 0; $c < 4; $c++) {
//     $category = new Category;
//     $category->setName($faker->department)
//         ->setSlug(strtolower($this->slugger->slug($category->getName())));
//     $manager->persist($category);

//     for ($p = 0; $p < mt_rand(10, 35); $p++) {
//         $product = new Product;
//         $product->setName($faker->productName)
//             ->setPrice($faker->price(2000, 15000))
//             ->setSlug(strtolower($this->slugger->slug($product->getName())))
//             ->setCategory($category)
//             ->setShortDescription($faker->paragraph())
//             ->setPicture($faker->imageUrl(250, 250, true));
//         $manager->persist($product);
//     }
// }
// $manager->flush();