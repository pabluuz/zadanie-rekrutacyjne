<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\StatusHistory;
use App\Entity\StatusType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    const GENERATE_ITEMS_COUNT = 50;
    const MAX_HISTORY = 10;
    const MAX_NUMBER = 13512365234;

    /**
     * @param ObjectManager $manager
     * Idea: refactor code pieces to dedicated methods if time allows
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $statuses = $this->makeStatuses($manager);
        for ($i = 0; $i < self::GENERATE_ITEMS_COUNT; $i++) {
            $item = new Item();
            $item->setName($faker->name)->setNumber($faker->numberBetween(0,self::MAX_NUMBER));
            $item->setStatusType($statuses[rand(0,count($statuses)-1)]);
            $manager->persist($item);
            $manager->flush();
            $historyCount = floor(rand(0,self::MAX_HISTORY));
            for ($j = 0; $j < $historyCount; $j++) {
                $history = new StatusHistory();
                $history->setItem($item)->setStatusType($statuses[rand(0,count($statuses)-1)]);
                $manager->persist($history);
            }
            $manager->flush();
        }
    }

    /**
     * @param ObjectManager $manager
     * @return array Ready array of generated entities
     * TODO add enum if time allows
     */
    private function makeStatuses(ObjectManager $manager): array {
        $statuses = [];
        $statusNames = ['avialible','unavialible','delivery_only','special','unused'];
        foreach ($statusNames as $statusName) {
            $status = new StatusType();
            $status->setName($statusName);
            $manager->persist($status);
            $statuses[] = $status;
        }
        $manager->flush();
        return $statuses;
    }
}
