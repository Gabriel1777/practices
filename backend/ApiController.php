<?php 

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\AuthManager;

/**
 * @OA\Info(
 *     title="MyAppName API v1",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *     name="Examples",
 *     description="Some example pages",
 * )
 * @OA\Server(
 *     description="MyAppName Swagger API V1 server",
 *     url="https://apiexample.com.co"
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="X-APP-ID",
 *     securityScheme="X-APP-ID"
 * )
 */

class ApiController extends Controller
{
    use ApiResponse;
    use AuthManager;
}