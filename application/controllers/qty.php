<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qty extends Frontend_Controller {

	function __Construct()
	{
		parent::__Construct();		
		//$this->load->model('query_page');
	}
	
	function index()
	{
		$size 		= $this->uri->segment(3);
		$prod_no	= $this->uri->segment(4);
		$des_id		= $this->uri->segment(5);
		$color		= $this->uri->segment(6);
		
		//echo $this->uri->uri_string();
		
		$get_qty 	= $this->query_page->product_color_stocks($size, $color, $prod_no);
		?>
		
		<select name="qty" style="font-size:11px;width:45px;" class="qty">
		
		<?php
		if ($get_qty->num_rows() > 0)
		{
			$row 			= $get_qty->row();
			$stock_colsize	= 'size_'.$size;
			$stock_count	= $row->$stock_colsize;
			
			if ($stock_count == 0)
			{
				$msg = 'Out of stock';
			}
			else
			{
				$msg = 'In stock';
			}
			
			for ($i = 1; $i <= $stock_count; $i++)
			{ ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php
			}
			
			$stock_msg = $msg;
		}
		else
		{ ?>
			<option value=""> 0 </option>
			<?php
			$stock_msg = 'Out of stock';
		} ?>
		
		</select> &nbsp; <?php echo $stock_msg; ?>
		<?php
	}
}