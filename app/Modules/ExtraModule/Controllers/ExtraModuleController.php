<?php

namespace App\Modules\ExtraModule\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckPermissionController;
use App\Modules\ExtraModule\Requests\ExtraModuleRequest;
use App\Modules\ExtraModule\Models\ExtraModule;
use App\Modules\ProductModule\Models\ProductModule;
use App\Modules\ProductModule\Models\ProductProductAttribute;
use App\Modules\ProductModule\Models\ProductProductCategory;
use App\Modules\ProductModule\Models\ProductProductOption;
use App\Modules\ProductModule\Models\ProductVariant;
use App\Modules\ProductModule\Models\ProductVariantImage;
use App\Modules\ProductModule\Models\ProductVariantProductOptionValue;
use App\Modules\ProductModule\Models\DeliveryType;
use App\Modules\ProductModule\Models\ProductDeliveryType;
use App\Modules\ProductCategoryModule\Models\ProductCategoryModule;
use App\Modules\ProductModule\Requests\ProductUploadRequest;
use App\Modules\ProductBrandModule\Models\ProductBrandModule;
use App\Modules\ProductAttributeModule\Models\ProductAttributeModule;
use App\Modules\ProductOptionModule\Models\ProductOptionModule;
use App\Modules\ProductOptionValueModule\Models\ProductOptionValueModule;
use App\Modules\WarehouseModule\Models\WarehouseModule;
use App\Modules\WarehouseModule\Models\WarehouseItem;
use App\Modules\ProductModule\Models\Tag;
use App\Modules\ProductModule\Models\ProductTag;
use App\Modules\MerchantModule\Models\MerchantModule;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;
use Sentinel;
use File;
use Image;
use Excel;

class ExtraModuleController extends Controller
{

    public function __construct()
    {
        $this->check = new CheckPermissionController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("ExtraModule::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addBannersView(Request $request)
    {
        $permission = $this->check->index();

        if($permission > 0){
            $bannerUrl  = "";
            $logoUrl    = "";
            $currentData = ExtraModule::where('status',STATUS_ACTIVE)->first();

            if(isset($currentData->bannerName)){
                $bannerName = $currentData->bannerName;
                $bannerUrl  = $this->getImageUrl($bannerName,'web/banner/');
            }

            if(isset($currentData->logoName)){
                $logoName = $currentData->logoName;
                $logoUrl  = $this->getImageUrl($logoName,'web/logo/');
            }

            return view("ExtraModule::addBanner")->with(['currentData'  => $currentData,
                                                            'bannerUrl' => $bannerUrl,
                                                            'logoUrl'   => $logoUrl
                                                        ]);
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                    'warning.message'=> 'Permission Denied!',
                    'warning.title' => 'Sorry!' ]);
        }
    }

    public function addBanners(Request $request)
    {
        DB::beginTransaction();
        try{

            $fileNameBanner = "";
            $fileNameLogo   = "";
            $description    = $request->description;
            if ($request->hasFile('banner_img')) {
                $file_banner = $request->file('banner_img');

                $fileNameBanner = 'banner-'.date('YmdHis') . '.' . $file_banner->getClientOriginalExtension();
                $s3 = Storage::disk('s3');
                $filePath = getenv('AWS_S3_WEB_BANNER') . $fileNameBanner;
                $s3->put($filePath, file_get_contents($file_banner));
            }else{
                $fileNameBanner = $request->banner_name;
            }

            if ($request->hasFile('logo_img')) {
                $file_logo = $request->file('logo_img');

                $fileNameLogo = 'logo-'.date('YmdHis') . '.' . $file_logo->getClientOriginalExtension();
                $s3 = Storage::disk('s3');
                $filePath = getenv('AWS_S3_WEB_LOGO') . $fileNameLogo;
                $s3->put($filePath, file_get_contents($file_logo));
            }else{
                $fileNameLogo = $request->logo_name;
            }
            
            ExtraModule::where('status', STATUS_ACTIVE)->update(['status' => STATUS_DELETED]);

            $data = ExtraModule::create([
                        'bannerName'  => $fileNameBanner,
                        'logoName'    => $fileNameLogo,
                        'description' => $description,
                        'status'      => STATUS_ACTIVE,
                        'createdById' => Sentinel::getUser()->id
                    ]);
            DB::commit();
            return redirect( 'other/banners/add' )->with([ 'success' => true,
                'success.message'=> 'Web Template Updated Successfully!',
                'success.title' => 'Well Done!' ]);
            
        }catch(\Exception $e){
            DB::rollBack();
            return redirect( 'other/banners/add' )->with([ 'error' => true,
                'error.message'=> $e->getMessage(),
                'error.title' => 'Ooops!' ]);
        }            
    }

