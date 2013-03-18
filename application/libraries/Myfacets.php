<?php if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

class Myfacets
{
	public function __construct()
	{
	}
	
	/**
	 * Generate the facets list (by categories / by designer / by new arrival/clearance filer)
	 *
	 * @access	public
	 * @params	query string, string
	 * @return	html string
	 *
	 * $facet_field_name --> the set field name of the facet type (e.g., color_facets, styles, events, materials, trends)
	 */
	function show_facets($qry_type_facet, $facet_field_name, $exploded_type_facets)
	{
		$html = '';
		/*
		| ------------------------------------------------------------------------------------
		| This is the example query code to get the facets given subcat_id, des_id, and filer
		| Filter is for new arrivals and clearance
		|
		$colors = $this->set->get_color_facets($subcat_id, $des_id, $filter);
		*/
		
		/*
		| ------------------------------------------------------------------------------------
		| As far as viewing the facets, just follow the steps: 
		| For each prod number:
		| collect the facet and place in an array
		| explode factes where necessary
		| if not yet in the set array, store in that array
		| after storing facet, sort facet alphabetically
		| then display each sorted array
		*/
		if ($qry_type_facet && $qry_type_facet->num_rows() > 0)
		{
			// set an array to collect all facets
			$array_facet = array();
		
			// get sorte array of facets
			$array_facet = $this->extract_facets($qry_type_facet, $facet_field_name);
			
			if ($array_facet)
			{
				// display each facet in the sorted array
				foreach ($array_facet as $facet)
				{
					$checked = $exploded_type_facets != '' && in_array(strtolower($facet), $exploded_type_facets) ? 'checked="checked"' : '';
					
					$html .= '
						<div style="float:left;width:87px;font-size:8px;font-family:arial;">
							<input name="'.$facet_field_name.'[]" class="facet_group" value="'.trim(strtolower($facet)).'" onclick="submit();" type="checkbox" '.$checked.' />'.trim(strtoupper($facet)).'
						</div>
					';
				}
				
				// unset variable $checked to avoid carry over to next faceting
				$checked = '';
			}
			else
			{
				$type_of_facet = $facet_field_name == 'color_facets' ? 'colors' : $facet_field_name;
				$html = '
					<br /><span style="font-family:arial;margin-left:3px;">
					No '.ucfirst($type_of_facet).' Facets
					</span>
				';
			}
		}
		else
		{
			$type_of_facet = $facet_field_name == 'color_facets' ? 'colors' : $facet_field_name;
			$html = '
				<br /><span style="font-family:arial;margin-left:3px;">
				No '.ucfirst($type_of_facet).' Facets
				</span>
			';
		}
		
		return $html;
	}

	function extract_facets($qry_type_facet, $facet_field_name)
	{
		// set an array to collect all facets
		$array_facet = array();
		
		if ($qry_type_facet && $qry_type_facet->num_rows() > 0)
		{
			$i = 0;
			foreach ($qry_type_facet->result_array() as $facet_data)
			{
				if ($facet_data[$facet_field_name] != NULL)
				{
					// explode facet data where necessary
					$exploded_1 = explode('-',$facet_data[$facet_field_name]);
					foreach ($exploded_1 as $facet)
					{
						// clean facets for unwanted characters if entered via CSV
						$facet = str_replace(
							array('"','&'),
							array('','and'),
							$facet
						);
						
						// check for two worded facets and replace underscore with space
						$facet = str_replace('_',' ',$facet);
						
						// check for 4 chars facets with #1 at the end and remove it
						// the 1 as 4th char is for the MySQL search feature shortcoming
						$pos = strpos($facet,'1');
						if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
						
						// use lower caps in array
						if ( ! in_array(trim(strtolower($facet)),$array_facet))
						{
							// if not in array, store in array
							$array_facet[$i] = trim(strtolower($facet));
							$i++;
						}
					}
				}
			}
			
			// sort array alphabetically
			sort($array_facet);
		}
		
		return $array_facet;
	}
}
