<?php

namespace SWP\EventsBundle\Model;

class EventsResponse
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
}
