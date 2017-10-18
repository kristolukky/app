<?php

namespace MVC\Controllers;

use MVC\Models\Warehouse;
use System\Controller;
use System\Database\Connection;
use System\ORM\Criteria;
use System\ORM\Repository;

class Home extends Controller
{

    public function indexAction()
    {

        if (isset($_POST) && !empty($_FILES["file"])) {

            //if there was an error uploading the file
            if ($_FILES["file"]["error"] > 0) {
                $this->getView()->assign('error', "Return Code: " . $_FILES["file"]["error"]);
            } else {
                //Store file in directory "upload"
                $pathToFile = $_FILES['file']['tmp_name'];

                //open and parse file
                $file = fopen($pathToFile, 'r');
                if ($file) {
                    //$rows = array();
                    $header = false;
                    while (($data = fgetcsv($file, 0, ",")) != FALSE) {
                        $WHs = [];

                        if (false === $header) {
                            $header = $data;
                        } else {
                            $repo = new Repository(Warehouse::class);

                            /** @var Warehouse $product */
                            $product = $repo->findOneBy(['productName' => $data[0]]);


                            $qty = (int)$data[1];
                            if ($product === null) {

                                $product = new Warehouse();
                                $product->setProductName($data[0]);

                                if ($qty > 0) {
                                    $product->setQuantity($qty);

                                    $WHs[$data[2]] = $qty;

                                    $product->setWH($WHs);

                                }

                                $repo->save($product);

                            } else {
                                $qtyIsset = (int)$product->getQuantity();

                                $qtyWT = $product->getWH();

                                if ($qty > 0 || $qtyIsset > 0) {

                                    $qtyIsset = $qtyIsset + $qty;

                                    $product->setQuantity($qtyIsset);

                                    foreach ($qtyWT as $keyWarehouse=>$qtyWarehouse){
                                        if(isset($qtyWT[$keyWarehouse])){
                                            $qtyWT[$keyWarehouse] = $qtyWarehouse + $qty;
                                        }else{
                                            $qtyWT[$keyWarehouse] = $qtyWarehouse;
                                        }
                                        $product->setWH($qtyWT);
                                    }

                                }
                                $repo->save($product, 'name', $data[0]);
                            }
                        }
                    }

                    fclose($file);
                    unset($_POST);
                    unset($_FILES);
                    $this->forward('');
                } else {
                    $this->getView()->assign('error', "No file selected");
                }
            }

        } else {
            $repo = new Repository(Warehouse::class);
            $products = $repo->findBy(['quantity' => 0], '>');

            if ($products == null) {
                $this->getView()->assign('errorProducts', 'No products in warehouses');
            } else {

                foreach ($products as $key=>$product){
                    $whs=[];
                    $wh = $product->getWH();
                    $whs[] = array_keys($wh);
                    $whsCodes = implode(',', $whs[0]);
                    $product->whsCodes = $whsCodes;

                }

                $this->getView()->assign('products', $products);
            }
            $this->getView()->view('home/index');
        }
    }

}