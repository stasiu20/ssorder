<?php

use \OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="SSOrder API documentation",
 *      description="SSOrder API documentation",
 *      @OA\Contact(
 *          email="marcin@morawskim.pl"
 *      ),
 *      @OA\License(
 *          name="MIT",
 *          url="https://github.com/stasiu20/ssorder/blob/master/LICENSE.md"
 *      )
 * )
 *
 * @OA\Server(
 *      url=SSORDER_OPENAPI_HOST_PROD,
 *      description="Prod API Server"
 * )
 *
 * @OA\Tag(
 *     name="Restaurants",
 *     description="API ""Endpoints"" of Restaurants"
 * )
 * @OA\Tag(
 *     name="Sessions",
 *     description="API ""Endpoints"" of Sessions"
 * )
 */