    public static function getImageUrl($fileName, $folder='product/')
    {
        $url = null;
        if (!empty($fileName)) {
            $url = Storage::disk('s3')->temporaryUrl(
                $folder . $fileName, Carbon::now()->addMinutes(30)
             );
        }
        return $url;
    }

    public function othercsvupload()
    {
        return view("ExtraModule::csvupload");
    }
    // Update Prices
    // public function saveothercsv(Request $request)
    // {
    //     DB::beginTransaction();
    //     try{
    //         if($_FILES["csv_file"]){
    //             $filename=$_FILES["csv_file"]["tmp_name"];
    //             if($_FILES["csv_file"]["size"] > 0){
    //                 $file = fopen($filename, "r");

    //                 $sku    = "";
    //                 $price  = "";
    //                 $mrp    = "";

    //                 while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
    //                 {
    //                     $sku = $data[0];
    //                     $price  = $data[1];
    //                     $mrp  = $data[2];

    //                     $check_product = ProductVariant::where('sku',$sku)->first();
    //                     if(!empty($check_product)){
    //                         $id = $check_product->id;
    //                         $variant_product = ProductVariant::find($id);
    //                         $variant_product->salePrice   = $price;
    //                         $variant_product->marketPrice = $mrp;
    //                         $variant_product->save();

    //                     }

    //                 }
    //                 DB::commit();

    //             }
    //         }
    //         return redirect( 'other/othercsvupload' )->with([ 'success' => true,
    //             'success.message'=> 'Product CSV added successfully!',
    //             'success.title' => 'Well Done!' ]);
    //     }catch(\Exception $e){
    //         DB::rollBack();
    //         return $e;
    //         return redirect( 'other/othercsvupload' )->with([ 'error' => true,
    //             'error.message'=> $e->getMessage(),
    //             'error.title' => 'Ooops!' ]);
    //     }
    // }

    // Add new column merchant SKU and update it
    // public function saveothercsv(Request $request)
    // {
    //     DB::beginTransaction();
    //     try{
    //         if($_FILES["csv_file"]){
    //             $filename=$_FILES["csv_file"]["tmp_name"];
    //             if($_FILES["csv_file"]["size"] > 0){
    //                 $file = fopen($filename, "r");

    //                 $sku       = "";
    //                 $merchant  = "";

    //                 while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
    //                 {
    //                     $sku       = $data[0];
    //                     $merchant  = $data[1];

    //                     $check_product = ProductVariant::where('sku',$sku)->first();
    //                     if(!empty($check_product)){
    //                         $id = $check_product->id;
    //                         $variant_product = ProductVariant::find($id);
    //                         $variant_product->merchantSku   = $merchant;
    //                         $variant_product->save();

    //                     }

    //                 }
    //                 DB::commit();

    //             }
    //         }
    //         return redirect( 'other/othercsvupload' )->with([ 'success' => true,
    //             'success.message'=> 'Product CSV added successfully!',
    //             'success.title' => 'Well Done!' ]);
    //     }catch(\Exception $e){
    //         DB::rollBack();
    //         return $e;
    //         return redirect( 'other/othercsvupload' )->with([ 'error' => true,
    //             'error.message'=> $e->getMessage(),
    //             'error.title' => 'Ooops!' ]);
    //     }
    // }

