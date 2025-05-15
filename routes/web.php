<?php

use App\Http\Controllers\Admin\CoupanController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ShippingPage;
use App\Http\Controllers\Admin\UserQusetionsController;
use App\Http\Controllers\AllUsers\FavouriteProductsController;
use App\Http\Controllers\AllUsers\HomeController;
use App\Http\Controllers\AllUsers\RatingsController;
use App\Http\Controllers\UserAuthenticate\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\categoriesController;
use App\Http\Controllers\Admin\sub_categoriesController;
use App\Http\Controllers\Admin\productsController;
use App\Http\Controllers\Admin\brandsController;
use App\Http\Controllers\Admin\usersController;
use App\Http\Controllers\AllUsers\HomeController as UserHome;
use App\Http\Controllers\Admin\TempImagesController;
use App\Http\Controllers\Admin\ProfileController;

// userControllers
use App\Http\Controllers\AllUsers\ShopController;
use App\Http\Controllers\AllUsers\BlogsController;
use App\Http\Controllers\AllUsers\PloiciesController;
use App\Http\Controllers\AllUsers\ReviewsController;
use App\Http\Controllers\AllUsers\UserProfileController;
use App\Http\Controllers\AllUsers\CartAddController;
use App\Http\Controllers\AllUsers\CartController;
use App\Http\Controllers\AllUsers\CartProceed;
use App\Http\Controllers\AllUsers\PagesController as userPages;

// user login Register
Route::middleware('UserLoginRegister')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'Login')->name('login');
        Route::get('/loginCheck', 'Check')->name('logincheck');
        Route::get('/register', 'Register')->name('register');
        Route::post('/registerUser', 'Save')->name('registerUser');
        Route::get('/EmailSend', 'emailCheck')->name('emailSend');
        Route::post('/emailSave', 'emailSave')->name('emailSendSave');
        Route::get('/emailTokenCheck/{token}', 'TokenCheck')->name('EmailTokenCheck');
        Route::put('/UpdatePassword/{email}', 'UpdatePasswordSave')->name('UpdatePassword');

    });
});

// Exclude middleware from the logout route
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');
// user ratings on products
Route::controller(RatingsController::class)->group(function(){
    Route::post('RatingsStore','saveRatings')->name('RatingsStore');
    Route::get('updateComment/{id}','updateCommentSave')->name('updateComment');
    Route::delete('deleteComment/{id}','DeleteComment')->name('deleteComment');
    Route::patch('SaveComment/{id}','SaveUpdateComment')->name('SaveComment');

});



