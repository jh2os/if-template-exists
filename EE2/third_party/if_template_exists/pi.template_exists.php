<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Check if a template and template group exists on ExpressionEngine site
 *
 * @package		If Template Exists
 * @category	Plugin
 * @author		Johnathan Waters
 * @copyright	2014, Johnathan Waters
 * @link 		http://johnathan-waters.com
 */

class Template_exists
{  			
	
	/**
	 * Template Exists
	 *
	 * Returns "TRUE" if template exists defined in EE tag 
	 * parameters and "FALSE" if it does not
	 * 
	 * @return String
	 */
	function Template_exists()
	{
		// make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
		
		// Get the template parameter from ee tag
		$templateParam = $this->EE->TMPL->fetch_param('template');
		
		// Seperate our template group and template
		$template = explode('/', $templateParam);
		
		// Lets make sure that our developer has actually included anything
		if ($templateParam) 
		{	
			$this->return_data = '';	
		} 
		else 
		{
			// Query in EE template table for our names
			$query = ee()->db->select('template_id')
						->from('templates t')
						->join('template_groups g', 't.group_id = g.group_id')
						->where(array(
							'g.group_name' => $template[0],
							't.template_name' => $template[1]
								))
						->limit(1)
						->get();
			
			// Look at what I found mom!
			if($query->num_rows() > 0)
			{
				$this->return_data = 'TRUE';
			}
			// Not everyone finds gold in the Yukon 
			else 
			{
				$this->return_data = 'FALSE';
			}
		}

	}
	
	/**
	 * Usage
	 *
	 * Outputs this information in ExpressionEngine Control Pannel 
	 * when looking at this plugin
	 *
	 * @return ob buffer
	 */
	public static function usage()
	{
		ob_start(); ?>
This plugin simply tells you if a template-group/template exists on your site or not

{if {exp:template_exists template='foo/bar'} == 'TRUE'}
	[template exists]
{/if}

{if {exp:template_exists template='foo/bar'} == 'FALSE'}
	[template does not exists]
{/if}
		<?php 
		$buffer = ob_get_contents();
		ob_end_clean();
		
		return $buffer;
	}


// END CLASS

/* End of file pi.template_exists.php */
/* Location: ./system/expressionengine/third_party/if_template_exists/pi.template_exists.php */
