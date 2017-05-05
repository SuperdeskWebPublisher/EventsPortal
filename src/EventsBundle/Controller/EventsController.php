<?php

namespace SWP\EventsBundle\Controller;

use SWP\Component\Common\Criteria\Criteria;
use SWP\Component\Common\Pagination\PaginationData;
use SWP\Component\Common\Response\ResourcesListResponse;
use SWP\Component\Common\Response\SingleResourceResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{
    /**
     * Lists all events.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Lists all events",
     *     statusCodes={
     *         200="Returned on success."
     *     }
     * )
     * @Route("/api/{version}/events/", options={"expose"=true}, defaults={"version"="v1"}, name="swp_api_events_list")
     * @Method("GET")
     * @Cache(expires="10 minutes", public=true)
     *
     * @return ResourcesListResponse
     */
    public function listAction(Request $request)
    {
        $eventRepository = $this->get('swp.repository.event');
        $events = $eventRepository->getPaginatedByCriteria(new Criteria(), [], new PaginationData($request));

        return new ResourcesListResponse($events);
    }

    /**
     * Get single Event details.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Get single Event details",
     *     statusCodes={
     *         200="Returned on success."
     *     },
     *     requirements={
     *         {"name"="id", "dataType"="integer|string", "required"=true, "description"="Event `id` or `guid`"}
     *     }
     * )
     * @Route("/api/{version}/events/{id}", options={"expose"=true}, defaults={"version"="v1"}, name="swp_api_events_get")
     * @Method("GET")
     * @Cache(expires="10 minutes", public=true)
     *
     * @return SingleResourceResponse
     */
    public function getAction($id)
    {
        $eventRepository = $this->get('swp.repository.event');
        $criteria = new Criteria();
        if (false === strpos($id, 'urn:newsml')) {
            $criteria->set('id', $id);
        } else {
            $criteria->set('guid', $id);
        }

        $event = $eventRepository->getQueryByCriteria($criteria, [], 'e')
            ->getQuery()
            ->getOneOrNullResult();

        return new SingleResourceResponse($event);
    }
}