// only admin access these pages
Route::middleware(['auth','AdminAccess:admin'])->group(function(){
    Route::get("/Admindashborad",[DashboardController::class,"DashboardView"])->name("dashborad");
    // Shipping section
    Route::resource('Shipping',ShippingPage::class);
    // coupan code
    Route::resource('Coupan',CoupanController::class);
    // pages
    Route::resource('Pages',PagesController::class);
    //user Questions
    Route::get('/Questions',[UserQusetionsController::class,'AllQuestionsLoad'])->name('Questions');
    Route::get('/SingleQuestion/{id}',[UserQusetionsController::class,'SingQuestion'])->name('Question');
    Route::patch('/response/{Questionid}/{UserId}',[UserQusetionsController::class,'SaveResponse'])->name('response');
     
    // orders section
    Route::controller(OrderController::class)->group(function(){
        Route::get('AllOrders','LoadOrders')->name('AllOrders');
        Route::get('UserOrder/{orderId}/{userId}','SingeUserOrder')->name('LoadSingeOrder');
        Route::put('payment/','UpdatePaymentStatus')->name('paymentUpdate');
        Route::put('order/','UpdateOrderStatus')->name('orderUpdate');


    });
    // Categories section
    Route::group(['prefix' => 'Categories'], function () {
    Route::get("/",[categoriesController::class,"LoadCategroyView"])->name("Categories");
    Route::post("/Add",[categoriesController::class,"AddCategory"])->name("CategoriesAdd");
    Route::get("/LoadAll/{sort?}",[categoriesController::class,"LoadAllCategries"])->name("AllCategries");
    Route::get("/UpdateLoad/{id}",[categoriesController::class,"LoadUpdateCategries"])->name("CategoryUpdateLoad");
    Route::patch("/Update/{id}",[categoriesController::class,"UpdateCategory"])->name("CategoryUpdate");
    Route::delete("/delete/{id}",[categoriesController::class,"DelCategory"])->name("CategoryDelete");
    Route::get("/RelatedcategoryLoad",[categoriesController::class,"LoadSearchCategries"])->name("RelatedcategoryLoad");
    });

    // SubCategories section
    Route::group(["prefix"=>"SubCategories"],function(){
    Route::get("/",[sub_categoriesController::class,"LoadSubCategroyView"])->name("SubCategories");
    Route::post("/Add",[sub_categoriesController::class,"AddSubCategries"])->name("AddSubCategory");
    Route::get("/LoadAll",[sub_categoriesController::class,"LoadAllSubCategries"])->name("AllSubCategries");
    Route::get("/UpdateLoad/{id}",[sub_categoriesController::class,"LoadUpdateSubCategries"])->name("SubCategoryUpdate");
    Route::patch("/Update/{id}",[sub_categoriesController::class,"UpdateSubCategory"])->name("SubCatUpdate");
    Route::get("/delete/{id}",[sub_categoriesController::class,"DeleteSubCate"])->name("SubcategoryDelete");
    });

    // Brands section
    Route::group(["prefix"=>"Brand"],function(){
    Route::get("/",[brandsController::class,"LoadBrandView"])->name("Brand");
    Route::post("/Add",[brandsController::class,"AddBrand"])->name("AddBrand");
    Route::get("/LoadAll/{bsort?}",[brandsController::class,"LoadAllBrands"])->name("AllBrands");
    Route::get("/UpdateLoad/{id}",[brandsController::class,"LoadUpdateBrands"])->name("BrandUpdateLoad");
    Route::patch("/update/{id}",[brandsController::class,"UpdateBrand"])->name("brandUpdate");
    Route::delete("/delete/{id}",[brandsController::class,"DeleteBrand"])->name("brandDelete");
    });
   
    // Products section
    Route::group(["prefix"=>'Product'],function(){
    Route::get("/",[productsController::class,"LoadProductView"])->name("product");
    Route::post("/Add",[productsController::class,"AddProduct"])->name("ProductAdd");
    Route::get("/LoadAll",[productsController::class,"LoadAllProducts"])->name("productLoad");
    Route::get("/UpdateLoad/{id}",[productsController::class,"LoadUpdateProducts"])->name("ProductUpdateLoad");
    Route::patch("/Update/{id}",[productsController::class,"UpdateProducts"])->name("ProductUpdate");
    Route::post("/TempImages",[TempImagesController::class,"StoreImages"])->name("tempimages");
    Route::get("/RelatedProduct",[productsController::class,"RealtedProducts"])->name("RelatedProductsLoad");
    Route::delete("/delete/{id}",[productsController::class,"productDel"])->name("productDelete");
    Route::delete("/deleteImg/{id}",[productsController::class,"productImgDel"])->name("productImgDelete");
    });
    
    // AdminUsers section
    Route::group(["prefix"=>'User'],function(){
    Route::get("/",[usersController::class,"LoadUserView"])->name("user");
    Route::post("/Add",[usersController::class,"AddUser"])->name("Adduser");
    Route::get("/LoadAll",[usersController::class,"LoadAllUsers"])->name("Allusers");
    Route::get("/UpdateLoad/{id}",[usersController::class,"LoadUpdateUser"])->name("UpdateLoaduser");
    Route::patch("/update/{id}",[usersController::class,"UpdateUser"])->name("userupdate");
    Route::delete("/delete/{id}",[usersController::class,"DeleteUser"])->name("userdelete");
    });
});
Route::patch("User/update/{id}",[usersController::class,"UpdateUser"])->name("userupdate");


// All Users pages
Route::get("/Home",[UserHome::class,"HomeView"])->name("Home");
// load the All product page
Route::get('Products/{categoriId}/{Subcategroy?}/{brand?}/{minPrice?}/{maxPrice?}',[ShopController::class,'LoadAllProducts'])->name('ProductsLoad');
// load  pages contact
Route::get("PagesContact/{name}",[userPages::class,'PagesContact'])->name('PagesContact');
Route::post('PagesContact/{name}/UserMessage',[userPages::class,'SaveMessage'])->name('UserMessage');
// load Blog page
Route::get("Blogs",[BlogsController::class,'Blogs'])->name('blogs');
// load reviews page
Route::get('reviews',[ReviewsController::class,'Reviews'])->name('Reviews');
// load user profile
Route::get('Userprofile',[UserProfileController::class,'UserProfile'])->name('UserProfile');
Route::match(['get','patch'],"User/updateAddress/{id}",[UserProfileController::class,"UpdateAddress"])->name("updateAddress");
Route::match(['get','patch'],"Changepassword/{id}",[UserProfileController::class,"ChangePassword"])->name("ChangePassword");
// load cart page
Route::get('CartProduct/{id}',[CartController::class,'CartPage'])->name('CartProduct');
// show more products
Route::get('showMoreProduts/{id}',[HomeController::class,'ShowMoreProducts'])->name('MoreProducts');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('CartPage',CartAddController::class);
Route::controller(CartProceed::class)->group(function(){
    Route::get('CartProceed','ProceedForm')->name('CartProceed');
    Route::get('CountryShip','CountryShipPrice')->name('CountryShip');
    Route::post('SubmitOrder','SubmitOrder')->name('SubmitOrder')->middleware(['auth']);
    Route::get('OrderDone/{orderId}','orderDone')->name('OrderDone')->middleware(['auth']);

});
Route::controller(FavouriteProductsController::class)->group(function () {
    Route::post('AddFavourite/{id}', 'AddProducts')->name('AddFavourite');
    Route::delete('RemoveFavourite/{id}', 'RemoveProducts')->name('RemoveFavourite');

});
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
