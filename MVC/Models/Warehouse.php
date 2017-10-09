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
   * @var int
   * @column(WH1)
   */
  private $WH1;

    /**
     * @var int
     * @column(WH2)
     */
  private $WH2;


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
  public function getWH1()
  {
    return (int)$this->WH1;
  }

    /**
     * @return int|null
     */
  public function getWH2()
  {
      return (int)$this->WH2;
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
   * @param int $WH1
   * @return int
   */
  public function setWH1($WH1)
  {
    $this->WH1 = $WH1;
  }

    /**
     * @param int $WH2
     * @return int
     */
    public function setWH2($WH2)
    {
        $this->WH2 = $WH2;
    }
}