    // Update product name
    // public function saveothercsv(Request $request)
    // {
    //     DB::beginTransaction();
    //     try{
    //         if($_FILES["csv_file"]){
    //             $filename=$_FILES["csv_file"]["tmp_name"];
    //             if($_FILES["csv_file"]["size"] > 0){
    //                 $file = fopen($filename, "r");

    //                 $sku          = "";
    //                 $name         = "";
    //                 // $description  = "";

    //                 while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
    //                 {
    //                     $sku   = $data[0];
    //                     $name  = $data[1];
    //                     // $description  = $data[2];

    //                     $check_product = ProductVariant::where('sku',$sku)->first();
    //                     if(!empty($check_product)){
    //                         $productId = $check_product->productId;
    //                         $product   = ProductModule::find($productId);
    //                         $product->name = $name;
    //                         // $product->description = $description;
    //                         $product->save();
    //                     }
    //                 }
    //                 DB::commit();

    //             }
    //         }
    //         return redirect( 'other/othercsvupload' )->with([ 'success' => true,
    //             'success.message'=> 'Product CSV added successfully!',
    //             'success.title' => 'Well Done!' ]);
    //     }catch(\Exception $e){
    //         DB::rollBack();
    //         return $e;
    //         return redirect( 'other/othercsvupload' )->with([ 'error' => true,
    //             'error.message'=> $e->getMessage(),
    //             'error.title' => 'Ooops!' ]);
    //     }
    // }


