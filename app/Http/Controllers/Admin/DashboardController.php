<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\products;
use App\Models\UserQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function DashboardView(){
      $products=products::where('pstatus','Yes')->count();
      $totaLOrders=order::count();
      $NewOrders=order::where('status','pending')->get();
      $newProducts=order::where('status','pending')->count();
      $UserQuestions=UserQuestion::count();
      $TotalSale=order::sum('grand_total');
      $newUserQuestions=UserQuestion::where('status','unseen')->count();
      // this month sale
      $CurrentMonthStartDate=Carbon::now()->startOfMonth()->format('Y-m-d');
      $todayDate=Carbon::now()->format('Y-m-d');
      $thisMonthSale=order::whereDate('created_at', '>=' ,$CurrentMonthStartDate)
      ->WhereDate('created_at', '<=' ,$todayDate)->sum('grand_total');
      
      // last month sale
      $StartOffMonth=Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
      $EndOffMonth=Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
      $LastMonthName=Carbon::now()->subMonth()->startOfMonth()->format('M');
      // dd($StartOffMonth);
      $lastMonthSale=order::whereDate('created_at', '>=' ,$StartOffMonth)
                     ->WhereDate('created_at', '<=' ,$EndOffMonth)->sum('grand_total');
      
      // last Thirty Days Sale
      $lastThirtyDays=Carbon::now()->subDays(30)->format('Y-m-d');
      $lastThirtyDaysSale=order::whereDate('created_at', '>=' ,$lastThirtyDays)
      ->WhereDate('created_at', '<=' ,$todayDate)->sum('grand_total');
      
      // recent buyers get
      $recentBuyers=order::latest()->take(4)->get();
      $data['products']=$products;
      $data['totaLOrders']=$totaLOrders;
      $data['NewOrders']=$NewOrders;
      $data['newProducts']=$newProducts;
      $data['UserQuestions']=$UserQuestions;
      $data['TotalSale']=$TotalSale;
      $data['lastMonthSale']=$lastMonthSale;
      $data['LastMonthName']=$LastMonthName;
      $data['thisMonthName']=$thisMonthSale;
      $data['lastThirtyDaysSale']=$lastThirtyDaysSale;
      $data['recentBuyers']=$recentBuyers;
      $data['newUserQuestions']=$newUserQuestions;
      return view("AdminPages.Dashboard.dashboard",$data);
     }
//      public function LoadCategroyView(){
//       return view("AdminPages.categories.AddCategories");
//   }
}
