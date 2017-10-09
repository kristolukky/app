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
                        //var_dump($data);

                        if (false === $header) {
                            $header = $data;
                        } else {
                            //$rows[] = array_combine($header, $data);
                            $repo = new Repository(Warehouse::class);

                            /** @var Warehouse $product */
                            $product = $repo->findOneBy(['productName' => $data[0]]);
                            $qty = (int)$data[1];
                            if ($product === null) {

                                $product = new Warehouse();

                                $product->setProductName($data[0]);

                                if ($qty > 0) {
                                    $product->setQuantity($qty);

                                    if ($data[2] == 'WH1') {
                                        $product->setWH1($qty);
                                    }

                                    if ($data[2] == 'WH2') {
                                        $product->setWH2($qty);
                                    }
                                }

                                $repo->save($product);

                            } else {
                                $qtyIsset = (int)$product->getQuantity();
                                $qtyWT1 = (int)$product->getWH1();
                                $qtyWT2 = (int)$product->getWH2();

                                if ($qty > 0 || $qtyIsset > 0) {

                                    $qtyIsset = $qtyIsset + $qty;

                                    $product->setQuantity($qtyIsset);

                                    if ($data[2] == 'WH1') {
                                        $qtyWT1 = $qtyWT1 + $qty;
                                        $product->setWH1($qtyWT1);
                                    }

                                    if ($data[2] == 'WH2') {
                                        $qtyWT2 = $qtyWT2 + $qty;
                                        $product->setWH2($qtyWT2);
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
                $this->getView()->assign('products', $products);
            }
            $this->getView()->view('home/index');
        }
    }

}