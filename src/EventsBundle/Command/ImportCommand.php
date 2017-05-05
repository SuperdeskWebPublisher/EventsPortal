<?php

namespace SWP\EventsBundle\Command;

use SWP\Bundle\BridgeBundle\Client\GuzzleClient;
use SWP\Component\Bridge\Model\Event;
use SWP\EventsBundle\Model\EventsResponse;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('swp:events:import')
            ->setDescription('Import Events.')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new GuzzleClient();

        $response = $client->makeCall('https://sdp-master.test.superdesk.org/api/events');
        $serializer = $this->getContainer()->get('serializer');
        $events = $serializer->deserialize($response['body'], EventsResponse::class, 'json');
        $manager = $this->getContainer()->get('doctrine')->getManager();

        /** @var Event $event */
        foreach ($events->getItems() as $event) {
            foreach ($event->getLocations() as $location) {
                $location->setEvent($event);
                $manager->persist($location);
            }
            foreach ($event->getAnpaCategory() as $category) {
                $category->setEvent($event);
                $manager->persist($category);
            }

            $manager->persist($event);
        }

        $manager->flush();
        die;
    }
}
