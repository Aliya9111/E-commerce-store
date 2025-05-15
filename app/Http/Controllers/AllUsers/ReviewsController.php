<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\ProductsRating;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function Reviews(){
        $GetAllRatings=ProductsRating::get();
        if(count($GetAllRatings)>0){
            $ratings=ProductsRating::query();
            $RatingSum=$ratings->sum('ratings');
            $RatingCount=$ratings->count();
            $average=$RatingSum / $RatingCount;
            $data['AllRatings']=$GetAllRatings;
            $data['average']=$average;
            $data['RatingCount']=$RatingCount;
        }
        else{
            $data['average']=0.0;
            $data['RatingCount']=0;
        }
        return view('AllUsersPages.Reviews.reviews',$data);
    }
}
