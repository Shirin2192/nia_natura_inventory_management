public function upload_order_excel()
	{
		$this->load->library('upload');
		require_once FCPATH . 'vendor/autoload.php';
		$this->load->library('email'); // Load Email Library

		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];

		require_once FCPATH . 'vendor/autoload.php';

		$uploadPath = FCPATH . 'uploads/rejected_excels/';

		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0777, true);
		}

		if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['name'] != '') {
			$fileTmpPath = $_FILES['excel_file']['tmp_name'];

			try {
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmpPath);
				$sheet = $spreadsheet->getActiveSheet();
				$data = $sheet->toArray();

				// $insertData = []; 
				$rejectedData = [];

				// Add headers + rejection reason header
				$headers = $data[0];
				$headers[] = 'Rejection Reason';

				for ($i = 2; $i < count($data); $i++) {
					$row = $data[$i];
					$sku_code     = trim($row[0]);
					$batch_no     = trim($row[1]);
					$channel_type = trim($row[2]);
					$sale_channel = trim($row[3]);
					$quantity     = trim($row[4]);
					$reason     = trim($row[5]);
					$order_type     = trim($row[6]);

					// Validate SKU
					$skuValid = $this->model->selectWhereData('tbl_sku_code_master', [
						'sku_code' => $sku_code,
						'is_delete' => 1
					], 'id', true);

					if (!$skuValid) {
						$row[] = 'Invalid SKU Code';
						$rejectedData[] = $row;
						continue;
					}

					$$inventory_type['id'] = $this->model->selectWhereData('tbl_inventory_entry_type',array('name'=>$order_type,'is_delete'=>'1'),'id',true);
					if(!$inventory_type['id']){
						$row[]='Invalid Order Type';
						$rejectedData[] = $row;
						continue;
					}

					// Validate product
					$product = $this->model->selectWhereData('tbl_product_master', [
						'product_sku_code' => $skuValid['id'],
						'is_delete' => 1
					], 'id', true);

					if (!$product) {
						$row[] = 'Product not found for SKU';
						$rejectedData[] = $row;
						continue;
					}

					$product_id = $product['id'];

					// Validate batch
					$batchValid = $this->model->selectWhereData('tbl_product_batches', [
						'batch_no' => $batch_no,
						'fk_product_id' => $product_id
					], 'id', true);

					if (!$batchValid) {
						$row[] = 'Invalid batch for product';
						$rejectedData[] = $row;
						continue;
					}

					// Validate sale channel
					$sale_channel_id = $this->model->selectWhereData('tbl_sale_channel', [
						'sale_channel' => $sale_channel,
						'is_delete' => 1
					], 'id', true);

					if (!$product_id || !$batchValid['id'] || !$sale_channel_id || !is_numeric($quantity)) {
						$row[] = 'Invalid data or quantity not numeric';
						$rejectedData[] = $row;
						continue;
					}

					// Get last inventory quantity
					$last_quantity = $this->model->selectWhereData('tbl_product_inventory', [
						'fk_product_id' => $product_id,
						'fk_batch_id' => $batchValid['id'],
						'used_status' => 1
					], 'total_quantity,id,fk_inventory_entry_type,fk_sourcing_partner_id', true, ['id' => 'DESC']);

					if (!empty($last_quantity)) {
						$previous_quantity = $last_quantity['total_quantity'];

						$inventory_id = $last_quantity['id'];
						// Inventory type validations
					if ($$inventory_type['id'] == 3 || $$inventory_type['id'] == 5) {
						if ($quantity > $previous_quantity) {
							$row[] = 'Quantity exceeds available stock';
							$rejectedData[] = $row;
							continue;
						}
					}

					if ($$inventory_type['id'] == 4) {
						$total_sold_qty = $this->Product_Model->get_total_sold_quantity($product_id, $batchValid['id']);
						$total_returned_qty = $this->Product_Model->get_total_returned_quantity($product_id, $batchValid['id']);

						if (($total_returned_qty + $quantity) > $total_sold_qty) {
							$row[] = 'Return quantity exceeds total sold quantity';
							$rejectedData[] = $row;
							continue;
						}
					}

					if ($$inventory_type['id'] == 5) {
						$total_returned_qty = $this->Product_Model->get_total_returned_quantity($product_id, $batchValid['id']);
						$total_damaged_qty = $this->Product_Model->get_total_damaged_quantity($product_id, $batchValid['id']);

						if (($total_damaged_qty + $quantity) > $total_returned_qty) {
							$row[] = 'Damaged quantity exceeds returned quantity';
							$rejectedData[] = $row;
							continue;
						}
					}
					// Final quantity logic
					$total_quantity = ($$inventory_type['id'] == 4)
						? $previous_quantity + $quantity
						: $previous_quantity - $quantity;

					if ($total_quantity < 0) {
						$row[] = 'Resulting quantity would be negative';
						$rejectedData[] = $row;
						continue;
					}
					// Deactivate previous
					$this->model->updateData('tbl_product_inventory', [
						'used_status' => 0,
						'is_delete' => '0'
					], ['fk_product_id' => $product_id, 'fk_batch_id' => $batchValid['id']]);

						$insertData = [
							'fk_product_id'       => $product_id,
							'fk_batch_id'         => $batchValid['id'],
							'channel_type'        => $channel_type,
							'fk_sale_channel_id'  => $sale_channel_id['id'],
							'total_quantity'      => $total_quantity,
							'used_status'         => 1,
							'reason'			  => $reason,
							'fk_login_id'		  => $login_id,
							'fk_inventory_entry_type' => $last_quantity['fk_inventory_entry_type'],
							'fk_sourcing_partner_id' => $last_quantity['fk_sourcing_partner_id']
							
						];
						if ($$inventory_type['id'] == 3) {
							$insertData['deduct_quantity'] = $quantity;
							$insertData['fk_inventory_entry_type_sale_id'] = $$inventory_type['id'];
						} elseif ($$inventory_type['id'] == 4) {
							$insertData['add_quantity'] = $quantity;
							$insertData['fk_inventory_entry_type_return_id'] = $$inventory_type['id'];
						} elseif ($$inventory_type['id'] == 5) {
							$insertData['deduct_quantity'] = $quantity;
							$insertData['fk_inventory_entry_type_damage_id'] = $$inventory_type['id'];
						}

						$this->model->insertData('tbl_product_inventory', $insertData);
						$this->model->addUserLog($login_id, 'Insert Product Inventory', 'tbl_product_inventory', $insertData);
					} else {
						$row[] = 'No previous inventory found';
						$rejectedData[] = $row;
						continue;
					}

					// Add to imported_products array
					$imported_order[] = [
						'SKU' => $row[0],
						'Batch No' => $row[1],
						'Channel Type' => $row[2],
						'Sales Channel' => $row[3],
						'Quantity' => $row[4],
						'Reason' => $row[5],		
					    'Order Type' => $row[6]		
					];
				}
				// Generate rejection Excel
				if (!empty($rejectedData)) {
					$rejectedSheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
					$sheet = $rejectedSheet->getActiveSheet();

					$sheet->fromArray($headers, NULL, 'A1');
					$sheet->fromArray($rejectedData, NULL, 'A2');

					$fileName = 'rejected_orders_' . time() . '.xlsx';
					$filePath = $uploadPath . $fileName;

					$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($rejectedSheet, 'Xlsx');
					$writer->save($filePath);

					$downloadUrl = base_url('uploads/rejected_excels/' . $fileName);

					$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status'       => 'partial',
						'message'      => 'Some rows were rejected.',
						'rejected_url' => $downloadUrl
					]));
					return;
				}else {
				// 	$this->sendImportEmail('', "All order data uploaded successfully!.", $imported_products, 'Quantity Deducted');
	
					$this->output
						->set_content_type('application/json')
						->set_output(json_encode([
							'status'  => 'success',
							'message' => 'All order data uploaded successfully.'
						]));
					return;
				}			
			} catch (Exception $e) {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode([
							'status'  => 'error',
							'message' => 'Invalid Excel file or error: ' . $e->getMessage()
						]));
					return;
			}
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => "error",
					'message' => "No file selected!"
				]));
			return;
		}
	}