<?php declare(strict_types=1);

namespace Shopware\Core\System\Currency\SalesChannel;

use OpenApi\Annotations as OA;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\Currency\CurrencyCollection;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"store-api"})
 */
class CurrencyRoute implements CurrencyRouteInterface
{
    /**
     * @var SalesChannelRepositoryInterface
     */
    private $currencyRepository;

    /**
     * @var RequestCriteriaBuilder
     */
    private $criteriaBuilder;

    /**
     * @var SalesChannelCurrencyDefinition
     */
    private $currencyDefinition;

    public function __construct(
        SalesChannelRepositoryInterface $currencyRepository,
        RequestCriteriaBuilder $criteriaBuilder,
        SalesChannelCurrencyDefinition $currencyDefinition
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->currencyDefinition = $currencyDefinition;
    }

    /**
     * @OA\Get(
     *      path="/currency",
     *      description="Loads all available currency",
     *      operationId="readCurrency",
     *      tags={"Store API", "Currency"},
     *      @OA\Parameter(name="Api-Basic-Parameters"),
     *      @OA\Response(
     *          response="200",
     *          description="All available currency",
     *          @OA\JsonContent(ref="#/components/schemas/currency_flat")
     *     )
     * )
     * @Route("/store-api/v{version}/currency", name="shop-api.currency", methods={"GET", "POST"})
     */
    public function load(Request $request, SalesChannelContext $context): CurrencyRouteResponse
    {
        $criteria = $this->criteriaBuilder->handleRequest(
            $request,
            new Criteria(),
            $this->currencyDefinition,
            $context->getContext()
        );

        /** @var CurrencyCollection $currencyCollection */
        $currencyCollection = $this->currencyRepository->search($criteria, $context)->getEntities();

        return new CurrencyRouteResponse($currencyCollection);
    }
}
