<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('product_model'); // Load the product model
        $this->load->helper('form');
    }

    
    public function upload_form() {
        // Display the image upload form
        $this->load->view('products/upload_form');
    }

    public function do_upload() {
        // Handle image upload and product information
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
        $config['max_size'] = 2048; // 2MB max size
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('userfile')) {
            // Image uploaded successfully
            $data = $this->upload->data();
            $image_path = 'uploads/' . $data['file_name'];

            // Get other form data
            $pname = $this->input->post('pname');
            $price = $this->input->post('price');
            $description = $this->input->post('description');
            $deliverytime = 3;
            $category= 'tea';

            // Save product information to the database
            $this->product_model->saveProduct($pname, $price, $description, $image_path, $deliverytime,$category);

            // Display success message or redirect
            echo "Product uploaded successfully. Image path: " . $image_path;
        } else {
            // Image upload failed
            $error = $this->upload->display_errors();
            echo "Error uploading image: " . $error;
        }
    }

    public function getTodayOffer() {

        $this->load->helper('url');

        // Assuming you have a function in your model to get today's offer products
        $todayOfferProducts = $this->product_model->getProductsByOffer();

        $token=1;
        // Format the data as specified in the question
        $formattedData['elements'] = array();

        foreach ($todayOfferProducts as $product) {
            $formattedData['elements'][] = array(
                "title" => $product['pname'].' -₹'.$product['price'].'/',
                "subtitle" => $product['description'],
                "id" => $product['pid'],
                "image" => base_url().$product['image'],
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

        $formattedData['elements'][] = array(
            "title" => "Exit",
            "subtitle" => "Click on exit to see more option",
            "id" => 222,
            "image" => base_url()."uploads/exit.jpg",
            "actions" => array(
                array(
                "label" => "Exit",
                "name" => "Exit",
                
            )
            )
        );

        
        // Store the formatted data in a variable
        $formattedProducts = json_encode($formattedData, JSON_PRETTY_PRINT);
        
        print_r($formattedProducts);
        
    }

    function add(){
        
        $uid=$this->input->get('uid');
        $this->product_model->toCheck("Uid $uid");
        echo $uid;
    }
}
// public function getTodayOffer_copy() {
        
    //     $this->load->helper('url');

    //     // Assuming you have a function in your model to get today's offer products
    //     $todayOfferProducts = $this->product_model->getProductsByOffer();

        
    //     // Format the data as specified in the question
    //     $formattedData['elements'] = array();

    //     foreach ($todayOfferProducts as $product) {
    //         $formattedData['elements'][] = array(
    //             "title" => $product['pname'],
    //             "subtitle" => $product['description'],
    //             "id" => $product['pid'],
    //             "image" => base_url().$product['image'],
    //             "actions" => array(
    //                 array(
    //                     "label" => "Get Packages",
    //                     "name" => "getpackage"
    //                 ),
    //                 array(
    //                     "label" => "Customer Showcase",
    //                     "name" => "customershowcase"
    //                 )
    //             )
    //         );
    //     }
        
    //     // Store the formatted data in a variable
    //     $formattedProducts = json_encode($formattedData, JSON_PRETTY_PRINT);
        
    //     print_r($formattedProducts);
        
    // }