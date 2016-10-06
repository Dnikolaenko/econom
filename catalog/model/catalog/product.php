<?php
class ModelCatalogProduct extends Model {
    public function getProduct($product_id) {
        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' AND p.date_available <= NOW() AND p.status = '1'");

        return $query->row;
    }

    public function getProducts() {
        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' AND p.date_available <= NOW() AND p.status = '1'");

        return $query->rows;
    }

    public function getProductsByCategoryId($category_id, $sort = 'pd.name', $order = 'ASC', $start = 0, $limit = 20) {
        $sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' AND p2c.category_id = '" . (int)$category_id . "'";

        $sort_data = array(
            'pd.name',
            'p.price',
            'p.special',
            'rating'
        );

        if (in_array($sort, $sort_data)) {
            $sql .= " ORDER BY " . $sort;
        } else {
            // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
            //$sql .= " ORDER BY pd.name";
            $sql .= " ORDER BY p.sort_order, pd.name";
            // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
        }

        if ($order == 'DESC') {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if ($start < 0) {
            $start = 0;
        }

        $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductsByCategoryIdYml($category_id) {
        $query = $this->db->query("SELECT p.product_id,
                                    p.stock_status_id,
                                    case when po.option_price is not null then p.price + po.option_price else p.price end AS price,
                                    p.tax_class_id,
                                    p.image,
                                    p.shipping,
                                    pd.model,
                                    m.name AS manufacturer,
                                    p.serial_no,
                                    case when po.category_name is not null then concat(trim(pd.name),' - ',po.category_name) else trim(pd.name) end AS name,
                                    p.prepayment
                               FROM " . DB_PREFIX . "product p
                                    JOIN " . DB_PREFIX . "product_to_category p2c 
                                      ON (p.product_id = p2c.product_id)
                                    LEFT JOIN " . DB_PREFIX . "product_description pd
                                           ON (p.product_id = pd.product_id) 
                                    LEFT JOIN " . DB_PREFIX . "manufacturer m 
                                           ON (p.manufacturer_id = m.manufacturer_id) 
                                    LEFT JOIN (SELECT po.product_id,
                                                      trim(substr(povd.name, 1, instr(povd.name, '->')-1)) category_name,
                                                      case when prefix = '+' then max(pov.price) else 0 end option_price
                                                 FROM " . DB_PREFIX . "product_option po
                                                      JOIN " . DB_PREFIX . "product_to_category p2c2
                                                        ON (po.product_id = p2c2.product_id)
                                                      LEFT JOIN " . DB_PREFIX . "product_option_description pod
                                                             ON (po.product_id = pod.product_id AND po.product_option_id = pod.product_option_id)
                                                      LEFT JOIN " . DB_PREFIX . "product_option_value pov
                                                             ON (po.product_id = pov.product_id AND po.product_option_id = pov.product_option_id)
                                                      LEFT JOIN " . DB_PREFIX . "product_option_value_description povd
                                                             ON (pov.product_id = povd.product_id AND pov.product_option_value_id = povd.product_option_value_id)
                                                WHERE po.color_option = 1
                                                  AND pod.language_id = '" . (int)$this->language->getId() . "'
                                                  AND povd.language_id = '" . (int)$this->language->getId() . "'
                                                  AND pod.name = 'Обивка'
                                                  AND p2c2.category_id = '" . (int)$category_id . "'
                                                GROUP BY po.product_id, category_name) po
                                           ON (p.product_id = po.product_id)
                              WHERE p.status = '1'
                                AND p.date_available <= NOW()
                                AND pd.language_id = '" . (int)$this->language->getId() . "'
                                AND p2c.category_id = '" . (int)$category_id . "'
                              ORDER BY p.sort_order,
                                       pd.name"
        );

        return $query->rows;
    }

    public function getTotalProductsByCategoryId($category_id = 0) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$category_id . "'");

        return $query->row['total'];
    }

