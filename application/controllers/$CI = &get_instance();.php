$CI = &get_instance();

				// Create the dynamic body
				$sku_code = $this->model->selectWhereData('tbl_sku_code_master', array('id' => $product_sku_code), 'sku_code', true);
				$dynamic_body = '
						<h2>Inventory Details!</h2>
						<p>Product: <strong>' . $product_name . '(' . $sku_code['sku_code'] . ')' . '</strong></p>
						<p>Quantity Added: <strong>' . $add_quantity . '</strong></p>
						<p>Batch No: <strong>' . $batch_no . '</strong></p>
					';

				// Load the email template
				$email_message = $this->load->view('email_template', [
					'dynamic_body_content' => $dynamic_body,
					'subject' => 'New Stock Added - ' . $product_name . '(' . $sku_code['sku_code'] . ')',
				], true);  // true = return as string

				// Now send the email using your helper
				$to_email = "shirin@sda-zone.com"; // Replace with actual receiver
				$subject = 'New Stock Added - ' . $product_name . '(' . $sku_code['sku_code'] . ')';

				$send = send_inventory_email($to_email, $subject, $email_message);



				$CI = &get_instance();

				// Create the dynamic body
				$sku_code = $this->model->selectWhereData('tbl_sku_code_master', array('id' => $product_sku_code), 'sku_code', true);
				$dynamic_body = '
						<h2>Inventory Details!</h2>
						<p>Product: <strong>' . $product_name . '(' . $sku_code['sku_code'] . ')' . '</strong></p>
						<p>Quantity Added: <strong>' . $add_new_quantity . '</strong></p>
						<p>Batch No: <strong>' . $add_new_batch_no . '</strong></p>
					';
				// Load the email template
				$email_message = $this->load->view('email_template', [
					'dynamic_body_content' => $dynamic_body,
					'subject' => 'New Batch Added For - ' . $product_name . '(' . $sku_code['sku_code'] . ')',
				], true);  // true = return as string

				// Now send the email using your helper
				$to_email = "shirin@sda-zone.com"; // Replace with actual receiver
				$subject = 'New Stock Added - ' . $product_name . '(' . $sku_code['sku_code'] . ')';







				$this->db->select("
            tbl_product_master.product_name,
            tbl_product_master.product_sku_code,
            tbl_sku_code_master.sku_code,
            tbl_product_inventory.add_quantity,
            SUM(tbl_product_inventory.deduct_quantity) as total_deducted_quantity,
            tbl_product_inventory.total_quantity,
            tbl_product_inventory.reason,
            tbl_sale_channel.sale_channel
        ");