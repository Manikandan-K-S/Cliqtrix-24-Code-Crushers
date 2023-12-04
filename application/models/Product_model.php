<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    
    public function saveProduct($pname, $price, $description, $image_path, $deliverytime,$category) {
        
        $data = array(
            'pname' => $pname,
            'price' => $price,
            'description' => $description,
            'image' => $image_path,
            'deliverytime' => $deliverytime,
            "category" => $category
        );

        $this->db->insert('product', $data);
    }

    // Function in Product_model to get details for a specific product
    public function getProductDetails($pid) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('pid', $pid);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function clearCart($uid) {
        // Delete all cart items for the specified user
        $this->db->where('uid', $uid);
        $this->db->delete('cart');
    
        return true; // Return true indicating success (you can customize this based on your needs)
    }

    

    public function getTotalCartCost($uid) {
        $this->db->select_sum('(product.price * cart.qty)', 'total_cost');
        $this->db->from('cart');
        $this->db->join('product', 'cart.pid = product.pid');
        $this->db->where('cart.uid', $uid);
    
        $query = $this->db->get();
        $result = $query->row();
    
        return $result ? $result->total_cost : 0;
    }


    public function getProductsByOffer() {
        // Assuming 'product' is the table name and 'offer' is the boolean column
        $this->db->select('pid, pname, price, description, image, deliverytime');
        $this->db->from('product');
        $this->db->where('offer', 1); // Filter products with offer (1)

        $query = $this->db->get();

        // Check if the query was successful
        if ($query->num_rows() > 0) {
            // Return the result as an array
            return $query->result_array();
        } else {
            // Return an empty array if no result is found
            return array();
        }
    }

    public function toCheck($funcName){

        $this->db->insert('sample', array("function" => $funcName));

    }


    public function getProductsByPriceAndCategory($minPrice, $maxPrice, $category) {
        // Query the product table to fetch products within the price range and category
        $query = $this->db->select('*')
                          ->from('product')
                          ->where('price >=', $minPrice)
                          ->where('price <=', $maxPrice)
                          ->where('category', $category)
                          ->get();

        // Return the result as an array of products
        return $query->result_array();
    }


    public function addToCart($uid, $pid) {
        // Check if the product is already in the cart for the user
        $existingCartItem = $this->db->get_where('cart', array('pid' => $pid, 'uid' => $uid))->row();

        if ($existingCartItem) {
            // Product already in the cart, increase quantity
            $this->db->where('pid', $pid);
            $this->db->where('uid', $uid);
            $this->db->set('qty', 'qty+1', FALSE);
            $this->db->update('cart');
        } else {
            // Product not in the cart, add it
            $data = array(
                'uid' => $uid,
                'pid' => $pid,
                'qty' => 1 // You can set the initial quantity as needed
            );
            $this->db->insert('cart', $data);
        }
    }


    public function getCartDetails($uid) {
        // Get product details for the specified user's cart
        $this->db->select('product.*, cart.qty');
        $this->db->from('cart');
        $this->db->join('product', 'cart.pid = product.pid');
        $this->db->where('uid', $uid);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function updateTrackAndOrders($uid) {
        // Retrieve product IDs from the cart table
        $this->db->select('pid');
        $this->db->where('uid', $uid);
        $query = $this->db->get('cart');
        
        // Check if there are cart items
        if ($query->num_rows() > 0) {
            // Insert into track table
            $track_data = array(
                'uid' => $uid,
                // Add other track data as needed
            );
            $this->db->insert('track', $track_data);
            
            // Get the inserted tid
            $tid = $this->db->insert_id();
            
            $cart_products = $query->result_array();
            
            foreach ($cart_products as $cart_product) {
                $product_id = $cart_product['pid'];
                
                // Insert into orders table
                $cart_data = array(
                    'tid' => $tid,
                    'pid' => $product_id,
                    // Add other cart data as needed
                );
                $this->db->insert('orders', $cart_data);
            }
            
            // Clear the user's cart
            $this->db->where('uid', $uid);
            $this->db->delete('cart');
            
            // You can add any other post-checkout logic here
        }
    }


    public function getProductsByTid($tid) {
        // Assuming you have a function to get products by tid from orders table
        $this->db->select('product.*');
        $this->db->from('orders');
        $this->db->join('product', 'product.pid = orders.pid');
        $this->db->where('orders.tid', $tid);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTidOptionsByUid($uid) {
        // Assuming 'track' is your table name
        $this->db->select('tid, orderedOn');
        $this->db->where('uid', $uid);
        $query = $this->db->get('track');

        return $query->result_array();
    }


}
