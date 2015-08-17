<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/17/15
 * Time: 5:46 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategories implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories = [
            'Юмор',
            'Кино',
            'ТВ',
            'Игры',
            'Музыка',
            'Авто',
            'Спорт',
            'Техно',
            'Обучение',
            'Реклама',
            'Красота',
            'Аниме',
            'Семья и дети',
            'Конкурс',
            'Диета',
            'Кулинария',
            'Животное',
            'Новости',
            'Природа и путишествия',
            'Исскуство',
            'Разное'
        ];

        foreach ($categories as $cat) {
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}