    public function getProductsByManufacturerId($manufacturer_id, $sort = 'pd.name', $order = 'ASC', $start = 0, $limit = 20) {
        $sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' AND m.manufacturer_id = '" . (int)$manufacturer_id. "'";

        $sort_data = array(
            'pd.name',
            'p.price',
            'rating'
        );

        if (in_array($sort, $sort_data)) {
            $sql .= " ORDER BY " . $sort;
        } else {
            $sql .= " ORDER BY pd.name";
        }

        if ($order == 'DESC') {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if ($start < 0) {
            $start = 0;
        }

        $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalProductsByManufacturerId($manufacturer_id = 0) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE status = '1' AND date_available <= NOW() AND manufacturer_id = '" . (int)$manufacturer_id . "'");

        return $query->row['total'];
    }

    public function getProductsByKeyword($keyword, $description = FALSE, $sort = 'pd.name', $order = 'ASC', $start = 0, $limit = 20)
    {
        $sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, m.manufacturer_id, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "'";

        if ($keyword) {
            if (!$description) {
                $sql .= " AND (pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.model LIKE '%" . $this->db->escape($keyword) . "%')";
            } else {
                $sql .= " AND (pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.model LIKE '%" . $this->db->escape($keyword) . "%' OR pd.description LIKE '%" . $this->db->escape($keyword) . "%')";
            }

            $sql .= " AND p.status = '1' AND p.date_available <= NOW()";

            $sort_data = array(
                'pd.name',
                'p.price',
                'rating'
            );

            if (in_array($sort, $sort_data)) {
                $sql .= " ORDER BY " . $sort;
            } else {
                $sql .= " ORDER BY pd.name";
            }

            if ($order == 'DESC') {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if ($start < 0) {
                $start = 0;
            }

            $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

            $query = $this->db->query($sql);

            return $query->rows;
        } else {
            return 0;
        }
    }
    
    public function getProductbyManuf($keyword, $description = FALSE, $manufactur, $sort = 'pd.name', $order = 'ASC', $start = 0, $limit = 20) {
        if ($keyword) {
            $sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, m.manufacturer_id, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "'";

            if (!$description) {
                $sql .= " AND (pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.model LIKE '%" . $this->db->escape($keyword) . "%')";
            } else {
                $sql .= " AND (pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.model LIKE '%" . $this->db->escape($keyword) . "%' OR pd.description LIKE '%" . $this->db->escape($keyword) . "%')";
            }

            if ($manufactur) {
                $sql .= " AND (m.manufacturer_id = " . $manufactur . ")";
            }

            $sql .= " AND p.status = '1' AND p.date_available <= NOW()";

            $sort_data = array(
                'pd.name',
                'p.price',
                'rating'
            );

            if (in_array($sort, $sort_data)) {
                $sql .= " ORDER BY " . $sort;
            } else {
                $sql .= " ORDER BY pd.name";
            }

            if ($order == 'DESC') {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if ($start < 0) {
                $start = 0;
            }

            $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

            $query = $this->db->query($sql);

            return $query->rows;
        } else {
            return 0;
        }
    }

    public function getTotalProductsByKeyword($keyword, $description = FALSE, $manufactur) {
        if ($keyword) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ". DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "'";

            if (!$description) {
                $sql .= " AND (pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.model LIKE '%" . $this->db->escape($keyword) . "%')";
            } else {
                $sql .= " AND (pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.model LIKE '%" . $this->db->escape($keyword) . "%' OR pd.description LIKE '%" . $this->db->escape($keyword) . "%')";
            }

            if ($manufactur) {
                $sql .= " AND (m.manufacturer_id = " . $manufactur . ")";
            }

            $sql .= " AND p.status = '1' AND p.date_available <= NOW()";

            $query = $this->db->query($sql);

            return $query->row['total'];
        } else {
            return 0;
        }
    }

    public function getLatestProducts($limit) {
        $product_data = $this->cache->get('product.latest.' . $this->language->getId() . '.' . $limit);

        if (!$product_data) {
            $query = $this->db->query("SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

            $product_data = $query->rows;

            $this->cache->set('product.latest.' . $this->language->getId() . '.' . $limit, $product_data);
        }

        return $product_data;
    }

    public function getBestSellerProducts($limit) {
        $product_data = $this->cache->get('product.bestseller.' . $this->language->getId() . '.' . $limit);

        if (!$product_data) {
            $product_data = array();

            $query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '0' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) {
                $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$result['product_id'] . "' AND p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->language->getId() . "'");

                if ($product_query->num_rows) {
                    $product_data[] = $product_query->row;
                }
            }

            $this->cache->set('product.bestseller.' . $this->language->getId() . '.' . $limit, $product_data);
        }

        return $product_data;
    }

    public function updateViewed($product_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = viewed + 1 WHERE product_id = '" . (int)$product_id . "'");
    }
// 100223 ALNAUA Site redesign Begin
// public function getProductOptions($product_id) {
//  $product_option_data = array();
//
//  $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
//
//  foreach ($product_option_query->rows as $product_option) {
//   $product_option_value_data = array();
//
//   $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order");
//
//   foreach ($product_option_value_query->rows as $product_option_value) {
//    $product_option_value_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' AND language_id = '" . (int)$this->language->getId() . "'");
//
//    $product_option_value_data[] = array(
//     'product_option_value_id' => $product_option_value['product_option_value_id'],
//     'name'                    => $product_option_value_description_query->row['name'],
//            'price'                   => $product_option_value['price'],
//                    // 100223 ALNAUA Site redesign Begin
//                    'color_id'                => $product_option_value['color_id'],
//                    // 100223 ALNAUA Site redesign End
//            'prefix'                  => $product_option_value['prefix']
//    );
//   }
//
//   $product_option_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' AND language_id = '" . (int)$this->language->getId() . "'");
//
//         $product_option_data[] = array(
//          'product_option_id' => $product_option['product_option_id'],
//    'name'              => $product_option_description_query->row['name'],
//    'option_value'      => $product_option_value_data,
//                // 100223 ALNAUA Site redesign Begin
//                'color_option'         => $product_option['color_option'],
//                // 100223 ALNAUA Site redesign End
//    'sort_order'        => $product_option['sort_order']
//         );
//       }
//
//  return $product_option_data;
// }

    public function getProductOptions($product_id) {
        $product_option_data = array();

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN " . DB_PREFIX . "product_option_description pod ON (po.product_option_id = pod.product_option_id) WHERE po.product_id = '" . (int)$product_id . "'  AND pod.language_id = '" . (int)$this->language->getId() . "' ORDER BY sort_order");

        foreach ($product_option_query->rows as $product_option) {
            $product_option_value_data = array();

            if ($product_option['color_option']) {
                $product_option_value_query = $this->db->query("SELECT pov.*, povd.* FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product_option_value_description povd ON (pov.product_option_value_id = povd.product_option_value_id) LEFT JOIN " . DB_PREFIX . "color c ON (pov.color_id = c.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND povd.language_id = '" . (int)$this->language->getId() . "' ORDER BY cc.sort_order, pov.sort_order");
            } else {
                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product_option_value_description povd ON (pov.product_option_value_id = povd.product_option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND povd.language_id = '" . (int)$this->language->getId() . "' ORDER BY sort_order");
            }

            foreach ($product_option_value_query->rows as $product_option_value) {

                $product_option_value_data[] = array(
                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                    'name'                    => $product_option_value['name'],
                    'price'                   => $product_option_value['price'],
                    'color_id'                => $product_option_value['color_id'],
                    'prefix'                  => $product_option_value['prefix']
                );
            }

            $product_option_data[] = array(
                'product_option_id' => $product_option['product_option_id'],
                'name'              => $product_option['name'],
                'option_value'      => $product_option_value_data,
                'color_option'      => $product_option['color_option'],
                'sort_order'        => $product_option['sort_order']
            );
        }

        return $product_option_data;
    }
// 100223 ALNAUA Site redesign End
    // (+) ALNAUA 091114 (START)
    public function getProductTechParams($product_id) {
        $product_techparam_data = array();

        $product_techparam_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_techparam_value ptv LEFT JOIN " . DB_PREFIX . "techparam t ON (t.techparam_id = ptv.techparam_id) WHERE ptv.product_id = '" . (int)$product_id . "' ORDER BY t.sort_order");

        foreach ($product_techparam_value_query->rows as $product_techparam_value) {
            $techparam_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "techparam t LEFT JOIN " . DB_PREFIX . "techparam_description td ON (t.techparam_id = td.techparam_id) WHERE t.techparam_id = '" . (int)$product_techparam_value['techparam_id'] . "' AND td.language_id = '" . (int)$this->language->getId() . "'");

            $meashurement_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "measurement_class mc WHERE mc.measurement_class_id = '" . (int)$product_techparam_value['measurement_class_id'] . "' AND mc.language_id = '" . (int)$this->language->getId() . "'");

            $product_techparam_data[] = array(
                'name' => $techparam_query->row['name'],
                'unit' => (isset($meashurement_class_query->row['unit']) ? $meashurement_class_query->row['unit'] : null),
                'value' => $product_techparam_value['value']
            );
        }

        return $product_techparam_data;
    }

    public function getRandomProducts($limit = 4) {

        //$product_data = array();

        // 100128 ALNAUA Product Banner Flag Begin
        //$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->language->getId() . "'ORDER BY RAND() LIMIT 1");
        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p.random_display = '1' AND pd.language_id = '" . (int)$this->language->getId() . "'ORDER BY RAND() LIMIT " . $limit);
        // 100128 ALNAUA Product Banner Flag End

        //if ($product_query->num_rows) {
        $product_data = $product_query->rows;
        //}
        return $product_data;
    }
// (+) ALNAUA 091114 (FINISH)

    public function getRandomBestSellerProducts($limit = 4, $order_top_limit = 16) {

        $product_query = $this->db->query("SELECT p.*, pd.*
                                       FROM (SELECT op.product_id,
                                                    SUM(op.quantity) AS total
                                               FROM " . DB_PREFIX . "order_product op 
                                                    LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)
                                              WHERE o.order_status_id > '0'
                                              GROUP BY op.product_id ORDER BY total DESC LIMIT " . $order_top_limit . "
                                             ) o
                                             JOIN " . DB_PREFIX . "product p ON (o.product_id = p.product_id)
                                             LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                                       WHERE p.status = '1'
                                         AND p.date_available <= NOW()
                                         AND pd.language_id = '" . (int)$this->language->getId() . "'
                                       ORDER BY RAND() LIMIT ". $limit);

        $product_data = $product_query->rows;

        return $product_data;
    }

    public function getProductImages($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

        return $query->rows;
    }

    public function getProductDiscount($product_id) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity = '1' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

        if ($query->num_rows) {
            return $query->row['price'];
        } else {
            return FALSE;
        }
    }