    // // Update Stocks
    public function saveothercsv(Request $request)
    {
        DB::beginTransaction();
        try{
            if($_FILES["csv_file"]){
                $filename=$_FILES["csv_file"]["tmp_name"];
                if($_FILES["csv_file"]["size"] > 0){
                    $file = fopen($filename, "r");

                    $sku    = "";
                    $stock  = "";

                    while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
                    {
                        $sku   = $data[0];
                        $stock = $data[1];

                        $check_product = ProductVariant::where('sku',$sku)->first();
                        if(!empty($check_product)){
                            $variantID = $check_product->id;
                            $WarehouseItem = WarehouseItem::where('productVariantId',$variantID)->first();
                            $WarehouseItem->stockOnHand = $stock;
                            $WarehouseItem->save();
                        }
                    }
                    DB::commit();

                }
            }
            return redirect( 'other/othercsvupload' )->with([ 'success' => true,
                'success.message'=> 'Product CSV added successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return $e;
            return redirect( 'other/othercsvupload' )->with([ 'error' => true,
                'error.message'=> $e->getMessage(),
                'error.title' => 'Ooops!' ]);
        }
    }

    

    // Update Prices
//    public function saveothercsv(Request $request)
//    {
//        DB::beginTransaction();
//        try{
//            if($_FILES["csv_file"]){
//                $filename=$_FILES["csv_file"]["tmp_name"];
//                if($_FILES["csv_file"]["size"] > 0){
//                    $file = fopen($filename, "r");

//                    $sku       = "";
//                    $merchant  = "";

//                    while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
//                    {
//                        $sku         = $data[0];
//                        $costPrice   = $data[1];
//                        $salePrice   = $data[2];
//                        $marketPrice = $data[3];

//                        $check_product = ProductVariant::where('sku',$sku)->first();
//                        if(!empty($check_product)){
//                            $variantID = $check_product->id;
//                            $productVariant = ProductVariant::where('id',$variantID)->first();
//                            $productVariant->salePrice   = $salePrice;
//                            $productVariant->costPrice   = $costPrice;
//                            $productVariant->marketPrice = $marketPrice;
//                            $productVariant->save();
//                        }
//                    }
//                    DB::commit();

//                }
//            }
//            return redirect( 'other/othercsvupload' )->with([ 'success' => true,
//                'success.message'=> 'Product CSV added successfully!',
//                'success.title' => 'Well Done!' ]);
//        }catch(\Exception $e){
//            DB::rollBack();
//            return $e;
//            return redirect( 'other/othercsvupload' )->with([ 'error' => true,
//                'error.message'=> $e->getMessage(),
//                'error.title' => 'Ooops!' ]);
//        }
//    }


//    Update Warrenty
//    public function saveothercsv(Request $request)
//    {
//        DB::beginTransaction();
//        try{
//            if($_FILES["csv_file"]){
//                $filename=$_FILES["csv_file"]["tmp_name"];
//                if($_FILES["csv_file"]["size"] > 0){
//                    $file = fopen($filename, "r");

//                    $sku       = "";
//                    $warrenty  = "";

//                    while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
//                    {
//                        $sku         = $data[0];
//                        $warrenty    = $data[1];

//                        $check_product = ProductVariant::where('sku',$sku)->first();
//                        if(!empty($check_product)){
//                            if($warrenty != "Not Recived"){
//                                 $variantID = $check_product->id;
//                                 $productVariant = ProductVariant::where('id',$variantID)->first();
//                                 $productVariant->warranty   = $warrenty;
//                                 $productVariant->save();
//                             }
//                        }
//                    }
//                    DB::commit();

//                }
//            }
//            return redirect( 'other/othercsvupload' )->with([ 'success' => true,
//                'success.message'=> 'Product CSV added successfully!',
//                'success.title' => 'Well Done!' ]);
//        }catch(\Exception $e){
//            DB::rollBack();
//            return $e;
//            return redirect( 'other/othercsvupload' )->with([ 'error' => true,
//                'error.message'=> $e->getMessage(),
//                'error.title' => 'Ooops!' ]);
//        }
//    }

// Update product Brands
    // public function saveothercsv(Request $request)
    // {
    //     DB::beginTransaction();
    //     try{
    //         if($_FILES["csv_file"]){
    //             $filename=$_FILES["csv_file"]["tmp_name"];
    //             if($_FILES["csv_file"]["size"] > 0){
    //                 $file = fopen($filename, "r");

    //                 $sku   = "";
    //                 $brand = "";

    //                 while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
    //                 {
    //                     $sku   = $data[0];
    //                     $brand  = $data[1];
    //                     // $description  = $data[2];

    //                     $check_brand1 = ProductBrandModule::where('name',$brand)->first();
    //                     if(empty($check_brand1)){
    //                         $brands = ProductBrandModule::create([
    //                                     'name'        => $brand,
    //                                     'slug'        => $brand,
    //                                     'isFeatured'  => 1,
    //                                     'createdById' => Sentinel::getUser()->id,
    //                                     'status'      => 1
    //                                 ]);
    //                     }

    //                     $check_brand = ProductBrandModule::where('name',$brand)->first();
    //                     $product_brandid = $check_brand->id;

    //                     $check_product = ProductVariant::where('sku',$sku)->first();
    //                     if(!empty($check_product)){
    //                         $productId = $check_product->productId;
    //                         $product   = ProductModule::find($productId);
    //                         $product->productBrandId = $product_brandid;
    //                         $product->save();
    //                     }
    //                 }
    //                 DB::commit();

    //             }
    //         }
    //         return redirect( 'other/othercsvupload' )->with([ 'success' => true,
    //             'success.message'=> 'Product CSV added successfully!',
    //             'success.title' => 'Well Done!' ]);
    //     }catch(\Exception $e){
    //         DB::rollBack();
    //         return $e;
    //         return redirect( 'other/othercsvupload' )->with([ 'error' => true,
    //             'error.message'=> $e->getMessage(),
    //             'error.title' => 'Ooops!' ]);
    //     }
    // }

    public function excelupload()
    {
        return view("ExtraModule::excelUpload");
    }


    function getDirContents() {


        $files = [];
        $path =  storage_path().'/app/public/product-import';

        if( Storage::exists('/app/public/product-import') ) {
            $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

            $files = array();

            $i = 0;

            foreach ($rii as $file) {
                if (!$file->isDir() && $i < 1) {
                    $files[] = $file->getFilename();

                    $i++;
                }
            }
        }

        return $files;

    }

    public function downloadLastProductFile()
    {
        $files = $this->getDirContents();

        if( !empty($files) ) {
            return response()->download(storage_path("app/public/product-import/{$files[0]}/{$files[0]}"));
        } else {
            return redirect( 'other/excelupload' )->with([ 'success' => false,
                'success.message'=> 'No File to download!',
                'success.title' => 'Warning!' ]);
        }

    }

    public function downloadSampleProductFile()
    {

        return response()->download(storage_path("app/public/sample/PrestoProductsImport.xlsx"));

    }

    public function saveExcelData(Request $request)
    {
        
        ini_set('memory_limit', '2048M');

        $this->validate($request, array(
            'csv_file'      => 'required'
        ));

        DB::beginTransaction();

        try {

            $requiredFlds = [
                'productbrandid' => 'ProductBrandID',
                'name' => 'Name',
                // 'slug' => 'Slug',
                'description' => 'Description',
                // 'promotionable' => 'Promotionable',
                // 'availableon' => 'AvailableOn',
                // 'discontinueon' => 'DiscontinueOn',
                'groupid' => 'groupId',
                'sku' => 'SKU',
                'productcode' => 'ProductCode',
                // 'barcode' => 'Barcode',
                // 'weight' => 'Weight',
                // 'height' => 'Height',
                // 'width' => 'Width',
                // 'depth' => 'Depth',
                // 'ismaster' => 'isMaster',
                // 'costprice' => 'CostPrice',
                // 'costcurrency' => 'CostCurrency',
                // 'marketprice' => 'MarketPrice',
                'saleprice' => 'SalePrice'
            ];

            $rejectList = [];

            if ($request->hasFile('csv_file')) {

                $excel_data = $request->file('csv_file');
                $extension = $excel_data->getClientOriginalExtension();

                if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                    $path = $excel_data->getRealPath();
                    $data = Excel::load($path, function ($reader) {
                        $reader->ignoreEmpty();
                    })->get();

                    if (!empty($data) && $data->count()) {

                        // Store file in storage/app/public/product-import
                        // $new_filename = date('YmdHis') . '_' . $excel_data->getClientOriginalName();

                        // Storage::disk('public')->putFileAs(
                        //     'product-import/' . $new_filename,
                        //     $excel_data,
                        //     $new_filename
                        // );

                        $product_brand = "";
                        $product_name = "";
                        $product_slug = "";
                        $product_description = "";
                        $product_promotionable = "";
                        $product_availableon = "";
                        $product_discontinueon = "";
                        $group_id = "";
                        $previous_group_id = "";
                        $previous_product_id = "";
                        $product_option_list = "";
                        $delivery_type = "";



                        foreach ($data as $key => $value) {
                            if ($value->id) {
                                $continue = false;
                                // Validate required fields
                                foreach ($requiredFlds as $requiredKey => $requiredFld) {
                                    if ($value->$requiredKey == '') {
                                        $continue = true;
                                        $rejectList[$value->id][] = $requiredFld;
                                    }
                                }


                                if ($continue) {
                                    continue;
                                }
                               
                                $product_brand = $value->productbrandid;
                                $product_name = $value->name;
                                $product_slug = $value->slug;
                                $product_description = $value->description;
                                $product_promotionable = $value->promotionable;
                                $product_availableon = $value->availableon;
                                $product_discontinueon = $value->discontinueon;
                                $group_id = $value->groupid;

                                $check_brand1 = ProductBrandModule::where('name', $product_brand)->first();
                                if (empty($check_brand1)) {
                                    $brands = ProductBrandModule::create([
                                        'name' => $product_brand,
                                        'slug' => $product_brand,
                                        'isFeatured' => 1,
                                        'createdById' => Sentinel::getUser()->id,
                                        'status' => STATUS_ACTIVE
                                    ]);
                                }

                                $check_brand = ProductBrandModule::where('name', $product_brand)->first();

                                if (empty($check_brand)) {
                                    // return "empty";
                                } else {
                                    if ($previous_group_id != $group_id) {
                                        $product_brandid = $check_brand->id;
                                        $product_add = ProductModule::create([
                                            "productBrandId" => $product_brandid,
                                            "name" => $product_name,
                                            "slug" => $product_slug,
                                            "description" => $product_description,
                                            "promotionable" => $product_promotionable,
                                            "availableOn" => $product_availableon,
                                            "discontinueOn" => $product_discontinueon,
                                            "createdById" => Sentinel::getUser()->id,
                                            "status" => STATUS_ACTIVE
                                        ]);
                                        $previous_group_id = $group_id;
                                        $product_id = $product_add->id;
                                        $previous_product_id = $product_add->id;

                                        /** Product Attribute **/

                                        $attribute_list = $value->otherattributes;
                                        if ($attribute_list != "") {
                                            $attribute_list_ar = explode("/", $attribute_list);
                                            foreach ($attribute_list_ar as $key => $value_attribute) {
                                                if (strpos($value_attribute, '=') == true) {
                                                    $attribute_ar = explode("=", $value_attribute);
                                                    $attribute = $attribute_ar[0];
                                                    $attribute_value = $attribute_ar[1];

                                                    $check_attribute = ProductAttributeModule::where('displayName', $attribute)->get();
                                                    if (sizeof($check_attribute) > 0) {
                                                        $attribute_id = $check_attribute[0]->id;
                                                    } else {
                                                        $new_attribute = ProductAttributeModule::create([
                                                            "name" => $attribute,
                                                            "displayName" => $attribute,
                                                            "status" => STATUS_ACTIVE,
                                                            "createdById" => Sentinel::getUser()->id
                                                        ]);
                                                        $attribute_id = $new_attribute->id;
                                                    }

                                                    $product_produuct_attribute = ProductProductAttribute::create([
                                                        "productId" => $product_id,
                                                        "productAttributeId" => $attribute_id,
                                                        "value" => $attribute_value,
                                                        "status" => STATUS_ACTIVE,
                                                        "createdById" => Sentinel::getUser()->id
                                                    ]);
                                                }
                                            }
                                        }

                                        /************************** Product Category **********************************/

                                        $category_list = $value->productcategories;
                                        $category_list_ar = explode("/", $category_list);

                                        foreach ($category_list_ar as $key => $value_category) {
                                            $check_category = ProductCategoryModule::where('name', $value_category)->get();

                                            if (sizeof($check_category) > 0) {
                                                $category_ar = ProductProductCategory::create([
                                                    "productId" => $product_id,
                                                    "productCategoryId" => $check_category[0]->id,
                                                    "status" => STATUS_ACTIVE,
                                                    "createdById" => Sentinel::getUser()->id
                                                ]);
                                            }
                                        }

                                        /************************** Product Delivery Type **********************************/

                                        $delivery_type = $value->deliverytypes;
                                        if ($delivery_type != "") {
                                            $delivery_type_list_ar = explode("/", $delivery_type);
                                            foreach ($delivery_type_list_ar as $key => $value_delivery_type) {

                                                $get_delivery_type = DeliveryType::where('name', $value_delivery_type)->first();

                                                if (!empty($get_delivery_type) > 0) {
                                                    $delivery_type_id = $get_delivery_type->id;
                                                    $product_delivery_type = ProductDeliveryType::create([
                                                        "productId" => $product_id,
                                                        "deliveryTypeId" => $delivery_type_id,
                                                        "status" => STATUS_ACTIVE
                                                    ]);
                                                }
                                            }
                                        }

                                    } else {
                                        $product_id = $previous_product_id;
                                    }

                                    /************************** Product Variant **********************************/

                                    $sku = $value->sku;
                                    $merchantSku = $value->productcode;
                                    $barcode = $value->barcode;
                                    $weight = $value->weight;
                                    $height = $value->height;
                                    $width = $value->width;
                                    $depth = $value->depth;
                                    $merchant = $value->merchantid;
                                    $isMaster = $value->ismaster;
                                    $cost_price = $value->costprice;
                                    $cost_currency = $value->costcurrency;
                                    $market_price = $value->marketprice;
                                    $sale_price = $value->saleprice;
                                    $image_1 = $value->imagename1;
                                    $image_2 = $value->imagename2;
                                    $image_3 = $value->imagename3;
                                    $image_4 = $value->imagename4;
                                    $warranty = $value->warranty;

                                    $check_merchant = MerchantModule::where('name', $merchant)->first();
                                    if (empty($check_merchant)) {
                                        $new_merchant = MerchantModule::create([
                                            'name' => $merchant,
                                            'createdById' => Sentinel::getUser()->id,
                                            'merchantTypeId' => 2,
                                            'status' => STATUS_ACTIVE
                                        ]);
                                        $merchant_id = $new_merchant->id;
                                    } else {
                                        $merchant_id = $check_merchant->id;
                                    }

                                    $product_variant = ProductVariant::create([
                                        "productId" => $product_id,
                                        "sku" => $sku,
                                        "merchantSku" => $merchantSku,
                                        "barcode" => $barcode,
                                        "weight" => $weight,
                                        "height" => $height,
                                        "width" => $width,
                                        "depth" => $depth,
                                        "isMaster" => $isMaster,
                                        "costPrice" => $cost_price,
                                        "merchantId" => $merchant_id,
                                        "costCurrency" => $cost_currency,
                                        "marketPrice" => $market_price,
                                        "salePrice" => $sale_price,
                                        "availableOn" => $product_availableon,
                                        "discontinueOn" => $product_discontinueon,
                                        "warranty" => $warranty,
                                        "status" => STATUS_ACTIVE
                                    ]);
                                    $product_variant_id = $product_variant->id;

                                    if ($image_1 != "") {
                                        $insert_image1 = ProductVariantImage::create([
                                            "productVariantId" => $product_variant_id,
                                            "imageName" => $product_id . "/" . $image_1,
                                            "status" => STATUS_ACTIVE,
                                            "createdById" => Sentinel::getUser()->id
                                        ]);
                                    }else{
                                        $insert_image1 = ProductVariantImage::create([
                                            "productVariantId" => $product_variant_id,
                                            "imageName" => "default/default.jpg",
                                            "status" => STATUS_ACTIVE,
                                            "createdById" => Sentinel::getUser()->id
                                        ]);
                                    }

                                    if ($image_2 != "") {
                                        $insert_image1 = ProductVariantImage::create([
                                            "productVariantId" => $product_variant_id,
                                            "imageName" => $product_id . "/" . $image_2,
                                            "status" => STATUS_ACTIVE,
                                            "createdById" => Sentinel::getUser()->id
                                        ]);
                                    }

                                    if ($image_3 != "") {
                                        $insert_image1 = ProductVariantImage::create([
                                            "productVariantId" => $product_variant_id,
                                            "imageName" => $product_id . "/" . $image_3,
                                            "status" => STATUS_ACTIVE,
                                            "createdById" => Sentinel::getUser()->id
                                        ]);
                                    }

                                    if ($image_4 != "") {
                                        $insert_image1 = ProductVariantImage::create([
                                            "productVariantId" => $product_variant_id,
                                            "imageName" => $product_id . "/" . $image_4,
                                            "status" => STATUS_ACTIVE,
                                            "createdById" => Sentinel::getUser()->id
                                        ]);
                                    }

                                    /************************** Product Tags **********************************/
                                    $product_tags = $value->customtags;
                                    if ($product_tags != "") {
                                        $product_tags_list_ar = explode("/", $product_tags);
                                        foreach ($product_tags_list_ar as $key => $value) {
                                            $Product_tag = ProductTag::create([
                                                "productId" => $product_id,
                                                "productVariantId" => $product_variant_id,
                                                "tagId" => $value,
                                                "status" => STATUS_ACTIVE,
                                                "createdById" => Sentinel::getUser()->id
                                            ]);
                                        }
                                    }


                                    /************************** Product Option **********************************/
                                    $product_option_list = $value->otheroptions;

                                    if ($product_option_list != "") {
                                        $product_option_list_ar = explode("/", $product_option_list);
                                        foreach ($product_option_list_ar as $key => $value_product_option) {
                                            $product_option_ar = explode("=", $value_product_option);
                                            $product_option = $product_option_ar[0];
                                            $product_option_value = $product_option_ar[1];

                                            $check_product_option = ProductOptionModule::where('name', $product_option)->get();
                                            if (sizeof($check_product_option) > 0) {
                                                $product_option_id = $check_product_option[0]->id;
                                            } else {
                                                $new_product_option = ProductOptionModule::create([
                                                    "name" => $product_option,
                                                    "displayName" => $product_option,
                                                    "status" => STATUS_ACTIVE,
                                                    "createdById" => Sentinel::getUser()->id
                                                ]);
                                                $product_option_id = $new_product_option->id;
                                            }

                                            $check_product_product_option = ProductProductOption::where('productId', $product_id)
                                                ->where('productOptionId', $product_option_id)
                                                ->get();
                                            if (sizeof($check_product_product_option) == 0) {
                                                $new_product_product_option = ProductProductOption::create([
                                                    "productId" => $product_id,
                                                    "productOptionId" => $product_option_id,
                                                    "status" => STATUS_ACTIVE,
                                                    "createdById" => Sentinel::getUser()->id
                                                ]);
                                            }

                                            $check_product_option_value = ProductOptionValueModule::where('productOptionId', $product_option_id)
                                                ->where('name', $product_option_value)
                                                ->get();
                                            if (sizeof($check_product_option_value) > 0) {
                                                $product_option_value_id = $check_product_option_value[0]->id;
                                            } else {
                                                $new_product_option_value = ProductOptionValueModule::create([
                                                    "productOptionId" => $product_option_id,
                                                    "name" => $product_option_value,
                                                    "displayName" => $product_option_value,
                                                    "status" => STATUS_ACTIVE,
                                                    "createdById" => Sentinel::getUser()->id
                                                ]);
                                                $product_option_value_id = $new_product_option_value->id;
                                            }

                                            $check_product_variant_product_option_value = ProductVariantProductOptionValue::where('productVariantId', $product_variant_id)
                                                ->where('productOptionValueId', $product_option_value_id)
                                                ->get();
                                            if (sizeof($check_product_variant_product_option_value) == 0) {
                                                ProductVariantProductOptionValue::create([
                                                    "productVariantId" => $product_variant_id,
                                                    "productOptionValueId" => $product_option_value_id,
                                                    "status" => STATUS_ACTIVE,
                                                    "createdById" => Sentinel::getUser()->id
                                                ]);
                                            }

                                        }
                                    }

                                    /************************** Product Warehouse Stock *******************************/

                                    $warehouse = $value->warehouseid;
                                    $warehouseStock = $value->stockonhand;

                                    if ($warehouseStock == "") {
                                        $warehouseStock = 0;
                                    }
                                    $warehouse_stock = WarehouseItem::create([
                                        "warehouseId" => $warehouse,
                                        "productVariantId" => $product_variant_id,
                                        "merchantId" => $merchant_id,
                                        "stockOnHand" => $warehouseStock,
                                        "status" => STATUS_ACTIVE
                                    ]);
                                    
                                }
                            }
                        }
                        DB::commit();
                        $response = [
                            'error' => false,
                            'message' => 'Product import process has been successfully completed',
                            'data' => $rejectList
                        ];
                    } else {
                        DB::rollback();
                        $response = [
                            'error' => true,
                            'message' => 'Data file empty'
                        ];
                    }
                } else {
                    DB::rollback();
                    $response = [
                        'error' => true,
                        'message' => 'Invalid file extension'
                    ];
                }
            } else {
                DB::rollback();
                $response = [
                    'error' => true,
                    'message' => 'Data file not selected'
                ];
            }
        } catch (\Exception $ex){
            DB::rollback();
            $response = [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
        
        return view('ExtraModule::excelUpload',compact('response'));

    }

}
