<?php

/**
 * @Author: Thisaru
 * @Date:   2018-10-01 11:21:20
 * @Last Modified by:   thisaruwith
 * @Last Modified time: 2019-03-12 12:31:28
 */
namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Validator;
use App\Classes\Functions;
use Illuminate\Http\Request;
use App\Modules\OrderModule\Models\OrderModule;
use Charts;
use Sentinel;
use DB;
use Hash;
use Auth;
use Route;
use Excel;
use Orchestra\Parser\Xml\Facade as XmlParser;

class WelcomeController extends Controller {


    public function __construct(){
        
    }
	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        return view('dashboard');
	}

    public function sampleXml(Request $request)
    {
        // return view('test');

		// $xml = XmlParser::load('/Applications/MAMP/htdocs/book1.xml');
        // return $order = $xml->parse([
		// 	'orderId' => ['uses' => 'Orders.Order'],
		// 	'docType' => ['uses' => 'Orders.DocType'],
		// 	'action'  => ['uses' => 'Orders.Action'],
		// 	'soldTo'  => ['uses' =>  'Orders.SoldTo[ID,Name,Name2,Street,Street2,City,State,PostalCode,Country,Phone1,Phone2]'],
		// 	'shipTo'  => ['uses' => 'Orders.ShipTo[ID,Name,Street,City,State,PostalCode,Country]'],
		// 	'goodsSupplier' => ['uses' => 'Orders.GoodsSupplier[ID,Name,Name2,Street,Street2,City,State,PostalCode,Country,Phone1,Phone2]'],
		// 	'vendor'  => ['uses' => 'Orders.Vendor[ID,Name]'],
		// 	'poDateType'  => ['uses' => 'Orders.DateTime.Date::DateQualifier'],
		// 	'poDate'  => ['uses' => 'Orders.DateTime.Date(::DateQualifier=@PODate)'],
		// 	'messageID'  => ['uses' => 'Orders.MessageID'],
		// 	'purchasingOrg'  => ['uses' => 'Orders.PurchasingOrg'],
		// 	'purchasingOrgDesc'  => ['uses' => 'Orders.PurchasingOrgDesc'],
		// 	'companyCode'  => ['uses' => 'Orders.CompanyCode'],
		// 	'companyCodeDesc'  => ['uses' => 'Orders.CompanyCodeDesc'],
		// 	'purchasingGroup'  => ['uses' => 'Orders.PurchasingGroup'],
		// 	'purchasingGroupDesc'  => ['uses' => 'Orders.PurchasingGroupDesc'],
		// 	'orderDetails'  => ['uses' => 'Orders.OrderDetails[LineNum,Action,IncoTerm1_LN,IncoTerm2_LN,SKU,VariantArticle,ArticleDescription,StyleDescription,UPC,Qty.Quantity,DateTime.Date::DateQualifier,DateTime.Date,CustomerSoldTo.ID,CustomerSoldTo.Name,CustomerSoldTo.Country,CustomerPO,CustomerSalesOrder,CommodityCode,CommodityCodeDesc.Text,FabricContent.Text,ShippingInstructions,ShippingInstDesc,CountryOfOrigin,Quality,Kit,AccountGroup,Channel,TechPack,ArticleAttributes.Code]'],
            
		// ]);		

		$xmlNode = simplexml_load_file('/Applications/MAMP/htdocs/book1.xml');
		//$xmlNode = XmlParser::load('/Applications/MAMP/htdocs/book1.xml');
		$arrayData = $this->xmlToArray($xmlNode);
		$json = json_encode($arrayData);

		$data = OrderModule::create([
					'json' => $json,
					'status' => 1
				]);
		echo json_encode($data);		
			
    }
	

	public function xmlToArray($xml, $options = array()) {
		$defaults = array(
			'namespaceSeparator' => ':',//you may want this to be something other than a colon
			'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
			'alwaysArray' => array(),   //array of xml tag names which should always become arrays
			'autoArray' => true,        //only create arrays for tags which appear more than once
			'textContent' => '$',       //key used for the text content of elements
			'autoText' => true,         //skip textContent key if node has no attributes or child nodes
			'keySearch' => false,       //optional search and replace on tag and attribute names
			'keyReplace' => false       //replace values for above search values (as passed to str_replace())
		);
		$options = array_merge($defaults, $options);
		$namespaces = $xml->getDocNamespaces();
		$namespaces[''] = null; //add base (empty) namespace
	 
		//get attributes from all namespaces
		$attributesArray = array();
		foreach ($namespaces as $prefix => $namespace) {
			foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
				//replace characters in attribute name
				if ($options['keySearch']) $attributeName =
						str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
				$attributeKey = $options['attributePrefix']
						. ($prefix ? $prefix . $options['namespaceSeparator'] : '')
						. $attributeName;
				$attributesArray[$attributeKey] = (string)$attribute;
			}
		}
	 
		//get child nodes from all namespaces
		$tagsArray = array();
		foreach ($namespaces as $prefix => $namespace) {
			foreach ($xml->children($namespace) as $childXml) {
				//recurse into child nodes
				$childArray = $this->xmlToArray($childXml, $options);
				// while(list($childTagName, $childProperties) = each($childArray)){
				foreach($childArray as $childTagName => $childProperties){	
	 
					//replace characters in tag name
					if ($options['keySearch']) $childTagName =
							str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
					//add namespace prefix, if any
					if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
		
					if (!isset($tagsArray[$childTagName])) {
						//only entry with this key
						//test if tags of this type should always be arrays, no matter the element count
						$tagsArray[$childTagName] =
								in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
								? array($childProperties) : $childProperties;
					} elseif (
						is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
						=== range(0, count($tagsArray[$childTagName]) - 1)
					) {
						//key already exists and is integer indexed array
						$tagsArray[$childTagName][] = $childProperties;
					} else {
						//key exists so convert to integer indexed array with previous value in position 0
						$tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
					}
				}
			}
		}
	 
		//get text content of node
		$textContentArray = array();
		$plainText = trim((string)$xml);
		if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
	 
		//stick it all together
		$propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
				? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
	 
		//return node as array
		return array(
			$xml->getName() => $propertiesArray
		);
	}
}
