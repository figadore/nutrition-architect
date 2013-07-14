<?php 
namespace Food\View\Helper;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * Draws a pie chart showing portions remaining 
 */
class PieHelper extends AbstractHelper
{

	protected $radius;
	protected $padding;


	/**
	 * Inject params for pie generation
	 *
	 * @param	int			$radius			radius of arc/ellipse in pixels
	 * @param	int			$padding 	 	padding in pixels from the top and 
	 		left edges
	 */
	public function __construct($radius, $padding)
	{
		$this->radius = $radius;
		$this->padding = $padding;
	}

	/**
	 * Called with $this->pie() in a view script
	 *
	 * @param	int			$total 			number of portions in a batch
	 * @param	int			$remaining  	how many pieces are left
	 * @param	bool		$backwards 		whether the pieces should be drawn 
	 		starting on the right side instead of the left
	* @param	int			$radius			radius of arc/ellipse in pixels, 
			defaults to ivar 
	* @param	int			$padding 	 	padding in pixels from the top and 
			left edges, defaults to ivar 
	 * @return 	string						HTML to output	
	 */
	public function __invoke($total, $remaining, $backwards=false, 
			$radius = null, $padding = null)
	{
		//check for radius/padding override
		$radius = ($radius===null)?$this->radius:$radius;
		$padding = ($padding===null)?$this->padding:$padding;

		//center of arc/ellipse
		$originX = $radius+$padding; 
		$originY = $radius+$padding;
		
		//offsets to add to relative position for arc endpoint
		$startX = 0;
		$startY = $radius;

		
		//get coordinates of portion start/end points for divider lines
		$portionAngleDegrees = (1/$total)*360;
		$portionAngle = pi()*($portionAngleDegrees)/180;
		$coordinates = array();
		for ($i=0; $i<$total; $i++)
		{
			$angle = $i*$portionAngle;
			$y = -round(cos($angle)*$radius);
			$x = round(sin($angle)*$radius);
			$coordinates[$i] = array($x, $y);
		}
		
		//other arc params
		$rotation=0; 
		$missingPercent = ($total - $remaining ) / $total;
		$angleDegrees = $missingPercent*360;
		$angle = pi()*($angleDegrees)/180;
		//large-arc flag, true if angle > 180 degrees
		$largeArc = (int) (($angleDegrees%360) > 180); 
		$xSign = ($backwards)?-1:1; //invert X if $backwards specified
		$sweep=($backwards)?0:1; //use other arc section if $backwards specified

		//find arc endpoint with trigenometry
		$y = -round(cos($angle)*$radius);
		$x = round(sin($angle)*$radius)*$xSign;
		$y += $startY;
		$x += $startX;

		//aggregate html output for svg arc/ellipse
		$result = "";
		$result .= "<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\">";
		//arc start and end point would be the same, so use an ellipse instead
		if ($total === $remaining) 
		{
			$largeArc=1-$largeArc;
			$sweep=1-$sweep;
			$result .= "<ellipse class=\"remaining\" cx=\"$originX\" 
					cy=\"$originY\" rx=\"$radius\" ry=\"$radius\" />";
		}
		else
		{
			//draw missing pieces
			$result .= "<path class=\"gone\" d=\"M $originX,$originY l 
					0,-$radius a$radius,$radius $rotation $largeArc,$sweep 
					$x, $y z \" />";

			//switch arc flags so the other arc in the same circle can be drawn
			$largeArc=1-$largeArc;
			$sweep=1-$sweep;

			//draw remaining pieces
			$result .= "<path class=\"remaining\" d=\"M $originX,$originY l 
					0,-$radius a$radius,$radius $rotation $largeArc,$sweep $x, 
					$y z \" />";
		}

		//draw divider lines for each portion, but only if there is more than 
		//one portion
		if (count($coordinates) > 1)
		{
			foreach ($coordinates as $coordinate)
			{
				$result .= "<path class=\"divider\" d=\"M $originX,$originY l "
					.$coordinate[0].",".$coordinate[1]." z \" />";
			}
		}
		$result .= "</svg>";
		return $result;
	}

}