    public function getProductDiscounts($product_id) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

        return $query->rows;
    }

    public function getProductSpecial($product_id) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

        if ($query->num_rows) {
            return $query->row['price'];
        } else {
            return FALSE;
        }
    }

    public function getProductSpecials($sort = 'pd.name', $order = 'ASC', $start = 0, $limit = 20) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $sql = "SELECT *, pd.name AS name, p.price, (SELECT ps2.price FROM " . DB_PREFIX . "product_special ps2 WHERE p.product_id = ps2.product_id AND ps2.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps2.date_start = '0000-00-00' OR ps2.date_start < NOW()) AND (ps2.date_end = '0000-00-00' OR ps2.date_end > NOW())) ORDER BY ps2.priority ASC, ps2.price ASC LIMIT 1) AS special, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW())AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.product_id NOT IN (SELECT pd2.product_id FROM " . DB_PREFIX . "product_discount pd2 WHERE p.product_id = pd2.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW()))) GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'special',
            'rating'
        );

        if (in_array($sort, $sort_data)) {
            $sql .= " ORDER BY " . $sort;
        } else {
            $sql .= " ORDER BY pd.name";
        }

        if ($order == 'DESC') {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if ($start < 0) {
            $start = 0;
        }

        $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalProductSpecials() {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.product_id NOT IN (SELECT pd2.product_id FROM " . DB_PREFIX . "product_discount pd2 WHERE p.product_id = pd2.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())))");

        if (isset($query->row['total'])) {
            return $query->row['total'];
        } else {
            return 0;
        }
    }

    public function getProductRelated($product_id) {
        $product_data = array();

        $product_related_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

        foreach ($product_related_query->rows as $result) {
            $product_query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$result['related_id'] . "' AND pd.language_id = '" . (int)$this->language->getId() . "' AND ss.language_id = '" . (int)$this->language->getId() . "' AND p.date_available <= NOW() AND p.status = '1'");

            if ($product_query->num_rows) {
                $product_data[$result['related_id']] = $product_query->row;
            }
        }

        return $product_data;
    }

    public function getCategories($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

        return $query->rows;
    }

    // 130415 ET-130411 Begin
    public function getProductVideo($product_id) {
        $product_data = array();

        $product_video_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_video p2v JOIN " . DB_PREFIX . "video v ON (v.video_id = p2v.video_id) WHERE p2v.product_id = '" . (int)$product_id . "' ORDER BY v.sort_order");

        foreach ($product_video_query->rows as $result) {
            $video_query = $this->db->query("SELECT DISTINCT *, vd.name AS name FROM " . DB_PREFIX . "video v LEFT JOIN " . DB_PREFIX . "video_description vd ON (v.video_id = vd.video_id) WHERE v.video_id = '" . (int)$result['video_id'] . "' AND vd.language_id = '" . (int)$this->language->getId() . "' ORDER BY v.sort_order");

            if ($video_query->num_rows) {
                $product_data[$result['video_id']] = $video_query->row;
            }
        }

        return $product_data;
    }
    // 130415 ET-130411 End

    public function getEcommerceCategory($product_id) {
        $query = $this->db->query("SELECT p2c.product_id, cd.* FROM " . DB_PREFIX . "product_to_category p2c JOIN ". DB_PREFIX ."category_description cd ON (p2c.category_id = cd.category_id and cd.language_id = '" . (int)$this->language->getId() . "')  WHERE product_id = '" . (int)$product_id . "' LIMIT 1");

        return $query->row;
    }

    public function getInvalidImageProducts() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p  WHERE image LIKE '% %'");

        return $query->rows;
    }

    public function getProductsByCategoryIdYandex($category_id) {
        $query = $this->db->query("SELECT p.product_id,
                                    p.stock_status_id,
                                    p.price AS price,
                                    p.tax_class_id,
                                    p.image,
                                    p.shipping,
                                    pd.model,
                                    m.name AS manufacturer,
                                    p.serial_no,
                                    trim(pd.name) AS name,
                                    p.prepayment
                               FROM " . DB_PREFIX . "product p
                                    LEFT JOIN " . DB_PREFIX . "product_description pd
                                           ON (p.product_id = pd.product_id) 
                                    LEFT JOIN " . DB_PREFIX . "manufacturer m 
                                           ON (p.manufacturer_id = m.manufacturer_id) 
                                    LEFT JOIN " . DB_PREFIX . "product_to_category p2c 
                                           ON (p.product_id = p2c.product_id)
                                    LEFT JOIN " . DB_PREFIX . "exported_products ep 
                                           ON (p.product_id = ep.product_id)
                              WHERE p.status = '1'
                                AND p.date_available <= NOW()
                                AND pd.language_id = '" . (int)$this->language->getId() . "'
                                AND p2c.category_id = '" . (int)$category_id . "'
                                AND ep.product_id IS NULL
                              ORDER BY p.sort_order,
                                       pd.name");

        return $query->rows;
    }

    public function cleanExportedProducts() {
        $this->db->query("DELETE FROM " . DB_PREFIX ."exported_products");
    }

    public function insertExportedProductIds($category_id) {
        $this->db->query("INSERT INTO " . DB_PREFIX ."exported_products
                    SELECT DISTINCT p.product_id
                      FROM " . DB_PREFIX . "product p
                           LEFT JOIN " . DB_PREFIX . "product_description pd
                                  ON (p.product_id = pd.product_id) 
                           LEFT JOIN " . DB_PREFIX . "manufacturer m 
                                  ON (p.manufacturer_id = m.manufacturer_id) 
                           LEFT JOIN " . DB_PREFIX . "product_to_category p2c 
                                  ON (p.product_id = p2c.product_id)
                           LEFT JOIN " . DB_PREFIX . "exported_products ep 
                                  ON (p.product_id = ep.product_id)
                     WHERE p.status = '1'
                       AND p.date_available <= NOW()
                       AND pd.language_id = '" . (int)$this->language->getId() . "'
                       AND p2c.category_id = '" . (int)$category_id . "'
                       AND ep.product_id IS NULL");
    }

    // ET-151217 Begin
    public function getSalesProducts($limit = 2, $sales_products = '0') {

        $product_query = $this->db->query("SELECT p.*, pd.*
                                       FROM " . DB_PREFIX . "product p
                                             LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                                       WHERE p.status = '1'
                                         AND p.date_available <= NOW()
                                         AND pd.language_id = '" . (int)$this->language->getId() . "'
                                         ". (isset($sales_products) ? 'AND p.product_id in ('.$sales_products.')' : '') ."
                                       ORDER BY RAND() LIMIT ". $limit);

        $product_data = $product_query->rows;

        return $product_data;
    }
    // ET-151217 End

    // ET-160111-2 Begin
    public function getProductsByCategoryIdExport($category_id) {

        $product_query = $this->db->query("SELECT p.*, pd.*
                                             FROM " . DB_PREFIX . "product p
                                                  LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                                                  LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)
                                                  LEFT JOIN " . DB_PREFIX . "exported_products ep ON (p.product_id = ep.product_id)
                                            WHERE p.status = '1'
                                              AND p.date_available <= NOW()
                                              AND pd.language_id = '" . (int)$this->language->getId() . "'
                                              AND p2c.category_id = '" . (int)$category_id . "'
                                              AND ep.product_id IS NULL");

        $product_data = $product_query->rows;

        return $product_data;
    }
    // ET-160111-2 End

    public function getProductDescription($product_id){
         
         $query = $this->db->query("SELECT DISTINCT p.product_id, pd.name, pd.model FROM " . DB_PREFIX . " product p LEFT JOIN " . DB_PREFIX . " product_description pd ON (p.product_id = pd.product_id");
    
         $product = $query->row;

         return $product;
    }

    // Nikolaenko(Smithysoft) Begin
    public function getProductAkcia($product_id){

        $query = $this->db->query("SELECT DISTINCT special FROM" . DB_PREFIX . " product p WHERE p.product_id='" . (int)$product_id . "'");

        return $query->row;
    }

    public function getProductManufacturer($keyword){
        if($keyword) {
            $sql = "SELECT *, m.name FROM" . DB_PREFIX . " product p LEFT JOIN" . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) AND (m.name LIKE '%'" . $this->db->escape($keyword) . "'%')";

            $query = $this->db->query($sql);

            return $query->rows;
        } else {
            return 0;
        }
    }
    // Nikolaenko(Smithysoft) End

}
?>