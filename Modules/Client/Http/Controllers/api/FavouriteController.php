<?php

namespace Modules\Client\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Favourite;
use Modules\Client\Http\Requests\FavouriteRequest;
use Modules\Client\Service\FavouriteService;
use Modules\Client\Transformers\FavouriteResource;
use Modules\Product\Service\ProductService;
use Modules\Product\Transformers\ProductResource;

class FavouriteController extends Controller
{
    private $favouriteService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(FavouriteService $favouriteService)
    {
        $this->middleware('auth:client');
        $this->favouriteService = $favouriteService;
    }

    public function toggleFavourite(FavouriteRequest $request)
    {
        $favourite = $this->favouriteService->findByMultiKeys('client_id',$request['client_id'],'provider_id',$request['provider_id']);

        if ($favourite) {
            $this->favouriteService->delete($favourite->id);
            return return_msg(true,'Favourite Deleted successfully');
        } else {
            $this->favouriteService->save($request->toArray());
            return return_msg(true,'Favourite Added successfully');
        }
    }

    public function favourites(Request $request)
    {
        return return_msg(true,trans('response.Favorites'),$this->favouriteService->findBy('client_id',auth('client')->id(),'provider',$request['paginate']));

    }
}
