<?php



class ProductControll extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('product_model');
        $this->load->helper('url');        
    }

    function webhook(){

        $a=$this->input->get("mani");
        $b=$this->input->get("session");
        $this->product_model->toCheck($a);
        $this->product_model->toCheck($b);

        $response = array("name"=>"mani");
        $response=json_encode($response, JSON_PRETTY_PRINT);
        
        print_r($response);
        
        
    }

    public function fetchGeneralProducts() {
        
        // Get min and max price from GET parameters
        $minPrice = $this->input->get('min');
        $maxPrice = $this->input->get('max');
        
        // Get category from GET parameter
        $category = $this->input->get('category');

        // Fetch products based on price range and category
        $products = $this->product_model->getProductsByPriceAndCategory($minPrice, $maxPrice, $category);

        // Assuming $products is the array fetched from the database
        $formattedData = array('elements' => array());

        foreach ($products as $product) {
            $formattedData['elements'][] = array(
                'title' => $product['pname']." ₹".$product['price'],
                'subtitle' => $product['description'],
                'id' => $product['pid'],
                'image' => base_url() . $product['image'],
                "actions" => array()
                
            );
        }

        $response=json_encode($formattedData, JSON_PRETTY_PRINT);
        
        print_r($response);
            
    }

    function fetchloginproducts(){
        $minPrice = $this->input->get('min');
        $maxPrice = $this->input->get('max');
        
        // Get category from GET parameter
        $category = $this->input->get('category');

        // Fetch products based on price range and category
        $products = $this->product_model->getProductsByPriceAndCategory($minPrice, $maxPrice, $category);

        // Assuming $products is the array fetched from the database
        $formattedData = array('elements' => array());

        foreach ($products as $product) {
            $formattedData['elements'][] = array(
                'title' => $product['pname']." ₹".$product['price'],
                'subtitle' => $product['description'],
                'id' => $product['pid'],
                'image' => base_url() . $product['image'],
                "actions" => array(
                    array(
                    "label" => "Add to Cart",
                    "name" => "addToCart",
                    
                ),
                array(
                    "label" => "Buy Now",
                    "name" => "buyNow",
                    
                )
                )
                
            );
        }

        $response=json_encode($formattedData, JSON_PRETTY_PRINT);
        
        print_r($response);

    }

    public function getTodayOfferGeneral() {

        // Assuming you have a function in your model to get today's offer products
        $todayOfferProducts = $this->product_model->getProductsByOffer();

        
        // Format the data as specified in the question
        $formattedData['elements'] = array();

        foreach ($todayOfferProducts as $product) {
            $formattedData['elements'][] = array(
                "title" => $product['pname']." ₹".$product['price'],
                "subtitle" => $product['description'],
                "id" => $product['pid'],
                "image" => base_url().$product['image'],
                "actions" => array()
                
            );

        }
        
        // Store the formatted data in a variable
        $formattedProducts = json_encode($formattedData, JSON_PRETTY_PRINT);
        
        print_r($formattedProducts);
        
    }


    public function addToCart() {
        // Get product ID and user ID from GET parameters
        $pid = $this->input->get('pid');
        $uid = $this->input->get('uid');

        // Validate product ID and user ID
        if (!empty($pid) && !empty($uid)) {
            // Call the addToCart method from the Product_model
            $this->product_model->addToCart($uid, $pid);

            // Respond with success or any other relevant information
            echo '1';
        }
    }

    public function processCheckout() {
        // Get UID from the session or any other method
        $uid = 4; // Assuming UID is passed through GET
        
        $this->load->model('product_model');
        
        $this->product_model->updateTrackAndOrders($uid);
        
        // Redirect or do anything else after checkout
        // Redirect to a thank you page or any other page
    }

    public function cartDetails() {
        // Get user ID from GET parameter
        $uid = $this->input->get('uid');
    
        // Validate user ID
        if (!empty($uid)) {
            // Call the getCartDetails method from the Product_model
            $cartDetails = $this->product_model->getCartDetails($uid);
    
            // Format the data as specified
            $formattedData['elements'] = array();
    
            foreach ($cartDetails as $product) {
                $formattedData['elements'][] = array(
                    "title" => $product['pname'],
                    "subtitle" => $product['description'],
                    "id" => $product['pid'],
                    "image" => base_url() . $product['image'],
                    "actions" => array()
                    // You can add more actions if needed
                );
            }

            $totalCost = $this->product_model->getTotalCartCost($uid);
            
            $result = array("total" => $totalCost,
                        "products" => $formattedData);
            // Store the formatted data in a variable
            $formattedProducts = json_encode($result, JSON_PRETTY_PRINT);
    
            // Respond with the formatted data
            echo $formattedProducts;
        } 
    }


    public function getProductDetails() {

        $pid=$this->input->get('pid');
        // Get product details for the specified product ID
        $productDetails = $this->product_model->getProductDetails($pid);
    
        // Format the data as specified
        $formattedData['elements'] = array();
    
        foreach ($productDetails as $product) {
            $formattedData['elements'][] = array(
                "title" => $product['pname'],
                "subtitle" => $product['description'],
                "id" => $product['pid'],
                "image" => base_url() . $product['image'],
                "actions" => array()
                // You can add more actions if needed
            );
        }

        $formattedData = array("cost" => $product['price'],
                                "product" => $formattedData);
    
        // Respond with the formatted data
        echo json_encode($formattedData, JSON_PRETTY_PRINT);
    }


    public function clearCartItems() {
        // Get user ID from GET parameter
        $uid = $this->input->get('uid');        
        $isCleared = $this->product_model->clearCart($uid);
    
    }


    public function getOrderDetails() {
        $tid=$this->input->get('tid');
     

        // Get product details by tid from the model
        $products = $this->product_model->getProductsByTid($tid);

        // Format the data as specified
        $formattedData['elements'] = array();

        foreach ($products as $product) {
            $formattedData['elements'][] = array(
                "title" => $product['pname']." ₹".$product['price'],
                "subtitle" => $product['description'],
                "id" => $product['pid'],
                "image" => base_url().$product['image'],
                "actions" => array()
            );
        }

        // Convert the formatted data to JSON
        $formattedProducts = json_encode(array("products" => $formattedData), JSON_PRETTY_PRINT);

        // Optionally, you can echo or return the formatted data
        echo $formattedProducts;
        // return $formattedProducts;
    }



    public function displayTidOptions() {
        // Get the uid from the GET method
        $uid = $this->input->get('uid');

        // Call the function in the model to get tid options by uid
        $tidOptions = $this->product_model->getTidOptionsByUid($uid);

        // Format the data as specified
        // $formattedData = array(
        //     "options" => array(
        //         "value" => array(),
        //         "meta" => array(
        //             "type" => "optionlist",
        //             "value" => array()
        //         )
        //     )
        // );

        foreach ($tidOptions as $option) {
            $formattedData[] = array(
                "text" => "Timestamp: " . $option['orderedOn'] . " - TID: " . $option['tid'],
                "id" => $option['tid']
            );

            // $formattedData['options']['meta']['value'][] = array(
            //     "text" => "Timestamp: " . $option['orderedOn'] . " - TID: " . $option['tid'],
            //     "id" => $option['tid']
            // );
        }

        // Convert the formatted data to JSON
        $formattedOptions = json_encode(array("tracks" => $formattedData), JSON_PRETTY_PRINT);

        // Optionally, you can echo or return the formatted data
        echo $formattedOptions;
        // return $formattedOptions;
    }

}
?>