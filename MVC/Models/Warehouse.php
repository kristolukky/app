<?php

namespace MVC\Models;

/**
 * Class Warehouse
 * @package MVC\Models
 * @table(warehouses)
 */
class Warehouse
{

  /**
   * @var int
   * @column(id)
   */
  private $id;

  /**
   * @var string
   * @column(name)
   */
  private $productName;

  /**
   * @var int
     * @column(quantity)
   */
  private $quantity;

  /**
   * @var string
   * @column(WH)
   */
  private $WH;


  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getProductName()
  {
    return $this->productName;
  }

  /**
   * @return int
   */
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * @return int|null
   */
  public function getWH()
  {
    return json_decode($this->WH, true);
  }
  

  /**
   * @param string $productName
   */
  public function setProductName($productName)
  {
    $this->productName = $productName;
  }

  /**
   * @param int $quantity
   */
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;
  }

  /**
   * @param string $WH
   * @return string
   */
  public function setWH($WH)
  {
    $this->WH = json_encode($WH);
  }

  /**
   * @param array $codewarehouses
   * @return string
   */
  public function getWHString($codewarehouses)
  {
    return implode(',', $codewarehouses);
  }
  
}
